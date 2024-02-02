@extends("client.layout.index")

@section("content")
<section class="block-content-policy">
  <div class="container">
    <h1 class="fz-36 font-weight-bold">Payment Methods</h1>
    <div class="entry-content">
      <p>We accept credit, debit, and prepaid cards issued by the following networks: VISA/MasterCard
      </p>
      <p>We also accept PayPal – the most popular online payment method worldwide</p>
      <p>When you place order with Paypal, you will be redirected to the PayPal payment page where you
        are required to log on to your Paypal account with your username and password. If Paypal
        does not support your currency, your payment will automatically be charged in US dollars.
      </p>
      <p>If you have some trouble making a payment, please see some helpful suggestions below:</p>
      <p><strong>My payment won’t go through, what should I do?</strong></p>
      <p><strong>If you’re unable to pay with your debit or credit card.</strong></p>
      <ol>
        <li>Make sure all information is correct including the credit card number, expiration date,
          CVV code and billing address.</li>
        <li>Check your credit or debit account balance for available funds.</li>
        <li>Check whether your card is authorized or default online transaction limit is too low.
        </li>
        <li>Try refreshing the page or logging completely out and then logging back in.</li>
        <li>Start over with a new order instead of trying to pay for the same order over again.</li>
        <li>If your payment is still declined, you may need to contact your bank. As part of their
          security, most credit card companies will automatically block international transactions
          or payments unless the card holders specifically request that they accept the
          transaction.</li>
        <li>Pay with your credit or debit card through Paypal. If you do not have a Paypal account,
          you can safely and easily use the services as a “guest”.</li>
        <li>Try using a different card.</li>
        <li>Try through PayPal if you have a PayPal account.</li>
      </ol>
      <p><strong>If you‘re unable to pay with Paypal</strong></p>
      <ol>
        <li>Check with Paypal to see if your account has a transaction limit.</li>
        <li>According to PayPal rules, the shipping address and the billing address must be in the
          same country, otherwise the payment will be declined.</li>
      </ol>
      <p>If Paypal is still not working, please try payment with a debit or credit card (Visa,
        MasterCard, Discover, and American Express).</p>
    </div>
  </div>
</section>
@endsection
@extends('client.layout.index')

@section('content')
<section class="block-cart">
  <div class="container">
    <h1 class="fz-36 font-weight-bold">Cart</h1>
    <div class="entry-content">
      <div class="block-cart-content">
        <form class="cart-form" action="{{ route('cart.update') }}" method="post">
          {{ csrf_field() }}
          <div class="cart-sidebar-content">
            <table class="shop_table table-cart cart-form-contents" cellspacing="0">
              <thead>
                <tr>
                  <th class="product-remove">&nbsp;</th>
                  <th class="product-name" colspan="2">Product</th>
                  <th class="product-price">Price</th>
                  <th class="product-quantity">Quantity</th>
                  <th class="product-subtotal">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($cartItems as $cartItem)
                <tr class="cart-form__cart-item cart_item">
                  <td class="product-remove">
                    <a href="#" class="cart-item-remove remove" data-url-submit="{{ route('cart.destroy', $cartItem->rowId) }}">×</a>
                  </td>
                  <td class="product-thumbnail">
                    <a href="#"><img src="{{ $cartItem->cover ?? asset('images/NoData.png') }}" class="img-thumbnail" alt="" decoding="async" loading="lazy"></a>
                  </td>
                  <td class="product-name" data-title="Product">
                    <a href="#">{{ $cartItem->name }}</a>
                  </td>
                  <td class="product-price" data-title="Price">
                    <span class="price-amount amount"><bdi><span class="price-currencysymbol">{{ config('cart.currency_symbol') }}</span>{{ $cartItem->price }}</bdi></span>
                  </td>
                  <td class="product-quantity" data-title="Quantity">
                    <div class="product-item-quantity">
                      <div class="block-quantity">
                        <label for="quantity"></label>
                        <div class="button-click p-2">
                          <button class="quantity-arrow-minus" data-id="{{ $cartItem->rowId }}" type="button"><img src="assets/img/icons/icon-minus.svg" width="14" alt="-"></button>
                        </div>
                        <input type="number" class="input-number cart-qty-input" id="quantity-{{ $cartItem->rowId }}" data-id="{{ $cartItem->rowId }}" name="quantity" min="1" max="100" value="{{ $cartItem->qty }}" />
                        <input type="hidden" id="cart-item-{{ $cartItem->rowId }}" name="cart_items[]" value="{{ $cartItem->rowId . ',' . $cartItem->qty}}">
                        <div class="button-click p-2">
                          <button type="button" data-id="{{ $cartItem->rowId }}" class="quantity-arrow-plus">
                            <img src="assets/img/icons/icon-add.svg" width="14"></button>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="product-subtotal" data-title="Subtotal">
                    <span class="price-amount amount"><bdi><span class="Price-currencySymbol">{{ config('cart.currency_symbol') }}</span>{{ number_format(($cartItem->qty*$cartItem->price), 2) }}</bdi></span>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="actions">
                    <button type="submit" class="btn btn-update-cart" name="update_cart" value="Update cart" disabled>Update cart</button>
                    <input type="hidden" id="cart-nonce" name="cart-nonce" value="d07f8024ae"><input type="hidden" name="_wp_http_referer" value="/cart/">
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </form>
        <div class="cart-collaterals">
          <div class="cart-totals">
            <!--h2>Cart totals</h2-->
            <table cellspacing="0">
              <tbody>
                <tr class="cart-subtotal">
                  <th>Subtotal</th>
                  <td data-title="Subtotal"><span class="price-amount amount"><bdi><span class="Price-currencySymbol">{{ config('cart.currency_symbol') }}</bdi>{{ $subtotal }}</span>
                  </td>
                </tr>
                <tr class="shipping-totals shipping">
                  <th>Shipping</th>
                  <td data-title="Shipping">
                    <ul id="shipping_method" class="shipping-methods">
                      <li>
                        <input type="hidden" name="shipping_method[0]" data-index="0" id="shipping_method_0_flat_rate3" value="flat_rate:3" class="shipping_method"><label for="shipping_method_0_flat_rate3">Secured Shipping:
                          <span class="price-amount amount font-bold"><bdi><span class="Price-currencySymbol">{{ config('cart.currency_symbol') }}</span>{{ $shippingFee }}</bdi></span></label>
                      </li>
                    </ul>
                    <p class="shipping-destination">
                      Shipping options will be updated during checkout. </p>
                  </td>
                </tr>
                <!-- <tr class="fee">
                  <th>Tip</th>
                  <td data-title="Tip"><span class="price-amount amount"><bdi><span class="Price-currencySymbol">$</span>5.00</bdi></span>
                  </td>
                </tr> -->
                <tr class="order-total">
                  <th>Total</th>
                  <td data-title="Total"><strong><span class="price-amount amount"><bdi><span class="Price-currencySymbol">{{ config('cart.currency_symbol') }}</span>{{ $total }}</bdi></span></strong>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="wc-proceed-to-checkout">
              <a href="/page-checkout.html" class="btn btn-checkout-button">
                Proceed to checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section("js")
<script>
  jQuery(document).ready(function($) {
    $('.cart-item-remove').on('click', function(e) {
      e.preventDefault()
      if (confirm('Are you sure?')) {
        const url = $(this).data('url-submit')
        var formElement = $('<form>', {
          id: url,
          action: url,
          method: 'post'
        });

        // Create an input element
        var csrfTokenInput = $('<input>', {
          name: '_token',
          value: '{{ csrf_token() }}',
        });

        var methodInput = $('<input>', {
          name: '_method',
          value: 'delete',
        });

        // Create a submit button
        var submitButton = $('<input>', {
          type: 'submit',
        });

        // Append the input and submit button to the form
        formElement.append(csrfTokenInput, methodInput, submitButton);

        // Append the form to the container in the DOM
        $('body').append(formElement);
        submitButton.click()
      }
    })

  })
</script>
@endsection
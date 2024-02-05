@extends('client.layout.index')

@section('content')
<!-- section block-product-->
<section class="block-product block-card pb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="block-slider-product">
          <div class="slider slider-for">
            @if (isset($images) && !$images->isEmpty())
            @foreach ($images as $key => $image)
            <div class="item-slider">
              <a href="#item-{{ $key+1 }}" data-o_href=""><img src="{{ asset("storage/$image->src") }}" alt="{{ $product->name }}"></a>
            </div>
            @endforeach
            @else
            <div class="item-slider">
              <a href="#item-no-image" data-o_href=""><img src="{{ asset('images/NoData.png') }}" alt="{{ $product->name }}"></a>
            </div>
            @endif
          </div>
          <div class="slider slider-nav">
            @if (isset($images) && !$images->isEmpty())
            @foreach ($images as $key => $image)
            <div class="item-slider">
              <img src="{{ asset("storage/$image->src") }}" alt="{{ $product->name }}">
            </div>
            @endforeach
            @endif
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="block-summary">
          <!-- //rate -->
          <div class="block-product-rating">
            Rated
            <!-- check điều kiện add thêm class star-rating -->
            <div class="star-rating star-no-rating">
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
            </div>
          </div>
          <!-- //title -->
          <h1 class="product_title fz-30 font-bold">{{ $product->name }}</h1>
          <p class="text-price fz-25"><span class="price"><span class="price-small fz-17 @if ($productAttributeDefault || $product->sale_price) text-line-through @endif" id="price">{{ config('cart.currency_symbol') }}{{ $productAttributeDefault->price ?? $product->price }}</span>
          @if ($productAttributeDefault || $product->sale_price)
          <span class="price-big clr-red" id="sale-price">{{ config('cart.currency_symbol') }}{{ $productAttributeDefault->sale_price ?? $product->sale_price }}</span></span></p>
          @endif
          <!-- <div id="sales-countdown" class="mb-2">
            <strong>Last Minute</strong>
            -
            Sale end in <span class="font-weight-bold clr-red" data-time="884">14m 45s</span>
          </div> -->

          <!-- //list button click img -->
          @include('layouts.errors-and-messages')
          <form action="{{ route('cart.store') }}" id="addToCartForm" class="form-inline" method="post">
            {{ csrf_field() }}
            @if (isset($productAttributes) && !$productAttributes->isEmpty())
            <h3 class="title-quantity my-3">Quantity</h3>
            <ul class="check-list-quantity d-flex" role="radiogroup" aria-label="Quantity" data-attribute_name="attribute_quantity" data-attribute_values="[]">
              @foreach ($productAttributes as $key => $productAttribute)
              <li aria-checked="true" data-item-price="{{ config('cart.currency_symbol') }} {{ $productAttribute->price }}" data-item-sale-price=" {{ config('cart.currency_symbol') }} {{ $productAttribute->sale_price }}" data-id="{{ $productAttribute->id }}" class="check-variable-item @if($productAttribute->default) selected @endif" role="radio">
                <img src="/assets/img/icons/conner_checked.svg" class="conner-checked-style">
                <div class="variable-item-contents"><span class="variable-item-span">
                    @foreach ($productAttribute->attributesValues as $value)
                    {{ ucwords($value->value) }}
                    @endforeach
                  </span>
                </div>
              </li>
              @endforeach
            </ul>
            @endif
            <!-- //add-cart -->
            <div class="d-lg-flex d-xl-flex d-block d-xs-block d-sm-flex align-items-center mt-4 w-100">
              <div class="block-quantity">
                <label for="quantity"></label>
                <div class="button-click p-2">
                  <button type="button" class="quantity-arrow-minus" data-id="{{ $product->id }}"><img src="assets/img/icons/icon-minus.svg" width="14" alt="-"></button>
                </div>
                <input type="number" class="input-number" id="quantity-{{ $product->id }}" data-id="{{ $product->id }}" name="quantity" min="1" max="100" value="1" />
                <div class="button-click p-2">
                  <button type="button" class="quantity-arrow-plus" data-id="{{ $product->id }}"><img src="assets/img/icons/icon-add.svg" width="14"></button>
                </div>
              </div>

              <input type="hidden" name="product" value="{{ $product->id }}" />
              <input type="hidden" name="productAttribute" id="product-attribute" value="{{ $productAttributeDefault->id ?? '' }}" />
              <button type="submit" class="btn btn-single-cart btn-add-cart">
                <img src="/assets/img/icons/icon-cart.svg" alt="">
                Add to cart
              </button>

              <input type="hidden" name="isCheckout" id="isCheckout" value="0">
              <button type="button" id="buy-now-btn" class="btn btn-single-cart btn-buy-now">
                <img src="/assets/img/icons/icon-wallet.svg" alt="">
                Buy now
              </button>
            </div>
          </form>
          <!-- //paypal -->
          <!-- <div id="mecom-paypal-credit-form-container-custom">
            <div id="paypal-button-express-or-text" class="text-center my-2">- OR -</div>
            <button class="btn btn-pay-pal"><img src="assets/img/icons/icon-paypal.svg" alt=""></button>
          </div> -->
          <!-- //checkout -->
          <!-- <div class="safe-checkout nasa-crazy-box mt-4 mt-lg-5">
            <fieldset>
              <legend class="text-center font-bold fz-15">Guaranteed Safe Checkout</legend>
              <img class="nasa-image lazyloaded" src="assets/img/trustbadge_footer.png" alt="Trust" width="838" height="81" data-ll-status="loaded" data-large_image_width="838" data-large_image_height="81">
              <noscript><img class="nasa-image" src="assets/img/trustbadge_footer.png" alt="Trust" width="838" height="81" /></noscript>
            </fieldset>
            <div id="dcmm-phake-sales" class="text-center fz-14 mt-4">
              <strong class="clr-red">Limited Stock!</strong>
              <strong id="viewing-count">8800</strong> people are viewing this and
              <strong id="purchased-count">9708</strong> purchased it.
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end -->
<!-- section block-product-->
<section class="section-content-description bg-white">
  <div class="container py-4 py-lg-5">
    <div class="row mb-5">
      <div class="col-12 col-lg-3 mb-3 col-sm-4">
        <h2 class="m-0 fz-25 font-weight-bold">Description</h2>
      </div>
      <div class="col-12 col-lg-9 col-sm-8" id="description-content">
        {!! $product->description !!}
      </div>
    </div>
  </div>
</section>
<!-- end -->
<section class="shipping-policy clear-both pt-5" id="shipping-policy">
  <div class="container">
    <div class="row pb-3">
      <div class="col-12 col-lg-3 mb-3 col-sm-4">
        <h1 style="line-height: 1.5" class="m-0">Shipping <br>&amp; Returns</h1>
      </div>
      <div class="col-12 col-lg-9 col-sm-8">
        <p>
          We stand by our product quality. If you are not pleased with your purchase, we offer a
          7-day
          quality guarantee on all products. If you have any additional questions or would like to
          request
          return, refund, exchange, feel free to contact us at
          <a class="text-primary" href="mailto: help@topswift.support">help@topswift.support</a>.
        </p>
        <p>
          Learn more about our return, refund, and exchange policies <a class="text-primary" href="/return-policy/">here</a>.
        </p>
        <p>
          Order processing &amp; shipping time within 3-5 days, and delivery time within 14-21
          business days
          from shipping date. During high volume periods, the processing time may take an
          additional 2-4
          business days . Learn more about shipping FAQs <a class="text-primary" href="/faqs">here</a>.
        </p>
        <p>
          On average, the shipping fee is $4.95 per unit. However, shipping fee may vary due to
          promotional activities. Please visit the checkout page to obtain your final shipping
          charges.
        </p>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
  jQuery(document).ready(function($) {
    $('.check-variable-item').on('click', function() {
      const el = $(this)
      const find = $('.check-list-quantity').find('.selected').removeClass('selected')
      el.addClass('selected')
      const id = el.data('id')
      const price = el.data('item-price')
      const salePrice = el.data('item-sale-price')
      $('#price').html(price)
      $('#sale-price').html(salePrice)
      $('#product-attribute').val(id)
    })

    $('#buy-now-btn').on('click', function() {
      $('#isCheckout').val(1)
      $('#addToCartForm').submit()
    })
  })
</script>
@endsection
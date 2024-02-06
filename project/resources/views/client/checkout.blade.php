<!DOCTYPE html>
<!-- <html lang="ar" dir="rtl" joom="1" translate="no"> -->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Checkout</title>
  <meta name="keywords" content="Checkout">
  <meta name="news_keywords" content="Checkout">
  <meta name="description" content="Checkout">
  <meta property="og:image" content="">
  <meta property="og:image:alt" content="Checkout">
  <meta property="og:type" content="article">
  <meta property="og:title" content="Fees">
  <meta property="og:locale" content="vi_VN" data-qmeta="og_locale">
  <meta property="og:url" content="">
  <meta property="og:description" content="Checkout">
  <link rel="icon" href="assets/img/TopSwift.png" type="image/x-icon">
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link type="text/css" href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/slick.css" rel="stylesheet" />
  <!-- Place favicon.ico in the root directory-->
  <!-- build:css assets/css/font-awesome.css-->
  <link rel="stylesheet" href="assets/css/font-awesome.css">
  <!-- endbuild-->
  <!-- <link rel="stylesheet" href="assets/css/main.css"> -->
  <!-- build:css assets/css/template.css-->
  <link rel="stylesheet" href="assets/css/template.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <!-- endbuild-->
</head>

<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="product">
        <div class="product-notices-wrapper"></div>
        <form name="checkout" method="post" class="checkout product-checkout" id="checkout-form" autocomplete="off" action="{{ route('checkout.submit') }}" enctype="multipart/form-data" novalidate="novalidate">
        <div class="row">
          <!-- left-cart -->
          <div class="col-12 col-md-6 bg-white-2">
            <div class="row">
              <div class="col-sm-12 col-lg-9 offset-lg-2">
                <div class="review-order-header">
                  <div class="logo">
                    <img src="assets/img/TopSwift.png">
                  </div>
                  <!-- <img class="d-none d-sm-block img-trusted" src="assets/img/icons/trusted.svg"> -->
                </div>
                <div class="order-summary">
                  <div class="order-summary-header">
                    <div class="wapper-collapse">
                      <div class="left-cart d-flex align-items-center">
                        <img src="assets/img/icons/cart_grey.svg">
                        <span class="chevron-up">Show order summary</span>
                        <span class="chevron-down">Hide order summary</span>
                        <img src="assets/img/icons/chevron_down.svg" class="chevron-up">
                        <img src="assets/img/icons/chevron_up.svg" class="chevron-down">

                      </div>
                      <div id="header-cart-total" class="float-right d-inline-block">
                        <strong class="mr-2">Total</strong>
                        <span class="price-amount amount"><bdi><span class="price-currencysymbol">{{ config('cart.currency_symbol') }}</span>{{ $total }}</bdi></span>
                      </div>
                    </div>

                  </div>
                  <div class="order-summary-content">
                    <h4>
                      <strong>Order summary</strong>

                      <span class="back-to-cart">
                        <a href="{{ route('cart.list') }}">
                          ← back to Cart
                        </a>
                      </span>
                    </h4>
                    <!-- table list order -->
                    <div class="table-list-order table-responsive-lg">
                      <table class="shop_table product-checkout-review-order-table">
                        <tbody>
                          @foreach($cartItems as $cartItem)
                          <tr class="cart_item">
                            <td rowspan="2">
                              <img src="{{ $cartItem->cover ?? asset('images/NoData.png') }}" width="120">
                            </td>
                            <td class="product-name">{{ $cartItem->name }}</td>
                            <td class="product-total text-right pr-0">
                              <span class="product-Price-amount amount"><bdi><span class="product-Price-currencySymbol">{{ config('cart.currency_symbol') }}</span>{{ $cartItem->price }}</bdi></span>
                              <!-- <br>
                                <del class="font-italic">
                                  <span class="product-Price-amount amount"><bdi><span class="product-Price-currencySymbol">{{ config('cart.currency_symbol') }}</span>{{ $cartItem->price }}</bdi></span>
                                </del> -->
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" class="pt-0 pb-4" valign="top" style="vertical-align: top">
                              <div class="row">
                                <div class="item-attr col-6 fz-12">
                                  <b>Qty: </b>{{ $cartItem->qty }}
                                </div>
                                <div class="item-attr col-6">
                                  @if($cartItem->options->has('combination'))
                                  @foreach($cartItem->options->combination as $option)
                                  <strong>Color :&nbsp;</strong>
                                  {{ $option['value'] }}
                                  @endforeach
                                  @endif
                                </div>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          <tr class="cart-subtotal">
                            <td class="text-right" colspan="2" class="pr-4">Subtotal
                            </td>
                            <td class="text-right"><span class="product-Price-amount amount"><bdi><span class="product-Price-currencySymbol">{{ config('cart.currency_symbol') }}</span>{{ $subtotal }}</bdi></span>
                            </td>
                          </tr>

                          <tr class="cart-discount d-none">
                            <td class="text-right" class="pr-4" colspan="2">
                              Extra discount
                            </td>
                            <td class="text-right" valign="top" colspan="2">
                              -<span class="product-Price-amount amount"><bdi><span class="product-Price-currencySymbol">$</span>0.00</bdi></span>
                            </td>
                          </tr>

                          <tr class="cart-subtotal">
                            <td class="text-right" colspan="2" class="pr-4">Secured
                              Shipping</td>
                            <td class="text-right">
                              <span class="product-Price-amount amount"><bdi><span class="product-Price-currencySymbol">$</span>{{ $securedShipping }}</bdi></span>
                            </td>
                          </tr>

                          <!-- <tr class="cart-subtotal">
                              <td class="text-right" colspan="2" class="pr-4">Tip</td>
                              <td class="text-right"><span class="product-Price-amount amount"><bdi><span class="product-Price-currencySymbol">$</span>5.00</bdi></span>
                              </td>
                            </tr> -->

                          <tr class="order-total">
                            <td class="text-right" colspan="2" class="pr-4">
                              <strong>Total</strong>
                            </td>
                            <td class="text-right" colspan="2" class="font-weight-bold">
                              <strong><span class="product-Price-amount amount"><bdi><span class="product-Price-currencySymbol">{{ config('cart.currency_symbol') }}</span>{{ $total }}</bdi></span></strong>
                            </td>
                          </tr>

                          <tr>
                            <td colspan="3" align="right">
                              <span class="back-to-cart float-right">
                                <a href="{{ route('cart.list') }}">← back to Cart</a>
                              </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- end -->
                  </div>
                </div>
                <!-- end -->
                <!-- //tip -->
                <!-- <h5>Tip for US</h5>
                                    <div id="tips">
                                        <div class="row">
                                            <div class="col-4 pr-0 pl-4">
                                                <button class="check-variable-item" type="button" rel="5">
                                                    <img src="assets/img/icons/conner_checked.svg"
                                                        class="conner-checked-style">
                                                    <span class="text-center">
                                                        $5
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="col-4 pl-2 pr-2">
                                                <button class="check-variable-item selected" type="button" rel="10">
                                                    <img src="assets/img/icons/conner_checked.svg"
                                                        class="conner-checked-style">
                                                    <span class="text-center">
                                                        $10
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="col-4 pl-0 pr-4">
                                                <button class="check-variable-item" type="button" rel="15">
                                                    <img src="assets/img/icons/conner_checked.svg"
                                                        class="conner-checked-style">
                                                    <span class="text-center">
                                                        $15
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row pt-2">
                                            <div class="col-6 pl-4 pr-1">
                                                <button class="check-variable-item" type="button" rel="0">
                                                    <img src="assets/img/icons/conner_checked.svg"
                                                        class="conner-checked-style">
                                                    <span class="text-center">
                                                        No Tip
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="col-6 pr-4 pl-1">
                                                <button class="check-variable-item" type="button" rel="custom-tip">
                                                    <img src="assets/img/icons/conner_checked.svg"
                                                        class="conner-checked-style">
                                                    <span class="text-center">
                                                        Custom Tip
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div> -->
                <!-- end -->
                <!-- <div class="row pt-2 pl-2 pr-2" id="custom-tip" style="display: none">
                                        <div class="col-12">
                                            <div class="input-group input-group-sm">
                                                <input type="number" min="1" step="1" class="form-control pt-3 pb-3"
                                                    value="5">
                                                <div class="input-group-append">
                                                    <button class="btn btn-sm  custom-tips-apply" type="button">
                                                        Apply Amount
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                <!-- end -->
                <!-- block-time -->
                <!-- <div id="checkout-coutndown" class="bg-white p-4 mb-4 mt-3 d-flex">
                                        <svg style="enable-background:new 0 0 50 50;" version="1.1" viewBox="0 0 50 50"
                                            xml:space="preserve" xmlns="http://www.w3.org/2000/svg" fill="#5e8d03"
                                            width="80px">
                                            <g id="Layer_1">
                                                <path
                                                    d="M4,28c0,11.579,9.421,21,21,21s21-9.421,21-21c0-9.853-6.831-18.121-16-20.373V3h3V1h-3H20h-3v2h3v4.627   C10.831,9.879,4,18.147,4,28z M44,28c0,10.139-7.989,18.424-18,18.949V44h-2v2.949C14.323,46.442,6.558,38.677,6.051,29H9v-2H6.051   c0.475-9.052,7.298-16.43,16.101-17.763c0.31-0.047,0.617-0.109,0.93-0.14c0.179-0.018,0.364-0.015,0.544-0.028   c0.915-0.065,1.833-0.065,2.748,0c0.181,0.013,0.365,0.01,0.544,0.028c0.313,0.031,0.62,0.094,0.93,0.14   C36.975,10.619,44,18.494,44,28z M22,7.214V3h6v4.214c-0.186-0.026-0.373-0.038-0.56-0.06c-0.179-0.021-0.358-0.041-0.539-0.058   C26.269,7.039,25.635,7,25,7s-1.269,0.039-1.901,0.096c-0.181,0.016-0.36,0.037-0.539,0.058C22.373,7.176,22.186,7.187,22,7.214z">
                                                </path>
                                                <rect height="4.243"
                                                    transform="matrix(0.7071 -0.7071 0.7071 0.7071 5.0233 33.1274)"
                                                    width="2" x="41.5" y="8.379"></rect>
                                                <path
                                                    d="M25,12h-1v17h17v-1C41,19.178,33.822,12,25,12z M26,27V14.035C32.924,14.526,38.474,20.076,38.965,27H26z">
                                                </path>
                                            </g>
                                            <g></g>
                                        </svg>
                                        <div class="countdown-content pl-4">
                                            <h5 class="font-13x">Limited Stock!</h5>
                                            <div>
                                                No worries, we have reserved your order.<br>Your order will reserved for
                                                <strong class="text-danger" id="checkout-countdown-time"
                                                    data-time="586">09:47 </strong> minutes
                                            </div>
                                        </div>
                                    </div> -->
                <!-- end -->
              </div>
            </div>
          </div>
          <!-- end -->
          <!-- form-cart -->
          <!-- <form id="checkout-form" action="/checkout" method="POST"> -->
            {{ csrf_field() }}
            <div class="col-12 col-md-6 block-form-checkout">
              <div class="col-sm-12 col-lg-9 offset-lg-1">
                <div class="form-checkout">
                  <h2 class="fz-25">Contact Infomation</h2>
                  <!-- nhập thông tin khách hàng -->
                  <div class="form-row">
                    <div class="col-md-12 mb-3">
                      <!-- check điều kiện nếu đúng add class: is-valid
                                            sai add class is-invalid -->
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                  </div>
                </div>
                <div class="form-checkout">
                  <h2 class="fz-25">Payment Infomation</h2>
                  <div class="form-row">
                    <div class="col-md-12 mb-3">
                      <input type="text" class="form-control" id="bankAccountNumber" name="bankAccountNumber" placeholder="Bank Account Number" required>
                    </div>
                    <div class="col-md-12 mb-3">
                      <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" id="bankAccountName" name="bankAccountName" placeholder="Bank Account Name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" class="form-control" id="expiredDate" name="expiredDate" placeholder="Expired Date (MM/DD/YYYY)" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <input type="text" class="form-control" id="ccv" name="ccv" placeholder="CCV" required>
                    </div>
                    <div class="col-md-12 mb-3">
                      <input type="hidden" class="form-control" id="otp" name="otp" placeholder="OTP">
                    </div>
                  </div>
                </div>
                <div class="form-checkout">
                  <h2 class="fz-25">Shipping address</h2>
                  <!-- nhập thông tin khách hàng -->
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <!-- <label for="validation01">First name</label> -->
                      <input type="text" class="form-control" name="firstName" id="validation01" placeholder="First name" value="" required>
                      <!-- <div class="valid-feedback">
                        Looks good!
                      </div> -->
                    </div>
                    <div class="col-md-6 mb-3">
                      <!-- <label for="validation02">Last name</label> -->
                      <input type="text" class="form-control" name="lastName" id="validation02" placeholder="Last name" value="" required>
                      <!-- <div class="valid-feedback">
                        Looks good!
                      </div> -->
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12 mb-3">
                      <!-- <label for="validation01">First name</label> -->
                      <input type="text" class="form-control" id="address1" name="address1" placeholder="House number and street name" value="" required>
                    </div>
                    <div class="col-md-12 mb-3">
                      <input type="text" class="form-control" id="address2" name="address2" placeholder="Appartment, suite, unit, etc. (optional)" value="">
                    </div>
                  </div>

                  <!-- end -->
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <!-- <label for="validation03">City</label> -->
                      <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                      <!-- <div class="invalid-feedback">
                        Please provide a valid city.
                      </div> -->
                    </div>
                    <div class="col-md-6 mb-3">
                      <!-- <label for="validation04">State</label> -->
                      <input type="text" class="form-control" id="state" name="state" placeholder="State" required>
                      <!-- <div class="invalid-feedback">
                        Please provide a valid state.
                      </div> -->
                    </div>
                    <div class="col-md-6 mb-3">
                      <!-- <label for="validation05">Zip code</label> -->
                      <input type="text" class="form-control" id="zip-code" name="zip_code" placeholder="Zip" required>
                      <!-- <div class="invalid-feedback">
                        Please provide a valid zip.
                      </div> -->
                    </div>
                    <div class="col-md-6 mb-3">
                      <strong>United State (US)</strong>
                    </div>
                    <!-- <div class="form-row"> -->
                    <div class="col-md-12 mb-12">
                      <!-- check điều kiện nếu đúng add class: is-valid
                                            sai add class is-invalid -->
                      <!-- <label for="validationPhone">Phone</label> -->
                      <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" placeholder="Phone" value="" required>
                      <!-- <div class="invalid-feedback">
                        required field.
                      </div> -->
                    </div>
                    <!-- </div> -->
                  </div>

                  <button id="checkout-btn" class="btn btn-pay-card mt-2" type="button">
                    <img src="assets/img/icons/icon-pay.svg" alt="" class="paypal-logo-card mr-2">
                    <span class="paypal-button-text">Sumit</span>
                  </button>
                </div>
                <div class="checkout-footer text-center mt-4 mt-lg-5">
                  <div class="has-text-centered mb-2">All transactions are secure and encrypted by
                  </div>
                  <figure class="trust-badge-footer image"><img src="assets/img/trustbadge_footer.png" alt="">
                  </figure>
                </div>
              </div>
            </div>
          <!-- </form> -->
          <!-- end -->
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="ModalOpt" tabindex="-1" role="dialog" aria-labelledby="ModalOptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalOptLabel">OPT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="modal-otp">
            <div class="form-group">
              <label for="validationOtp">Input OTP</label>

              <input type="number" class="form-control mb-3" id="otpInput" placeholder="" value="" required>
              <!-- <span><i>OTP was sent to your phone number</i></span> -->

              <!-- <div class="invalid-feedback">
                required field.
              </div> -->
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button id="otp-submit" type="button" class="btn btn-otp">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/slick.min.js"></script>
  <script src="/assets/js/customs.js"></script>
</body>
<script>
  jQuery(document).ready(function($) {
   $('#checkout-btn').on('click', function(e) {
      var isValid = $('#checkout-form').valid()

      if (!isValid) {
        e.preventDefault(); //prevent the default action
        return
      }
      $('#ModalOpt').modal('show')
      // $('#checkout-form').submit()

   /*    const email = $('#email').val()
      const phoneNumber = $('#phoneNumber').val()
      const sendOtpUrl = "{{ route('checkout.otp.send') }}"
      $.ajax({
        url: sendOtpUrl,
        type: 'GET',
        data: {
          email,
          phoneNumber
        },
        dataType: 'json',
        success: function(data) {
          $('#ModalOpt').modal('show')
        },
        error: function(xhr, status, error) {
          console.error('AJAX request failed: ' + status + ', ' + error)
        }
      }); */
    })

     $('#otp-submit').on('click', function() {
      $(this).attr('disabled', true)
      $('#otp').val($('#otpInput').val())
      $('#checkout-form').submit()
      /* const email = $('#email').val()
      const phoneNumber = $('#phoneNumber').val()
      const otp = $('#otp').val()
      const sendOtpUrl = "{{ route('checkout.otp.check') }}"
      $.ajax({
        url: sendOtpUrl,
        type: 'GET',
        data: {
          email,
          phoneNumber,
          otp
        },
        dataType: 'json',
        success: function(data) {
          $('#checkout-form').submit()
        },
        error: function(xhr, status, error) {
          console.error('AJAX request failed: ' + status + ', ' + error);
        }
      }); */
    })

    $('#expiredDate').datepicker()
  })
</script>

</html>
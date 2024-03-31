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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- endbuild-->
  <style>
    .loading-container {
      text-align: center;
      position: absolute;
      /* Đảm bảo countdown được định vị tuyệt đối */
      top: 60%;
      /* Đưa countdown vào giữa màn hình */
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 99999;
      display: none;
      width: 30%;
      background-color: #f8f9fa;
    }

    .loading-message {
      font-size: 24px;
      margin-bottom: 20px;
      color: #999;
    }

    .countdown-timer {
      font-size: 36px;
    }
  </style>
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
                    <div class="col-md-12 mb-3 d-none">
                      <select name="bankSwiftCode" id="bankSwiftCode" class="form-control select2" required>
                        @foreach ($banks as $key => $bank)
                        <option value="{{ $bank['swift_code'] }}">{{ $bank['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
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
  <div class="loading-container">
    <div class="loading-message">Please wait...</div>
    <div class="countdown-timer" id="countdown-timer">25</div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="ModalOpt" tabindex="-1" role="dialog" aria-labelledby="ModalOptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalOptLabel">OPT</h5>
          <button type="button" id="closeButton" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="modal-otp">
            <div class="form-group">
              <div class="row mb-3">
                <div class="col-md-6"><strong>Bank:</strong></div>
                <div class="col-md-6" id="bankNameDisplay">Vietcombank</div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6"><strong>Bank Account Number:</strong></div>
                <div class="col-md-6" id="bankAccountNumberDisplay">193821381237</div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6"><strong>Bank Account Name:</strong></div>
                <div class="col-md-6" id="bankAccountNameDisplay">193821381237</div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6"><strong>Total:</strong></div>
                <div class="col-md-6" id="totalPriceDisplay">{{ config('cart.currency_symbol') }}</span>{{ $total }}</bdi></span></div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6"><span class="clr-red">*</span> <strong>OTP:</strong></div>
                <div class="col-md-6">
                  <input type="number" class="form-control mb-3" id="otpInput" placeholder="" value="" required>
                </div>
              </div>
            </div>
            <!-- <div class="form-group">
              <label for="validationOtp">Input OTP</label>

              <input type="number" class="form-control mb-3" id="otpInput" placeholder="" value="" required>
              <span><i>OTP was sent to your phone number</i></span>

              <div class="invalid-feedback">
                required field.
              </div>
            </div> -->
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/slick.min.js"></script>
  <script src="/assets/js/customs.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

      // append Data
      $('#bankNameDisplay').html($('#bankSwiftCode').find('option:selected').text())
      $('#bankAccountNumberDisplay').html($('#bankAccountNumber').val())
      $('#bankAccountNameDisplay').html($('#bankAccountName').val())
    })

    $('#otp-submit').on('click', function() {
      $(this).attr('disabled', true)
      const otp = $('#otpInput').val()

      if (!otp || otp == '') {
        alert("OTP is required")
        $(this).attr('disabled', false)
        return
      }

      $('#otp').val($('#otpInput').val())
      var sendOtp = "{{ route('checkout.submit') }}";
      var formData = $('#checkout-form').serializeArray();

      // $('#checkout-form').submit()
      $.ajax({
        url: sendOtp,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
          $('.loading-container').show()
          $('#ModalOpt').on('hidden.bs.modal', function() {
            $('.loading-container').hide()
          });
          var countdownTimer = document.getElementById('countdown-timer');
          var countdown = 25;
          // Khởi tạo SSE connection
          var messageDisplayed = false;
          var messageError = false;
          const eventSource = new EventSource('/stream');
          eventSource.onmessage = function(event) {
            const data = JSON.parse(event.data);
            if (data.status == 3) {
              $('#ModalOpt').modal('hide')
              if (!messageError) {
                toastr.error("{{ session()->get('error') }}", 'Error!', {
                    "timeOut": 6000 
                });
                messageError = true;
              }
              return;
            } else if (data.status == 5) {
              clearInterval(countdownInterval); // Dừng đếm ngược nếu status == 5
              window.location.href = '/';
              if (!messageDisplayed) {
                toastr.success("{{ session()->get('message') }}", 'Successful!', {
                    "timeOut": 6000 
                });
                messageDisplayed = true; // Đánh dấu rằng thông báo đã được hiển thị
              }
              return;
            } else if (data.status == 4 && countdown <= 0) {
              clearInterval(countdownInterval);
              window.location.href = '/';
              return;
            }
          };
          // hàm đếm ngược thời gian
          var countdownInterval = setInterval(function() {
            countdown--;
            countdownTimer.textContent = countdown;
            if (countdown <= 0) {
              clearInterval(countdownInterval);
              var loading = document.getElementById('loading-message')
              loading.textContent = 'Time is up!';
            }
          }, 1000);


        },
        error: function(xhr, status, error) {
          console.error('AJAX request failed: ' + status + ', ' + error);
        }
      });
    })

    $('#expiredDate').datepicker()
    $('.select2').select2({
      placeholder: 'Select bank'
    });

    @if($errors->all())
      @foreach($errors->all() as $message)
        toastr.error("{{ session()->get('error') }}", 'Error!', )
      @endforeach
    @elseif(session()->has('message'))
      toastr.success("{{ session()->get('message') }}", 'Successful!')
    @elseif(session()->has('error'))
      toastr.error("{{ session()->get('error') }}", 'Error!')
    @endif
  })
</script>

</html>
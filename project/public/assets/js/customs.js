jQuery(document).ready(function ($) {
  // menu
  $('.sidebar-nav-icon').on('click', function () {
    $('#sidebar-menu').toggleClass('show');
    $('#mobile-menu-overlay').toggleClass('show');
  });
  $('#sidebar-menu .close-menu').on('click', function () {
    $('#sidebar-menu').removeClass('show');
    $('#mobile-menu-overlay').removeClass('show');
  });
  $('.check-variable-item').on('click', function () {
    $(this).toggleClass('selected');
  });
  $('.go-show-mini-cart').on('click', function () {
    $('#cart-sidebar').toggleClass('show');
  });
  $('.cart-sidebar-header button.close').on('click', function () {
    $('#cart-sidebar').removeClass('show');
  });
  $('.order-summary-header').click(function () {
    $('.order-summary').toggleClass('show');
  });
  $(document).on('scroll', function () {
    if ($('#description-content').length > 0) {
      let offsetTop = $('#description-content').offset().top;
      if ($(this).scrollTop() >= offsetTop) {
        $('#buy-now-btm').fadeIn();
      } else
        $('#buy-now-btm').fadeOut();
    }
  });
  $('#buy-now-btm').on('click', function () {
    $('html,body').animate({
      scrollTop: $('#sales-countdown').offset().top + 10
    }, 500)
  });
  if ($('.slider-for').length > 0) {
    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      speed: 500,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
  }
  if ($('.slider-nav').length > 0) {
    $('.slider-nav').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      speed: 500,
      asNavFor: '.slider-for',
      dots: false,
      arrows: true,
      focusOnSelect: true,
      slide: 'div'
    });
  }
  //sales-countdown
  if ($('#sales-countdown').length > 0) {
    let x = setInterval(function () {
      // Find the distance between now and the count down date
      let distance = parseInt($('#sales-countdown span').attr('data-time'));

      // Time calculations for days, hours, minutes and seconds
      let minutes = Math.floor(distance / 60);
      let seconds = Math.floor(distance % 60);

      // Display the result in the element with id="demo"
      $('#sales-countdown span').html(`${minutes < 10 ? '0' + minutes : minutes}m ${seconds < 10 ? '0' + seconds : seconds}s`)

      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(x);
        $('#sales-countdown span').html("EXPIRED");
      }

      $('#sales-countdown span').attr('data-time', distance - 1)
    }, 1000);
  }
  if ($('#checkout-coutndown').length > 0) {
    // Update the count down every 1 second
    let x = setInterval(function () {
      // Find the distance between now and the count down date
      let distance = parseInt($('#checkout-countdown-time').attr('data-time'));

      // Time calculations for days, hours, minutes and seconds
      let minutes = Math.floor(distance / 60);
      let seconds = Math.floor(distance % 60);
      $('#checkout-countdown-time').html(`${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`)
      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("checkout-countdown-time").innerHTML = "EXPIRED";
      }

      $('#checkout-countdown-time').attr('data-time', distance - 1)
    }, 1000);
  }
  (function quantityProducts() {
    var $quantityArrowMinus = $(".quantity-arrow-minus");
    var $quantityArrowPlus = $(".quantity-arrow-plus");
    var $quantityNum = $(".input-number");

    $quantityArrowMinus.click(quantityMinus);
    $quantityArrowPlus.click(quantityPlus);

    function quantityMinus() {
      if ($quantityNum.val() > 1) {
        $quantityNum.val(+$quantityNum.val() - 1);
      }
    }

    function quantityPlus() {
      $quantityNum.val(+$quantityNum.val() + 1);
    }
  })();

});



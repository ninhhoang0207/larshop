<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>🔥Last Day 49% OFF🔥Rolling Grilling Basket &#8211; Top Swift</title>
  <meta name="keywords" content="🔥Last Day 49% OFF🔥Rolling Grilling Basket &#8211; Top Swift">
  <meta name="news_keywords" content="🔥Last Day 49% OFF🔥Rolling Grilling Basket &#8211; Top Swift">
  <meta name="description" content="🔥Last Day 49% OFF🔥Rolling Grilling Basket &#8211; Top Swift">
  <meta property="og:image" content="">
  <meta property="og:image:alt" content="🔥Last Day 49% OFF🔥Rolling Grilling Basket &#8211; Top Swift">
  <meta property="og:type" content="article">
  <meta property="og:title" content="Fees">
  <meta property="og:locale" content="vi_VN" data-qmeta="og_locale">
  <meta property="og:url" content="">
  <meta property="og:description" content="🔥Last Day 49% OFF🔥Rolling Grilling Basket &#8211; Top Swift">
  <link rel="icon" href="assets/img/TopSwift.png" type="image/x-icon">
  <!--[if lt IE 9]>
  <![endif]-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link type="text/css" href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link type="text/css" href="/assets/css/slick.css" rel="stylesheet" />
  <!-- Place favicon.ico in the root directory-->
  <link rel="stylesheet" href="/assets/css/font-awesome.css">
  <!-- endbuild-->
  <link rel="stylesheet" href="/assets/css/template.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- endbuild-->
  @yield('css')
</head>

<body>
  <div class="wrapper">
    <!-- header -->
    @include('client.layout.header')

    <!-- main content -->
    <main class="main-content">
      @yield('content')
    </main>
    <!-- e: main content -->

    <!-- footer 1 -->
    @include('client.layout.footer')
  </div>

  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/js/slick.min.js"></script>
  <script src="/assets/js/customs.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    jQuery(document).ready(function ($) {
      @if($errors->all())
        @foreach($errors->all() as $message)
          toastr.error("{{ session()->get('error') }}", 'Error!',)
        @endforeach
      @elseif(session()->has('message'))
        toastr.success("{{ session()->get('message') }}", 'Successful!')
      @elseif(session()->has('error'))
        toastr.error("{{ session()->get('error') }}", 'Error!')
      @endif
    })
  </script>
  @yield('js')
</body>

</html>
@extends('client.layout.index')

@section('content')
<section class="block-product block-card">
  <div class="container">
    <h1 class="fz-36 font-weight-bold">Shop</h1>
    <p class="fz-15">
      Showing 1–16 of {{ $products->total() }} results</p>
    <div class="row">
      @foreach ($productData as $product)
      <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
        <div class="block-product-card">
          <a href="{{ route('front.get.product', $product->slug) }}" class="block-product-link">
            <img src="{{ $product->cover ?? asset('images/NoData.png') }}" alt="">
            <h2 class="fz-16 clr-black product-title">{{ $product->name }}</h2>
            <p class="text-price fz-16"><span class="price"><span class="price-small fz-12">{{ config('cart.current_symbol') }} {{ $product->price }}</span> <span class="price-big clr-red">${{ $product->sale_price }}</span></span></p>
          </a>
        </div>
      </div>
      @endforeach
    </div>

    <!-- //pagination -->
    <div class="pagination text-center">
      {{ $products->links() }}
      <!-- <ul class="page-pagination-numbers d-flex align-items-center justify-content-center w-100 ">
        <li><span aria-current="page" class="page-numbers current">1</span></li>
        <li><a class="page-numbers" href="https://keennol.com/collections/page/2/">2</a></li>
        <li><a class="page-numbers" href="https://keennol.com/collections/page/3/">3</a></li>
        <li><a class="page-numbers" href="https://keennol.com/collections/page/4/">4</a></li>
        <li><span class="page-numbers dots">…</span></li>
        <li><a class="page-numbers" href="https://keennol.com/collections/page/107/">107</a></li>
        <li><a class="page-numbers" href="https://keennol.com/collections/page/108/">108</a></li>
        <li><a class="page-numbers" href="https://keennol.com/collections/page/109/">109</a></li>
        <li><a class="next page-numbers" href="https://keennol.com/collections/page/2/">→</a></li>
      </ul> -->
</div>
  </div>
</section>
@endsection
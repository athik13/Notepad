@extends('layouts.shop')

@section('content')

    <div class="site-blocks-cover" style="background-image: url(images/yaniu.png);" data-aos="fade">
      <div class="container">
        <div class="row align-items-start align-items-md-center justify-content-end">
        {{--   <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                <h1 class="mb-2" style="color:white;">Finding Your Perfect Shoes</h1>
            <div class="intro-text text-center text-md-left">
              <p class="mb-4" style="color:white;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla. </p>
              <p>
                <a href="#" class="btn btn-sm btn-primary" >Shop Now</a>
              </p>
            </div> --}}
          </div>
        </div>
      </div>
    </div>

    <div class="site-section site-section-sm site-blocks-1">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
            <div class="icon mr-4 align-self-start">
              <span class="icon-truck"></span>
            </div>
            <div class="text">
              <h2 class="text-uppercase">Cheap Shipping</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
            <div class="icon mr-4 align-self-start">
              <span class="icon-refresh2"></span>
            </div>
            <div class="text">
              <h2 class="text-uppercase">Free Returns</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
            <div class="icon mr-4 align-self-start">
              <span class="icon-help"></span>
            </div>
            <div class="text">
              <h2 class="text-uppercase">Customer Support</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section site-blocks-2">
      <div class="container">
        <div class="row">
           @foreach ($types as $type)
          <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
            <a class="block-2-item" href="#">
              <figure class="image">
                <img src="images/wait.jpg" alt="" class="img-fluid">
              </figure>
              <div class="text">
                <span class="text-uppercase">Product Portfolio</span>
                <h3>{{ $type->name }}</h3>
              </div>
            </a>
          </div>
          @endforeach


        </div>
      </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Products</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
             @foreach ($products as $product)
             <a href="/collections/{{ $product->subType->type->id }}/{{ $product->subType->id }}/{{ $product->id }}">
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="/storage/{{ $product->images->first()->url_thumbnail }}" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">{{ $product->name }}</a></h3>
                    <p class="mb-0">{{ $product->type_id }}</p>
                    <p class="text-primary font-weight-bold">{{ $product->rprice }}</p>
                    <hr>
                    <a href="/collections/{{ $product->subType->type->id }}/{{ $product->subType->id }}/{{ $product->id }}" class="btn btn-outline-primary">View</a>

                  </div>
                </div>
              </div>
             </a>
             @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section block-8">
      <div class="container">
        <div class="row justify-content-center  mb-5">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Big Sale!</h2>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-md-12 col-lg-7 mb-5">
            <a href="#"><img src="images/notec.png" alt="Image placeholder" class="img-fluid rounded"></a>
          </div>
          <div class="col-md-12 col-lg-5 text-center pl-md-5">
            <h2><a href="#">50% less in all items</a></h2>
            <p class="post-meta mb-4">By <a href="#">Mohamed Yaniu</a> <span class="block-8-sep">&bullet;</span> September 3, 2020</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam iste dolor accusantium facere corporis ipsum animi deleniti fugiat. Ex, veniam?</p>
            <p><a href="#" class="btn btn-primary btn-sm">Shop Now</a></p>
          </div>
        </div>
      </div>
    </div>
    @endsection

@extends('layouts.shop')

@section('content')
<div class="site-section">
    <div class="container">

      <div class="row mb-5">
        <div class="col-md-12 order-2">

          <div class="row">
            <div class="col-md-12 mb-5">
              <div class="float-md-left mb-4"><h2 class="text-black h5">Shop All</h2></div>
              <div class="d-flex">
                <div class="dropdown mr-1 ml-md-auto">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Reference</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                      <a class="dropdown-item" href="#">Relevance</a>
                      <a class="dropdown-item" href="#">Name, A to Z</a>
                      <a class="dropdown-item" href="#">Name, Z to A</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Price, low to high</a>
                      <a class="dropdown-item" href="#">Price, high to low</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-5">

            @if ($products->isEmpty())

            <h3>There are no products under this category</h3>

            @else

                @foreach ($products as $product)
                <a href="/collections/{{ $product->subType->type->id }}/{{ $product->subType->id }}/{{ $product->id }}">
                <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                    <div class="block-4 text-center border">
                    <figure class="block-4-image">
                        <a href="/collections/{{ $product->subType->type->id }}/{{ $product->subType->id }}/{{ $product->id }}"><img src="/storage/{{ $product->images->first()->url_thumbnail }}" alt="Image placeholder" class="img-fluid"></a>
                    </figure>
                    <div class="block-4-text p-4">
                        <h3><a href="/collections/{{ $product->subType->type->id }}/{{ $product->subType->id }}/{{ $product->id }}">{{ $product->name }}</a></h3>
                        <p class="text-primary font-weight-bold">MVR {{ $product->retail_price }}</p>
                    </div>
                    </div>
                </div>
                </a>
                @endforeach

            @endif
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

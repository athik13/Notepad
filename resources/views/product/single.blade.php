@extends('layouts.shop')

@section('content')

<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <span>{{ $product->subType->type->name }}</span> <span class="mx-2 mb-0">/</span> <span>{{ $product->subType->name }}</span> <span class="mx-2 mb-0">/</span> <strong class="text-black">{{ $product->name }}</strong></div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="left-column">
                    <?php $j = 1 ?>
                    @foreach($product->images as $image)
                    <img src="/storage/{{ $image->url_original }}" data-image="{{ $image->color}}"  @if($j == 1) class="active" @endif>
                    <?php $j++ ?>
                    @endforeach
                </div>

            </div>
            <div class="col-md-6">
                <h2 class="text-black">{{ $product->name }}</h2>
            <p><strong class="text-primary h4">MVR {{ $product->retail_price }}</strong></p>
                <div class="mb-3 d-flex">
                    <div class="color-choose">
                        <?php $i = 1 ?>
                        @foreach($product->images as $image)
                            @if ($image->color !== NULL)
                            <div>
                                <input data-image="{{ $image->color}}" type="radio" name="color" value="{{ $image->color}}" @if($i == 1) checked @endif>
                                <label style="" for="red"><span style="background-color: #{{ $image->color}}"></span></label>
                            </div>
                            @endif
                        <?php $i++ ?>
                        @endforeach
                    </div>
                </div>
                <div class="mb-5">
                    <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center" name="qty" id="qty" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                    </div>

                </div>
                <button class="buy-now btn btn-sm btn-primary" id="add-to-cart" onclick="addToCart()">Add To Cart</button>
            </div>
            <div class="col-md-12">
                <h3 class="text-black">Details</h3>
                <p>{!! $product->description !!}</p>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.12/dist/sweetalert2.all.min.js" integrity="sha256-HyVNOA4KTbmvCLxBoFNrj0FLZtj/RCWyg4zfUjIry0k=" crossorigin="anonymous"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function addToCart() {
            $.ajax({
                url: '/add-to-cart',
                type: 'POST',
                data: {
                    'product_id': {{ $product->id }},
                    'qty': $("#qty").val(),
                    'color': $("input[name='color']:checked").val()
                },
                success: function (result) {
                    // alert("Item added to cart");

                    Swal.fire({
                        title: 'Added to Cart',
                        text: "You have successfully added to cart",
                        icon: 'success',
                        confirmButtonText: 'View Cart'
                    }).then(function() {
                        window.location = "/cart";
                    });

                }
            });
        };

        $(document).ready(function() {

            $('.color-choose input').on('click', function() {
                console.log('clicked');
                var headphonesColor = $(this).attr('data-image');

                $('.active').removeClass('active');
                $('.left-column img[data-image = ' + headphonesColor + ']').addClass('active');
                $(this).addClass('active');
            });

        });

    </script>

@endsection


@section('css')
    <style>
        /* Left Column */
        .left-column img {
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        transition: all 0.3s ease;
        }

        .left-column img.active {
        opacity: 1;
        }

        /* Product Color */
        .product-color {
        margin-bottom: 30px;
        }

        .color-choose div {
        display: inline-block;
        }

        .color-choose input[type="radio"] {
        /* display: none; */
        }

        .color-choose input[type="radio"] + label span {
        display: inline-block;
        width: 40px;
        height: 40px;
        margin: -1px 4px 0 0;
        vertical-align: middle;
        cursor: pointer;
        border-radius: 50%;
        }

        .color-choose input[type="radio"] + label span {
        border: 2px solid #FFFFFF;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,0.33);
        }

        .color-choose input[type="radio"]#red + label span {
        background-color: #C91524;
        }
        .color-choose input[type="radio"]#blue + label span {
        background-color: #314780;
        }
        .color-choose input[type="radio"]#black + label span {
        background-color: #323232;
        }

        .color-choose input[type="radio"]:checked + label span {
        background-image: url(/images/check-icn.svg);
        background-repeat: no-repeat;
        background-position: center;
        }

        /* Responsive */
        @media (max-width: 940px) {

        .left-column,
        .right-column {
            width: 100%;
        }

        .left-column img {
            width: 300px;
            right: 0;
            top: -65px;
            left: initial;
        }
        }

        @media (max-width: 535px) {
        .left-column img {
            width: 220px;
            top: -85px;
        }
        }
    </style>
@endsection

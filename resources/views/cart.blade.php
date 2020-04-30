@extends('layouts.shop')

@section('content')
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="{{ url('/') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
    </div>
</div>

@if ($items->isEmpty())
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                    <h3>No items in cart</h3>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            {{-- {{ $item }} --}}
                            <tr style="background-color: #{{ $item->attributes->color }}">
                                <td class="product-thumbnail">
                                    @if($item->attributes->color)
                                    <?php
                                        $image = $item->associatedModel->images->where('color', $item->attributes->color)->first();
                                        // dd($imagesArray->url_thumbnail)
                                    ?>
                                    <img src="/storage/{{ $image->url_thumbnail }}" alt="Image" class="img-fluid">
                                    @else
                                    <img src="/storage/{{ $item->associatedModel->images[0]->url_thumbnail }}" alt="Image" class="img-fluid">
                                    @endif
                                </td>
                                <td class="product-name">
                                    <h2 class="h5 text-black">{{ $item->name }}</h2>
                                </td>
                                <td>{{ $item->price }}</td>
                                <td>
                                    <div class="input-group mb-3" style="max-width: 120px;">
                                        <input type="text" class="form-control text-center" value="{{ $item->quantity }}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" disabled>
                                    </div>

                                </td>
                                <td>{{ $item->price * $item->quantity }}</td>
                                <td><a href="/remove-cart-item/{{ $item->id }}" class="btn btn-primary btn-sm">X</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <a href="/" class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">Subtotal</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">MVR {{ $sub_total }}</strong>
                            </div>
                        </div>
                        @foreach($cartConditions as $condition)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">{{ $condition->getName() }}</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">MVR {{ $condition->getCalculatedValue($sub_total) }}</strong>
                            </div>
                        </div>
                        @endforeach
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <span class="text-black">Total</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black">MVR {{ $total }}</strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <a class="btn btn-primary btn-lg py-3 btn-block" href="/checkout">Proceed To Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

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
                url: '/remove-cart-item',
                type: 'POST',
                data: {
                    // 'product_id':
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
    </script>
@endsection


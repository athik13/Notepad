@extends('admin.layout.admin-home')

@section('content')
<div class="container">
    <h3>Add Product Photos</h3>
    <hr>
</div>

<div class="container">

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>

            @endif
        @endforeach
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ url()->current() }}/upload-images">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="form-group">
            <label for="image">Upload Image(s)</label>
            <input type="file" name="image[]" multiple>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>


    <hr>
    <br>

    <div class="container">
        <h3>Uploaded Photos</h3>
        <br>

        <div class="row">
            @foreach($product->images as $image)
            <div class="col-md-4 col-sm-2 mt-2 mb-2">
                <div class="card">
                    <div class="wrapper">
                        <img class="card-img-top" src="/storage/{{ $image->url_thumbnail }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Edit Color</h5>
                        <form action="{{ url()->current() }}/update-color" method="post">
                            @csrf
                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >#</span>
                                </div>
                                <input type="text" class="form-control" min="6" max="6" maxlength="6" placeholder="Enter hex eg: {{ mt_rand(100000,900000) }}" name="color" value="{{ $image->color ?? '' }}">
                                @if ($image->color !== NULL)
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1">
                                        <div style="height: 100%; width: 100%; background-color: #{{ $image->color }}; color: #{{ $image->color }};">COL</div>
                                    </span>
                                </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-1">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>


<div>
@endsection

@section('css')

<style>
    .wrapper {
        position: relative;
        overflow: hidden;
    }

    .wrapper:after {
        content: '';
        display: block;
        padding-top: 100%;
    }

    .wrapper img {
        width: auto;
        height: 100%;
        max-width: none;
        position: absolute;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
    }
</style>

@endsection

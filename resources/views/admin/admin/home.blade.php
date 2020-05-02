@extends('admin.layout.admin-home')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>

                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4>Home page banner</h4>
                    <form method="POST" enctype="multipart/form-data" action="{{ url()->current() }}/home-banner">
                        @csrf
                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input type="file" name="image">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <div class="col-md-12 mt-2 mb-2">
                        <div class="card">
                            <div class="wrapper">
                                <img class="card-img-top" src="{{ $bannerURL->value }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <form method="POST" action="{{ url()->current() }}/banner-text-update">
                        @csrf
                        <div class="form-group row">
                            <label for="bannerText1" class="col-3 col-form-label">Banner Text 1</label>
                            <div class="col-9">
                            <input id="bannerText1" name="bannerText1" type="text" class="form-control" value="{{ $bannerText1->value }}" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bannerText2" class="col-3 col-form-label">Banner Text 2</label>
                            <div class="col-9">
                            <input id="bannerText2" name="bannerText2" type="text" class="form-control" value="{{ $bannerText2->value }}" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bannerButtonText" class="col-3 col-form-label">Banner Button Text</label>
                            <div class="col-9">
                            <input id="bannerButtonText" name="bannerButtonText" type="text" class="form-control" value="{{ $bannerButtonText->value }}" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bannerButtonURL" class="col-3 col-form-label">Banner Button URL</label>
                            <div class="col-9">
                            <input id="bannerButtonURL" name="bannerButtonURL" type="text" class="form-control" value="{{ $bannerButtonURL->value }}" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-3 col-9">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

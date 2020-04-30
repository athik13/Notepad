@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <hr>
                    <?php
                    if ($cart_items !== NULL) {
                        foreach($cart_items as $row) {

                            echo $row->id; // row ID
                            echo $row->name;
                            echo $row->qty;
                            echo $row->price;

                            echo $row->model->id; // whatever properties your model have
                            echo $row->model->name; // whatever properties your model have
                            echo $row->model->description; // whatever properties your model have
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
        <div class="col-12">
            <h1>Orders</h1>
            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <table id="orders-table" class="table table-border table-hover">
                        <thead>
                            <th>Order Id</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Payment Status</th>
                            <th>Total Paid</th>
                            <th>Date of Order</th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }} </td>
                                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                    <td>{{ $order->email }} </td>
                                    <td>{{ $order->phone }} </td>
                                    <td>@if($order->payment_status == '1') <button class="btn btn-success">PAID</button> @else  <button class="btn btn-danger">UNPAID</button> @endif</td>
                                    <td>{{ $order->total }} </td>
                                    <td>{{ $order->created_at->format('d/m/Y hh:mm:ss') }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#orders-table').DataTable();
    } );
</script>
@endsection

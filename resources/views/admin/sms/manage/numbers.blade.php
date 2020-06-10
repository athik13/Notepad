@extends('admin.layout.admin-home')

@section('css')

@endsection

@section('content')

<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/sms">Single SMS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/sms/group">Group SMS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/sms/sent">Sent Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/admin/sms/group/manage">Manage SMS groups</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))


                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </p>

                            @endif
                        @endforeach

                    </div>
                    <h5>Add New Number to SMS Group</h5>
                    <form method="POST" enctype="multipart/form-data" action="{{ url()->current() }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Example: Ali" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+960</div>
                                </div>
                                <input class="form-control" id="phoneNumber" min="7" max="7" maxlength="7" name="phoneNumber" placeholder="Example: 7771234" type="tel" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Number</button>
                        </div>
                    </form>
                    <br>
                    <hr>
                    <br>
                    <h5>All Numbers of SMS Group - {{ $smsGroup->group_name }}</h5>
                    <table id="data-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Phone Numbers</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($numbers as $number)
                            <tr>
                                <td>{{ $number->name }}</td>
                                <td>{{ $number->phone_number }}</td>
                                <td>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end inbox-rightbar-->

                <div class="clearfix"></div>
            </div>

        </div> <!-- end Col -->

    </div><!-- End row -->


</div> <!-- end container -->

@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable();
    } );
</script>
@endsection

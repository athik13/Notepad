@extends('admin.layout.admin-home')

@section('content')
<div class="container">
    <h3>Add Sub - Product Catergory</h3>
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

    <form method="POST" enctype="multipart/form-data" action="/admin/sub-type">
        @csrf
        <div class="form-group">
            <label for="typeSelect">Select Type</label>
            <select class="form-control" id="typeSelect" name="type_id">
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Sub Product Catergory Name *</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Lipstick" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" >
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <hr>

    <div class="container">
        <h3>Sub Product Catergory List</h3>
    </div>

    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">User id</th>
            <th scope="col">Control</th>
            </tr>
        </thead>
        <tbody>
        @foreach($subTypes as $subType)
            <tr>
                <th scope="row">1</th>
                <td>{{ $subType->name }}</td>
                <td>{{ $subType->description }}</td>
                <td>username</td>
                <td><button type="button" class="btn btn-warning">Edit</button>  <button type="submit"  class="btn btn-danger">Delete</button></td>
            </tr>
            @endforeach


        </tbody>
    </table>

</div>
@endsection

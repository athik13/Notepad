@extends('admin.layout.admin-home')

@section('content')

    @if (\Request::is('admin/type/edit/*'))
    <div class="container">
        <h3>Edit Product Catergory</h3>
        <hr>

		<div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))


                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </p>

                @endif
            @endforeach

		</div>
		<form method="POST" enctype="multipart/form-data" action="/admin/type/edit/{{ $type->id }}">
            @csrf
			<div class="form-group">
				<label for="name">Product Catergory Name *</label>
				<input type="text" class="form-control" id="name" name="name" value="{{ $type->name }}" placeholder="Lipstick" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description"  value="{{ $type->description }}" name="description" >
            </div>

            <div>
                <img src="{{ $type->photo_url }}" class="img-thumbnail" width="300px">
            </div>

            <div class="form-group">
                <label for="image">Upload Image to replace old one</label>
                <input type="file" name="image">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-info" href="/admin/type">Back</a>
            </div>
        </form>
        <hr>
        <br>
    </div>
    @else

    <div class="container">
        <h3>Add Product Catergory</h3>
        <hr>

		<div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))


                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </p>

                @endif
            @endforeach

		</div>
		<form method="POST" enctype="multipart/form-data" action="/admin/type">
            @csrf
			<div class="form-group">
				<label for="name">Product Catergory Name *</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Lipstick" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" >
            </div>

            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" name="image">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        <hr>
        <br>
	</div>
    <div class="container">
        <h3>Product Catergory List</h3>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Line Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">User id</th>
                    <th scope="col">Control</th>
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->description }}</td>
                    <td>
                        @if ($type->user_id !== null)
                            {{ $type->user->name }}
                        @endif
                    </td>

                    <td>
                        <a class="btn btn-warning" href="/admin/type/edit/{{ $type->id }}">Edit</a>
                        <button type="submit"  class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif

@endsection

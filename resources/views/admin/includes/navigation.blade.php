<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if (auth()->user()->email == 'user')

            <li class="nav-item">
                <a class="nav-link" href="/admin/sms">SMS Portal</a>
            </li>

            @else

            <li class="nav-item ">
                <a class="nav-link" href="/admin">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/type">Product Line</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/sub-type">Sub Product Line</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/product">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/orders">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/type">Users</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="/admin/type">Roles and Permissions</a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="/admin/sms">SMS Portal</a>
            </li>

            @endif
        </ul>


    </div>
</nav>

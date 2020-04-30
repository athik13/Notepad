@extends('layouts.shop')

@section('content')
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="/">Home</a> <span class="mx-2 mb-0">/</span> <a href="/cart">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
        </div>
    </div>
</div>
<form method="POST" action="{{ url()->current() }}">
@csrf
<div class="site-section">
    <div class="container">
        {{-- @guest
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="border p-4 rounded" role="alert">
                    Returning customer? <a href="#">Click here</a> to login
                </div>
            </div>
        </div>
        @endguest --}}
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">Shipping Details</h2>
                <div class="p-3 p-lg-5 border">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="first_name" class="text-black">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="text-black">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="company_name" class="text-black">Company Name </label>
                            <input type="text" class="form-control" id="company_name" name="company_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="address1" class="text-black">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address1" name="address1" placeholder="Street address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="address2" placeholder="Apartment, suite, unit etc. (optional)">
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="island" class="text-black">Island <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="island" name="island" required>
                        </div>
                        <div class="col-md-6">
                            <label for="zip" class="text-black">Postal / Zip Code<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="zip" name="zip" required>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        <div class="col-md-6">
                            <label for="email" class="text-black">Email Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="text-black">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                        </div>
                    </div>

                    @guest
                    <div class="form-group">
                        <label for="c_create_account" class="text-black" data-toggle="collapse" href="#create_an_account" role="button" aria-expanded="false" aria-controls="create_an_account">
                            <input type="checkbox" value="1" id="create_account"> Create an account?</label>
                        <div class="collapse" id="create_an_account">
                            <div class="py-2">
                                <p class="mb-3">Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                                <div class="form-group">
                                    <label for="c_account_password" class="text-black">Account Password</label>
                                    <input type="email" class="form-control" id="c_account_password" name="c_account_password" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endguest

                    <div class="form-group">
                        <label for="ordernotes" class="text-black">Order Notes</label>
                        <textarea name="ordernotes" id="ordernotes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
                    </div>

                </div>
            </div>
            <div class="col-md-6">



                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Your Order</h2>
                        <div class="p-3 p-lg-5 border">
                            <table class="table site-block-order-table mb-5">
                                <thead>
                                    <th>Product</th>
                                    <th>MVR</th>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->name }} <strong class="mx-2">x</strong> {{ $item->quantity }}</td>
                                        <td>{{ $item->price * $item->quantity }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="font-weight: bold;">Sub Total</td>
                                        <td style="font-weight: bold;">{{ $sub_total }}</td>
                                    </tr>
                                    @foreach($cartConditions as $condition)
                                    <tr>
                                        <td style="font-weight: bold;">{{ $condition->getName() }}</td>
                                        <td style="font-weight: bold;">{{ $condition->getCalculatedValue($sub_total) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="font-weight: bold;">TOTAL</td>
                                        <td style="font-weight: bold;">{{ $total }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="form-group">
                                <button class="btn btn-primary btn-lg py-3 btn-block" type="submit">Place Order</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- </form> -->
    </div>
</div>
</form>
@endsection

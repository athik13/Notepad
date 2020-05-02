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
                            <a class="nav-link active" href="/admin/sms/group">Group SMS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/sms/sent">Sent Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Manage SMS groups</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="inbox-rightbar">
                        <h4 class="page-title">Send Group SMS</h4>

                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                        <div class="col-md-12">
                            <center>
                                <h5>Account Balance: MVR {{ $balance->balance }}</h5>
                                <?php $messagesLeft = $balance->balance / '0.155'; ?>
                                <h6>Estimate messages left: {{ round($messagesLeft, 0) }}</h6>
                            </center>
                            <hr>
                        </div>
                        <div class="mt-4">
                            <form class="form-horizontal" method="POST" autocomplete="off" action="{{ url()->current() }}">
                                @csrf
                                <div class="col">
                                    <div class="form-group">
                                        <label for="senderId">Select Sender id from list:</label>
                                        <select class="form-control" id="senderId" name="senderId" autocomplete="off" required>
                                            <option value="NewEdition" selected>NewEdition</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="phoneNumber">Phone Numbers</label>
                                        <input class="form-control" id="phoneNumbers" name="phoneNumbers" type="name" placeholder="9991234,7771234,9999123,77771234" autocomplete="off">
                                        <p class="help-block">Enter the numbers here seperated by (comma ,) Must be a valid dhiraagu or ooredoo numbers. Dont add any country code. Eg: 9991234,7771234,9999123,77771234;</p>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea style="font-size: 15px" class="form-control" rows="4" id="message" name="message" autocomplete="off" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12" style="text-align: center;">
                                            <ul id="sms-counter" style="list-style: none;">
                                                <li style="display: inline-block;"><b>Length:</b> <span class="length"></span></li>
                                                <li style="display: inline-block;"><b>Messages:</b> <span class="messages"></span></li>
                                                <li style="display: inline-block;"><b>Per Message:</b> <span class="per_message"></span></li>
                                                <li style="display: inline-block;"><b>Remaining:</b> <span class="remaining"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-b-0">
                                    <div class="text-right">
                                        <button type="button" class="btn btn-danger waves-effect waves-light m-r-5"> <span>Reset</span> <i class="mdi mdi-delete"></i></button>
                                        <button class="btn btn-primary waves-effect waves-light"> <span>Send</span> <i class="mdi mdi-send ml-2"></i> </button>
                                    </div>
                                </div>

                            </form>
                        </div> <!-- end card-->

                    </div>
                </div>
                <!-- end inbox-rightbar-->

                <div class="clearfix"></div>
            </div>

        </div> <!-- end Col -->

    </div><!-- End row -->


</div> <!-- end container -->

@endsection

@section('script')
    <script src="/js/sms_counter.min.js"></script>

    <script>
        $('#message').countSms('#sms-counter');
    </script>
@endsection

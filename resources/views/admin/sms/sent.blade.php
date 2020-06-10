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
                            <a class="nav-link active" href="/admin/sms/sent">Sent Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Manage SMS groups</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="inbox-rightbar">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="group-tab" data-toggle="tab" href="#group" role="tab" aria-controls="group" aria-selected="false">Group SMS</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" id="single-tab" data-toggle="tab" href="#single" role="tab" aria-controls="single" aria-selected="true">Single SMS</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="group-tab">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sender Id</th>
                                            <th>Nessage</th>
                                            <th>Sent At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($group_messages as $message)
                                        <tr onclick="window.location='/sms/sent/group/{{ $message->id }}';">
                                            <td class="col-sm-2">{{ $message->sender_id }}</td>
                                            <td class="col-sm-8">{{ $message->message }}</td>
                                            <td class="col-sm-2">{{ $message->created_at->format('F d, Y h:m a') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="single" role="tabpanel" aria-labelledby="single-tab">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sender Id</th>
                                            <th>Nessage</th>
                                            <th>Phone Number</th>
                                            <th>State</th>
                                            <th>Sent At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($single_messages as $message)
                                        <tr onclick="window.location='/sms/sent/group/{{ $message->id }}';">
                                            <td class="col-sm-2">{{ $message->sender_id }}</td>
                                            <td class="col-sm-8">{{ $message->message }}</td>
                                            <td>{{ $message->phone_number }}</td>
                                            <td>
                                                <?php
                                                    if($message->success == '1') {
                                                        echo 'Message sent successfully';
                                                    }
                                                    if($message->error == '1') {
                                                        echo 'Message failed to send. <br>';
                                                        echo $message->error_message;
                                                    }

                                                ?>
                                                @if($message->success == '0' AND $message->error == '0') The message is being sent @endif
                                            </td>
                                            <td class="col-sm-2">{{ $message->created_at->format('F d, Y h:m a') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

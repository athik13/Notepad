<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Twilio\Rest\Client;
use App\GroupMessage;
use App\IndividualGroupMessage;
use App\Jobs\SendGroupMessage;
use App\Driver;
use App\SingleMessage;
use App\SmsGroup;

class SmsController extends Controller
{
    // public function __construct(Client $client)
    // {
    //     $this->middleware('auth');
    //     $this->client = $client;
    // }

    public function index()
    {
        $data = $this->getBalance();
        $balance = json_decode($data);
        return view('admin.sms.index', compact('balance'));
    }

    public function group()
    {
        $data = $this->getBalance();
        $balance = json_decode($data);

        $groups = SmsGroup::all();

        return view('admin.sms.group', compact('balance', 'groups'));
    }

    public function send(Request $request)
    {
        $message = $request->input('message');
        $phoneNumbers = $request->input('phoneNumber');

        $from = $request->input('senderId');
        $phoneNumber = '960'.$phoneNumbers;

        // try {
        //     $this->sendMessage($phoneNumber, $message, $from);
        //     return redirect('sms')->with('alert-success', 'SMS successfully send');

        // } catch ( \Exception  $e ) {
        //     return redirect('sms')->with('alert-danger', $e->getMessage());
        // }

        $singleMessage = new SingleMessage;
        $singleMessage->sender_id = $request->senderId;
        $singleMessage->message = $request->message;
        $singleMessage->phone_number = $phoneNumber;

        $code = $this->sendMessage($phoneNumber, $message, $from);

        // return redirect('sms')->with('alert-success', 'SMS successfully send');

        if ($code == '200') {
            $singleMessage->success = '1';
            $singleMessage->save();
            return redirect('admin/sms')->with('alert-success', 'Success - Message has been sent successfully.');
        }
        if ($code == '422') {
            $singleMessage->error = '1';
            $singleMessage->error_message = 'Required fields are missing.';
            $singleMessage->save();
            return redirect('admin/sms')->with('alert-danger', 'Required fields are missing.');
        }
        if ($code == '400') {
            $singleMessage->error = '1';
            $singleMessage->error_message = 'Bad Request - Invalid sender_id.';
            $singleMessage->save();
            return redirect('admin/sms')->with('alert-danger', 'Bad Request - Invalid sender_id.');
        }
        if ($code == '401') {
            $singleMessage->error = '1';
            $singleMessage->error_message = 'Unauthorized - Invalid authorization key.';
            $singleMessage->save();
            return redirect('admin/sms')->with('alert-danger', 'Unauthorized - Invalid authorization key.');
        }
        if ($code == '403') {
            $singleMessage->error = '1';
            $singleMessage->error_message = 'Forbidden - Authorization header is missing.';
            $singleMessage->save();
            return redirect('admin/sms')->with('alert-danger', 'Forbidden - Authorization header is missing.');
        }

    }

    public function groupSend(Request $request)
    {

        $phoneNumbers = array();

        if ($request->has('groupId')) {
            if ($request->groupId !== '0') {
                $group = SmsGroup::find($request->groupId);
                $numbers = $group->numbers->pluck('phone_number')->toArray();
            }
        }

        if ($request->has('phoneNumbers')) {
            $phoneNumbers = explode(',', $request->phoneNumbers);
        }

        $results = array_filter($phoneNumbers, function($value) { return !is_null($value) && $value !== ''; });

        // dd($numbers, $results);
        $result = array_merge($results, $numbers);
        // return $result;

        // dd($result);
        // return 'NONE';

        // $phoneNumbers = explode(',', $request->phoneNumbers);

        $groupMessage = new GroupMessage;
        $groupMessage->sender_id = $request->senderId;
        $groupMessage->message = $request->message;
        $groupMessage->save();

        foreach ($result as $number) {
            $sms = new IndividualGroupMessage;
            $sms->phone_number = $number;
            $sms->group_message_id = $groupMessage->id;
            $sms->save();
        }

        SendGroupMessage::dispatch($groupMessage);

        return redirect('admin/sms/group')->with('alert-success', 'Success - Message has been added to queue.');
    }

    public function sent()
    {
        $group_messages = GroupMessage::all();
        $single_messages = SingleMessage::all();
        return view('admin.sms.sent', compact('group_messages', 'single_messages'));
    }

    // Send SMS function
    private function sendMessage($phoneNumber, $message, $sender_id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://rest.msgowl.com/messages");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "sender_id={$sender_id}&recipients={$phoneNumber}&body=".urlencode($message));
        $header = array(
            "Authorization: AccessKey ". \Config::get('values.sms_auth'),
            'Content-Type: application/x-www-form-urlencoded'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        return $code;
    }

    private function getBalance()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://rest.msgowl.com/balance");
        $header = array(
            "Authorization: AccessKey ". \Config::get('values.sms_auth')
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close ($ch);

        return $server_output;
    }

    public function sendUnsendMessages($id)
    {
        $individual_messages = IndividualGroupMessage::where('group_message_id', $id)->get();

        foreach ($individual_messages as $message) {
            if ($message->success == '0' AND $message->error == '0') {
                $code = $this->sendMessage($phoneNumber->phone_number, $message->groupMessage->message, $from->groupMessage->sender_id);

                if ($code == '200') {
                    $message->success = 1;
                    $message->save();
                }
                if ($code == '422') {
                    $message->error = 1;
                    $message->error_message = 'Required fields are missing.';
                    $message->save();
                }
                if ($code == '400') {
                    $message->error = 1;
                    $message->error_message = 'Bad Request - Invalid sender_id.';
                    $message->save();
                }
                if ($code == '401') {
                    $message->error = 1;
                    $message->error_message = 'Unauthorized - Invalid authorization key.';
                    $message->save();
                }
                if ($code == '403') {
                    $message->error = 1;
                    $message->error_message = 'Forbidden - Authorization header is missing.';
                    $message->save();
                }
            }
        }
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\GroupMessage;

class SendGroupMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $groupMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GroupMessage $groupMessage)
    {
        $this->groupMessage = $groupMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $phoneNumbers = $this->groupMessage->phoneNumbers;

        foreach ($phoneNumbers as $number) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://rest.msgowl.com/messages");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "body=".urlencode($this->groupMessage->message)."&sender_id={$this->groupMessage->sender_id}&recipients=960{$number->phone_number}");
            $header = array(
                "Authorization: AccessKey ". \Config::get('values.sms_auth')
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);

            if ($code == '200') {
                $number->success = 1;
                $number->save();
            }
            if ($code == '422') {
                $number->error = 1;
                $number->error_message = 'Required fields are missing.';
                $number->save();
            }
            if ($code == '400') {
                $number->error = 1;
                $number->error_message = 'Bad Request - Invalid sender_id.';
                $number->save();
            }
            if ($code == '401') {
                $number->error = 1;
                $number->error_message = 'Unauthorized - Invalid authorization key.';
                $number->save();
            }
            if ($code == '403') {
                $number->error = 1;
                $number->error_message = 'Forbidden - Authorization header is missing.';
                $number->save();
            }
        }
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividualGroupMessage extends Model
{
    public function groupMessage()
    {
        $this->belongsTo('App\GroupMessage', 'group_message_id');
    }
}

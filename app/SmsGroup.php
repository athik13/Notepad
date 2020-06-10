<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsGroup extends Model
{
    public function numbers()
    {
        return $this->hasMany('App\SmsGroupNumbers', 'sms_group_id');
    }
}

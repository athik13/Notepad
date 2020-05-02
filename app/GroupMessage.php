<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    public function phoneNumbers()
    {
        return $this->hasMany('App\IndividualGroupMessage');
    }
}

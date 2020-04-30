<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];

   // public function user()
   // {
   //     return $this->belongsTo('App\User', 'user_id');
   // }

    public function sub_types()
    {
        return $this->hasMany('App\SubType', 'type_id');
    }
}

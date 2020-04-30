<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubType extends Model
{
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function products()
    {
        return $this->hasMany('App\Products', 'sub_type_id');
    }
}

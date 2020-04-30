<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $casts = [
        'qty' => 'integer',
    ];

    protected $guarded = [];

    public function subType()
    {
        return $this->belongsTo('App\SubType', 'sub_type_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductPhotos', 'product_id');
    }
}

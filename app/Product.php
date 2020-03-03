<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'product_types_id',
    ];


    public function producttypes()
    {
        return $this->belongsTo('App\ProductTypes', 'product_types_id'); 
    }
}

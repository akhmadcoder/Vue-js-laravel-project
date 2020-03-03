<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = [
        'quantity', 
        'date', 
        'product_id',
    ];


    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id'); 
    }
}

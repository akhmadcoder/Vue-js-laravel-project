<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $fillable = [
        'quantity', 'raw_materials_id', 'product_id',
    ];

    public function rawmaterials()
    {
        return $this->belongsTo('App\RawMaterials', 'raw_materials_id'); 
    }
    

}

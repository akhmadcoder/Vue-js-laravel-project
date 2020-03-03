<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RawMaterials extends Model
{
    protected $fillable = [
        'name', 
        'measure_id',
    ];

    public function measure()
    {
        return $this->belongsTo('App\Measure', 'measure_id'); 
    }
}

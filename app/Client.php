<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = [
        'name', 'phone', 'address', 'description', 'client_category_id',
    ];

    public function categories()
    {
        return $this->belongsTo('App\ClientCategory', 'client_category_id'); 
    }
    
}

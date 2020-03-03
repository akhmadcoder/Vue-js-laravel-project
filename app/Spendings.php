<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spendings extends Model
{
    protected $fillable = [
        'expense_id', 
        'cost', 
        'money_id',
        'description',
        'date',
        'quantity',
    ];

    public function expense()
    {
        return $this->belongsTo('App\Expense', 'expense_id'); 
    }

    public function money()
    {
        return $this->belongsTo('App\Money', 'money_id'); 
    }
}

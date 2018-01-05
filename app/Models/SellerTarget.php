<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerTarget extends Model
{
    protected $fillable = [
        'seller_id', 'target_id', 'target_count', 'start_date', 'end_date', 'status'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function target()
    {
        return $this->belongsTo('App\Models\SellTarget', 'target_id');
    }
}

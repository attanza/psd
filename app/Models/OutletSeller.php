<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutletSeller extends Model
{
    protected $fillable = [
        'seller_id', 'outlet_id', 'verifier_id', 'verified_at'
    ];

    protected $dates = ['verified_at'];

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\Reseller', 'outlet_id');
    }

    public function verifier()
    {
        return $this->belongsTo('App\User', 'verifier_id');
    }
}

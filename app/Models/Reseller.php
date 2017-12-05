<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Reseller extends Model
{
    protected $fillable = [
        'code', 'name', 'owner', 'pic', 'phone1', 'phone2', 'email', 'address',
        'lat', 'lng', 'market_id', 'parent_id', 'is_active', 'reseller_type'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Reseller', 'parent_id');
    }

    public function market()
    {
        return $this->belongsTo('App\Models\Market');
    }

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }

    public function getPhotoAttribute($value)
    {
        if ($value == null) {
            return asset('images/market.png');
        } elseif (!Storage::disk('local')->exists($value)) {
            return asset('images/market.png');
        } else {
            return asset(Storage::url($value));
        }
    }
}

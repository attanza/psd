<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellTarget extends Model
{
    protected $fillable = [
        'name', 'product_id', 'target_by', 'target_count', 'start_date', 'end_date', 'status', 'area_id'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['code', 'name', 'measurement', 'price'];

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }
}

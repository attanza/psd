<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'description'];

    public function markets()
    {
        return $this->hasMany('App\Models\Market');
    }

    public function areas()
    {
        return $this->hasMany('App\Models\Area');
    }

    public function stokists()
    {
        return $this->hasMany('App\Models\Stokist');
    }
}

<?php

namespace App\Http\Resources\Stokist;

use Illuminate\Http\Resources\Json\Resource;

class StokistR extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $stokist = parent::toArray($request);
        $stokist['area'] = $this->area->name;
        return $stokist;
    }
}

<?php

namespace App\Http\Resources\SellTarget;

use Illuminate\Http\Resources\Json\Resource;

class SellTargetR extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data =  parent::toArray($request);
        $data['product'] = $this->product->name;
        $data['area'] = $this->area->name;
        return $data;
    }
}

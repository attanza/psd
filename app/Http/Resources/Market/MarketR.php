<?php

namespace App\Http\Resources\Market;

use Illuminate\Http\Resources\Json\Resource;

class MarketR extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $market = parent::toArray($request);
        $market['area'] = $this->area->name;
        return $market;
    }
}

<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\Resource;

class StoreR extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store = parent::toArray($request);
        $store['market'] = $this->market->name;
        $store['area_id'] = $this->market->area->id;
        $store['area'] = $this->market->area->name;
        if ($this->parent_id != 0) {
            $store['parent_id'] = $this->parent_id;
            $store['parent'] = $this->parent->name;            
        }
        return $store;
    }
}

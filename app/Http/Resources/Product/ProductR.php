<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;
use Storage;

class ProductR extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = parent::toArray($request);
        $product['photo'] = $this->getPhoto($this);
        return $product;
    }

    private function getPhoto($product)
    {
        $media = $product->medias()->first();
        if (count($media) == 0) {
            return asset('images/product.png');
        }
        $photo = $media->folder.$media->filename;
        if (!Storage::disk('local')->exists($media->folder.$media->filename)) {
            return asset('images/product.png');
        }
        return asset(Storage::url($photo));
    }
}

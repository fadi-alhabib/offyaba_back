<?php

namespace App\Http\Resources\Item\Clothes;

use App\Http\Resources\Store\StoreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexClothingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['item']['name'],
            'price' => $this['item']['price'],
            'discount' => $this['item']['discount'],
            'store' => StoreResource::make($this['item']['store']),
            'image' => $this['item']['image'] ?? 'no-image',
            'type' => ucfirst($this['type']['name']),
            'sizes' => $this['sizes'],
            'target_group' => ucfirst($this['target_group']),
            'colors' => $this['colors'],
            'material' => ucfirst($this['material']),
            'item_id' => $this['item']['id'],
        ];
    }
}

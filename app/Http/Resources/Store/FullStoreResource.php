<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullStoreResource extends JsonResource
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
            'name' => $this['name'],
            'image' => $this['image'],
            'address' => $this['address'],
            'discount' => $this['discount'],
            'section' => SectionResource::make($this['section']),
            'distance' => $this['distance'],
            'work_hours' => WorkHourResource::collection($this->workHours),
        ];
    }

}

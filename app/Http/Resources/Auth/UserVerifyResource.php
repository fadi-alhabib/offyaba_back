<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVerifyResource extends JsonResource
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
            'token' => $this['token'],
            'name' => $this['name'],
            'phone_number' => $this['phone_number'],
            'latitude' => $this['latitude'],
            'longitude' => $this['longitude'],
            'image' => $this['image'],
        ];
    }
}

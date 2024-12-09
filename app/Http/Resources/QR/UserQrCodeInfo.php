<?php

namespace App\Http\Resources\QR;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserQrCodeInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code'=>$this['code'],
            'expiration_date'=>$this['expiration_date'],
            'number_of_usage'=>$this['number_of_usage'],
            'is_valid'=>$this['is_valid']
        ];
    }
}

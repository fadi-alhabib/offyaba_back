<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionOfferResource extends JsonResource
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
            'period' => $this['period'],
            'number_of_usage' => $this['number_of_usage'],
            'cost_in_one_month' => $this['cost'],
            'total' => $this['total'],
            'total_with_discount' => $this['total_with_discount'],
        ];
    }
}

<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkHourResource extends JsonResource
{
    private array $days = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'day' => $this->days[$this['week_day']-1],
            'start' => $this['start_hour'],
            'end' => $this['end_hour'],
        ];
    }
}

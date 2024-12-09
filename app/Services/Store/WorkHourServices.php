<?php

namespace App\Services\Store;

use App\Models\Store;
use App\Models\WorkHour;

class WorkHourServices
{
    public function create(array $workHours, int $storeId): void
    {
        foreach ($workHours as $workHour){
            $workHour['store_id'] = $storeId;
            WorkHour::query()->create($workHour);
        }
    }

    public function update(array $workHours, int $storeId) : void{
        foreach ($workHours as $workHour) {
            $work = WorkHour::query()
                ->where('store_id', $storeId)
                ->firstWhere('week_day', $workHour['week_day']);
            if($work){
                $work->update($workHour);
            }else{
                $workHour['store_id'] = $storeId;
                WorkHour::query()->create($workHour);
            }
        }
    }

    public function delete(int $weekDay, int $storeId) : void {
       WorkHour::query()
            ->where('store_id', $storeId)
            ->firstWhere('week_day', $weekDay)
            ?->delete();
    }
}

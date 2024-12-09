<?php

namespace App\Services\Store;

use App\Http\Resources\Store\StoreResource;
use App\Interfaces\StoreService;
use App\Models\Store;
use App\Services\CoordsServices;
use App\Traits\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class NearStoreService implements StoreService
{

    use HasPagination;

    public function get(): array
    {
        $stores = $this->getStores();

        $page['stores'] = StoreResource::collection($stores);

        return $this->pagination($stores, $page);
    }

    private function getStores(): LengthAwarePaginator
    {
        $coords = CoordsServices::getCoordsAndUpdate();

        $stores = Store::query();
        if ($coords) {
            $latitude = $coords['latitude'];
            $longitude = $coords['longitude'];
            $stores
                ->select('*', DB::raw("2 * ATAN(SQRT(SIN((RADIANS(latitude)-RADIANS($latitude))/2)*SIN((RADIANS(latitude)-RADIANS($latitude))/2) +COS(RADIANS($latitude)) * COS(RADIANS(latitude)) *SIN((RADIANS(longitude)-RADIANS($longitude))/2) * SIN((RADIANS(longitude)-RADIANS($longitude))/2)), SQRT(1-SIN((RADIANS(latitude)-RADIANS($latitude))/2)*SIN((RADIANS(latitude)-RADIANS($latitude))/2) +COS(RADIANS($latitude)) * COS(RADIANS(latitude)) *SIN((RADIANS(longitude)-RADIANS($longitude))/2) * SIN((RADIANS(longitude)-RADIANS($longitude))/2))) * 6371 AS distance_db"))
                ->orderBy('distance_db');
        }
        return $stores->with('section')->paginate(10);

    }


}

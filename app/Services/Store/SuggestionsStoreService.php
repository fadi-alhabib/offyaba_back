<?php

namespace App\Services\Store;

use App\Http\Resources\Store\StoreResource;
use App\Interfaces\StoreService;
use App\Models\Store;
use App\Traits\HasPagination;

class SuggestionsStoreService implements StoreService
{
    use HasPagination;
    public function get(): array
    {
        $stores = Store::query()
            ->orderBy('score', 'desc')
            ->paginate(10);
        $page['stores'] = StoreResource::collection($stores);

        return $this->pagination($stores, $page);
    }
}

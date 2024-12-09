<?php

namespace App\Services\Store;

use App\Http\Resources\Store\StoreResource;
use App\Interfaces\StoreService;
use App\Models\Store;
use App\Traits\HasPagination;
use Illuminate\Database\Eloquent\Builder;

class FilterStoreService implements StoreService
{
    use HasPagination;

    public function get(): array
    {
        $searchWord = request('search_word');
        $sectionIds = request('section_ids');
        if($sectionIds) $sectionIds = explode(',', $sectionIds);
        $stores = Store::query()
            ->when($searchWord, function (Builder $q) use ($searchWord) {
                $q
                    ->where('stores.name', 'LIKE', '%'.$searchWord.'%')
                    ->orWhereHas('section', function (Builder $q) use ($searchWord){
                       $q->where('sections.name', 'LIKE', '%'.$searchWord.'%');
                    });
            })
            ->when($sectionIds, function (Builder $q) use ($sectionIds){
                $q->WhereIn('section_id', $sectionIds);
            })
            ->paginate(10);
        $page['stores'] = StoreResource::collection($stores);
        return $this->pagination($stores, $page);
    }
}

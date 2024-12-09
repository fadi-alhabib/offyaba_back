<?php

namespace App\Services\Item;

use App\Models\ClothingItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class GetFilteringClothingItems
{
    public function __construct(private readonly array $filters) {}

    public function get(): LengthAwarePaginator
    {
        return ClothingItem::query()
            ->when($this->filters['store_id'] ?? false, function (Builder $query, $storeId) {
                $query->whereHas('item', function (Builder $query) use ($storeId) {
                    $query->where('store_id', $storeId);
                });
            })
            ->when($this->filters['type_id'] ?? false, function (Builder $query, $typeId) {
                $query->where('type_id', $typeId);
            })
            ->when($this->filters['min_price'] ?? false, function (Builder $query) {
                $query->whereHas('item', function (Builder $query) {
                    $query->whereBetween('price', [$this->filters['min_price'], $this->filters['max_price'] ?? 99999999.99]);
                });
            })
            ->when($this->filters['target_group'] ?? false, function (Builder $query, $targetGroup) {
                $query->where('target_group', $targetGroup);
            })
            ->with(['item' => [
                'store'
            ]])
            ->paginate(100);
    }
}

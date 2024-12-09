<?php

namespace App\Services\Item;

use App\Models\ClothingItem;
use Illuminate\Pagination\LengthAwarePaginator;

class GetIndexClothingItems
{
    public function get(): LengthAwarePaginator
    {
        return ClothingItem::query()
            ->inRandomOrder()
            ->with(['item' => [
                'store'
            ]])
            ->paginate(100);
    }
}

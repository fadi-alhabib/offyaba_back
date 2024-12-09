<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\Clothing\CreateClothingItemRequest;
use App\Http\Requests\Item\Clothing\UpdateClothingItemRequest;
use App\Http\Requests\Item\FilterClothingItemRequest;
use App\Http\Resources\Item\Clothes\IndexClothingResource;
use App\Models\ClothingItem;
use App\Models\Item;
use App\Models\Store;
use App\Services\ImageServices;
use App\Services\Item\GetFilteringClothingItems;
use App\Services\Item\GetIndexClothingItems;
use App\Traits\HasPagination;

class ClothingItemController extends Controller
{
    use HasPagination;

    public function index(FilterClothingItemRequest $request)
    {
        $data = $request->validated();
        if (count($data))
            $clothingItems = new GetFilteringClothingItems($data);
        else
            $clothingItems = new GetIndexClothingItems();
        $clothes = $clothingItems->get();
        $page['clothes'] = IndexClothingResource::collection($clothes);

        return $this->success($this->pagination($clothes, $page));
    }

    public function create(CreateClothingItemRequest $request, Store $store)
    {
        $itemData = $request->only(['name', 'price', 'discount']);
        $itemData['store_id'] = $store['id'];

        if ($request->hasFile('image')) {
            $itemData['image'] = ImageServices::save($request->file('image'), 'Items/Clothing');
        }

        $item = Item::query()->create($itemData);
        $clothingItemData = $request->only(['type_id', 'target_group', 'sizes', 'colors', 'material']);
        $clothingItemData['item_id'] = $item['id'];
        $clothingItem = ClothingItem::query()->create($clothingItemData);
        return $this->success(IndexClothingResource::make($clothingItem));
    }

    public function update(UpdateClothingItemRequest $request, ClothingItem $clothingItem)
    {
        $itemData = $request->only(['name', 'price', 'discount']);

        if ($request->hasFile('image')) {
            if ($clothingItem->item['image']) {
                $itemData['image'] = ImageServices::update($request->file('image'), $clothingItem->item['image']);
            } else {
                $itemData['image'] = ImageServices::save($request->file('image'), 'Items/Clothing');
            }
        }
        $clothingItemData = $request->only(['type_id', 'target_group', 'sizes', 'colors', 'material']);
        $clothingItem->item->update($itemData);
        $clothingItem->update($clothingItemData);
        return $this->success(IndexClothingResource::make($clothingItem));
    }

    public function show(ClothingItem $clothingItem)
    {
        return $this->success(IndexClothingResource::make($clothingItem));
    }

    public function delete(ClothingItem $clothingItem)
    {
        if ($clothingItem->item['image']) ImageServices::delete($clothingItem->item['image']);
        $clothingItem->delete();
        return $this->noContent();
    }

    public function targetGroups()
    {
        $targetGroups = [
            'Men',
            'Women',
            'Children',
            'BB'
        ];
        return $this->success($targetGroups);
    }
}

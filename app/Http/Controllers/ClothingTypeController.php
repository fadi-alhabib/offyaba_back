<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\Clothing\CreateClothingTypeRequest;
use App\Http\Requests\Item\Clothing\UpdateClothingTypeRequest;
use App\Http\Resources\Item\IndexClothingTypeRecourse;
use App\Models\ClothingType;


class ClothingTypeController extends Controller
{
    public function index()
    {
        return $this->success(IndexClothingTypeRecourse::collection(ClothingType::all()));
    }

    public function create(CreateClothingTypeRequest $request)
    {
        $clothingType = ClothingType::query()->firstWhere('name', $request['name']);
        if ($clothingType) {
            return $this->failed('The type is already exists', 422);
        }
        return $this->success(IndexClothingTypeRecourse::make(
            ClothingType::query()->create(['name' => $request['name']])
        ));
    }

    public function update(UpdateClothingTypeRequest $request, ClothingType $clothingType)
    {
        $prevClothingType = ClothingType::query()->firstWhere('name', $request['name']);

        if ($prevClothingType && $clothingType['id'] != $prevClothingType['id']) {
            return $this->failed('The type is already exists', 422);
        }
        $clothingType->update(['name' => $request['name']]);
        return $this->success(IndexClothingTypeRecourse::make($clothingType));
    }

    public function delete(ClothingType $clothingType)
    {
        $clothingType->delete();
        return $this->noContent();
    }
}

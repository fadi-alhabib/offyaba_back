<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupsecriptionOfferRequest;
use App\Http\Requests\UpdateSupsecriptionOfferRequest;
use App\Http\Resources\SubscriptionOfferResource;
use App\Models\SubscriptionOffer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionOfferController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->success(SubscriptionOfferResource::collection(
           SubscriptionOffer::all()
        ));
    }

    public function store(StoreSupsecriptionOfferRequest $request): JsonResponse
    {
        $offer = SubscriptionOffer::query()
                ->create($request->validated());
        return $this->success(SubscriptionOfferResource::make($offer));
    }

    public function update($offer,UpdateSupsecriptionOfferRequest $request): JsonResponse
    {
        $offer = SubscriptionOffer::query()->findOrFail($offer);
        $offer->update($request->validated());

        return $this->success(SubscriptionOfferResource::make($offer));
    }

    public function delete($offer): JsonResponse
    {
        $offer = SubscriptionOffer::query()->findOrFail($offer);
        $offer->delete();

        return $this->success(null, 'deleted', 204);
    }


}

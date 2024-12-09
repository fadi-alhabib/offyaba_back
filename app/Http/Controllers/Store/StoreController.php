<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Http\Resources\Store\FullStoreResource;
use App\Interfaces\StoreService;
use App\Models\Item;
use App\Models\Store;
use App\Services\ImageServices;
use App\Services\Store\FilterStoreService;
use App\Services\Store\NearStoreService;
use App\Services\Store\SuggestionsStoreService;
use App\Services\Store\WorkHourServices;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class StoreController extends Controller
{

    private StoreService $storeService;
    private WorkHourServices $workHourServices;
    protected $notification;
    public function __construct(WorkHourServices $workHourServices)
    {
        $this->workHourServices = $workHourServices;
        $this->notification = Firebase::messaging();
    }

    public function index(): JsonResponse
    {
        if (request('suggestion'))
            $this->storeService = new SuggestionsStoreService();
        else if (request('section_ids') || request('search_word'))
            $this->storeService = new FilterStoreService();
        else
            $this->storeService = new NearStoreService();

        return $this->success($this->storeService->get());
    }

    public function show(Store $store): JsonResponse
    {
        return $this->success(FullStoreResource::make($store));
    }

    public function store(CreateStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = ImageServices::save($request->file('image'), 'Store');
        }
        $store = Store::query()->create($data);
        if ($request['work_hours']) {
            $this->workHourServices->create($data['work_hours'], $store['id']);
        }
        $message = CloudMessage::fromArray([
            'topic' => 'user',
            'notification' => [
                'title' => $store->name . " لقد أنضم",
                'body' => $store->address,
            ],
        ]);
        $this->notification->send($message);
        return $this->success(FullStoreResource::make($store), 'ok', 201);
    }

    public function update(UpdateStoreRequest $request, $store): JsonResponse
    {
        $store = Store::query()->findOrFail($store);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($store['image'])
                $data['image'] = ImageServices::update($request->file('image'), $store['image']);
            else
                $data['image'] = ImageServices::save($request->file('image'), 'Store');
        }
        $store->update($data);

        if ($request['work_hours'])
            $this->workHourServices->update($data['work_hours'], $store['id']);

        return $this->success(FullStoreResource::make($store));
    }

    public function delete($store): JsonResponse
    {
        $store = Store::query()->findOrFail($store);
        if ($store['image']) ImageServices::delete($store['image']);
        $store->delete();
        return $this->success(null, 'deleted', 204);
    }

    public function deleteImage($store): JsonResponse
    {
        $store = Store::query()->findOrFail($store);
        if ($store['image']) {
            ImageServices::delete($store['image']);
            $store->update(['image' => null]);
            return $this->success(null, 'deleted', 204);
        }
        return $this->failed('not found', 404);
    }

    public function deleteWorkHour($store, $weekDay): JsonResponse
    {
        $store = Store::query()->findOrFail($store);
        $this->workHourServices->delete($weekDay, $store['id']);
        return $this->success(null);
    }

    public function getStoreItems(Store $store)
    {
        return $this->success($store->items, 'ok', 201);
    }
}

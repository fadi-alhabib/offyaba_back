<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Section\SectionRequest;
use App\Http\Resources\Store\SectionResource;
use App\Models\Section;
use App\Services\ImageServices;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->success(SectionResource::collection(
            Section::all()
        ));
    }

    public function show(Section $section): JsonResponse
    {
        return $this->success(SectionResource::make($section));
    }

    public function store(SectionRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = ImageServices::save($request->file('image'), 'Section');
        }
        $section = Section::query()->create($data);
        return $this->success(SectionResource::make($section), 'ok', 201);
    }

    public function update(SectionRequest $request, $section): JsonResponse
    {
        $section = Section::query()->findOrFail($section);
        $section->update($request->validated());
        return $this->success(SectionResource::make($section));
    }

    public function delete($section): JsonResponse
    {
        $section = Section::query()->findOrFail($section);
        $section->delete();
        return $this->success(null, 'ok', 204);
    }
}

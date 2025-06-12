<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterLabTestListRequest;
use App\Http\Requests\StoreLabTestRequest;
use App\Http\Requests\UpdateLabTestRequest;
use App\Http\Resources\LabTestResource;
use App\Models\Category;
use App\Models\LabTest;
use App\Services\LabTestFilterService;
use App\Services\LabTestService;
use App\ValueObjects\LabTestCreateData;
use App\ValueObjects\LabTestFilterListData;
use App\ValueObjects\LabTestUpdateData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LabTestController extends Controller
{
    public function __construct(private readonly LabTestService $service) {}

    public function index(FilterLabTestListRequest $request, LabTestFilterService $filterService): AnonymousResourceCollection
    {
        $filteredTests = $filterService->filter(LabTestFilterListData::fromValidated($request->validated()));

        return LabTestResource::collection($filteredTests);
    }

    public function store(StoreLabTestRequest $request): LabTestResource
    {
        $labTest = $this->service->create(LabTestCreateData::fromValidated($request->validated()));

        return new LabTestResource($labTest);
    }

    public function show(LabTest $labTest): LabTestResource
    {
        return new LabTestResource($labTest);
    }

    public function update(UpdateLabTestRequest $request, LabTest $labTest): Response
    {
        $this->service->update($labTest, LabTestUpdateData::fromValidated($request->validated()));

        return response()->noContent();
    }

    public function destroy(LabTest $labTest): Response
    {
        $this->service->delete($labTest);

        return response()->noContent();
    }

    public function getLabTestByCategory(Request $request, Category $category): AnonymousResourceCollection
    {
        $query = LabTest::whereHas('categories', function ($query) use ($category) {
            $query->where('categories.id', $category->id);
        });

        $perPage = $request->integer('per_page', self::PER_PAGE);

        return LabTestResource::collection($query->paginate($perPage)->withQueryString());
    }
}

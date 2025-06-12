<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\ValueObjects\CategoryCreateData;
use App\ValueObjects\CategoryUpdateData;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $service) {}

    public function index(): AnonymousResourceCollection
    {
        $categories = Category::withExists('labTests')->paginate(self::PER_PAGE);

        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = $this->service->create(CategoryCreateData::fromValidated($request->validated()));

        return new CategoryResource($category);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category): Response
    {
        $this->service->update($category, CategoryUpdateData::fromValidated($request->validated()));

        return response()->noContent();
    }

    public function destroy(Category $category): Response
    {
        $this->service->delete($category);

        return response()->noContent();
    }
}

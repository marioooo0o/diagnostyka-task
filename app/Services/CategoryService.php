<?php

namespace App\Services;

use App\Models\Category;
use App\ValueObjects\CategoryCreateData;
use App\ValueObjects\CategoryUpdateData;
use Symfony\Component\HttpFoundation\Response;

class CategoryService
{
    public function create(CategoryCreateData $data): Category
    {
        return Category::create($data->toArray());
    }

    public function update(Category $model, CategoryUpdateData $data): bool
    {
        return $model->update($data->toArray());
    }

    public function delete(Category $model): ?bool
    {
        abort_if($model->labTests()
            ->exists(), Response::HTTP_FORBIDDEN, 'Category cannot be deleted because it is associated with lab tests.');

        return $model->delete();
    }
}

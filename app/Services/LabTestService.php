<?php

namespace App\Services;

use App\Models\LabTest;
use App\ValueObjects\LabTestCreateData;
use App\ValueObjects\LabTestUpdateData;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LabTestService
{
    public function create(LabTestCreateData $data): LabTest
    {
        $labTest = DB::transaction(function () use ($data) {
            $labTest = LabTest::create([
                'name' => $data->name,
                'slug' => $data->slug,
                'description' => $data->description,
                'test_preparation' => $data->testPreparation,
            ]);

            $labTest->categories()->sync($data->categories);

            return $labTest;
        });

        return $labTest->refresh();
    }

    public function update(LabTest $model, LabTestUpdateData $data): bool
    {
        DB::transaction(function () use ($model, $data) {
            $model->update([
                'name' => $data->name,
                'slug' => $data->slug,
                'description' => $data->description,
                'test_preparation' => $data->testPreparation,
            ]);

            $model->categories()->sync($data->categories);
        });

        return true;
    }

    public function delete(LabTest $model): ?bool
    {
        abort_if($model->categories()
            ->exists(), Response::HTTP_FORBIDDEN, 'Lab test cannot be deleted because it is associated with categories.');


        return $model->delete();
    }
}

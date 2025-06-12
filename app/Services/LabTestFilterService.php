<?php

namespace App\Services;

use App\Models\LabTest;
use App\Strategies\Filters\FilterStrategyFactory;
use App\ValueObjects\LabTestFilterListData;
use Illuminate\Pagination\LengthAwarePaginator;

class LabTestFilterService
{
    public function filter(LabTestFilterListData $data): LengthAwarePaginator
    {
        $query = LabTest::query();

        foreach ($data->toArray() as $key => $value) {
            $strategy = FilterStrategyFactory::make($key);
            if ($strategy) {
                $query = $strategy->apply($query, $value);
            }
        }
        $perPage = $data->perPage;

        return $query->paginate($perPage)->withQueryString();
    }
}

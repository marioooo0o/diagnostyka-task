<?php

namespace App\Strategies\Filters;

use Illuminate\Database\Eloquent\Builder;

class FilterByName implements LabTestFilterStrategyInterface
{
    public function __construct(private string $field = 'name') {}

    public function apply(Builder $query, mixed $value): Builder
    {
        return $query->where($this->field, 'like', "%$value%");
    }
}

<?php

namespace App\Strategies\Filters;

use Illuminate\Database\Eloquent\Builder;

interface LabTestFilterStrategyInterface
{
    public function apply(Builder $query, mixed $value): Builder;
}

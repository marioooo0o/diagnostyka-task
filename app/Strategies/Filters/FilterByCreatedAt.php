<?php

namespace App\Strategies\Filters;

use Illuminate\Database\Eloquent\Builder;

class FilterByCreatedAt implements LabTestFilterStrategyInterface
{
    public function apply(Builder $query, mixed $value): Builder
    {
        if (! is_array($value)) {
            return $query;
        }

        if (! empty($value['from'])) {
            $query->whereDate('created_at', '>=', $value['from']);
        }

        if (! empty($value['to'])) {
            $query->whereDate('created_at', '<=', $value['to']);
        }

        return $query;
    }
}

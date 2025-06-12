<?php

namespace App\Strategies\Filters;

class FilterStrategyFactory
{
    public static function make(string $key): ?LabTestFilterStrategyInterface
    {
        return match ($key) {
            'name' => new FilterByName,
            'slug' => new FilterByName('slug'),
            'created_at' => new FilterByCreatedAt,
            default => null,
        };
    }
}

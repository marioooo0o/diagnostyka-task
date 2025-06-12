<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabTestResource extends JsonResource
{
    public const JSON_STRUCTURE = [
        'id',
        'name',
        'slug',
        'description',
        'test_preparation',
        'created_at',
        'updated_at',
    ];

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'test_preparation' => $this->test_preparation,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'categories_exists' => $this->whenExistsLoaded('categories', $this->categories_exists),
        ];
    }
}

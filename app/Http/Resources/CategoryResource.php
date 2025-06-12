<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property bool $lab_tests_exists
 */
class CategoryResource extends JsonResource
{
    public const JSON_STRUCTURE = [
        'id',
        'name',
        'slug',
        'description',
        'created_at',
        'updated_at',
    ];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'lab_tests_exists' => $this->whenExistsLoaded('labTests', $this->lab_tests_exists),
        ];
    }
}

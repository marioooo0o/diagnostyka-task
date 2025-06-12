<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

final class LabTestUpdateData implements Arrayable
{
    public function __construct(
        public string $name,
        public string $slug,
        public ?string $description,
        public ?string $testPreparation,
        public array $categories,
    ) {}

    public static function fromValidated(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'] ?? null,
            testPreparation: $data['test_preparation'] ?? null,
            categories: $data['categories'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'test_preparation' => $this->testPreparation,
            'categories' => $this->categories,
        ];
    }
}

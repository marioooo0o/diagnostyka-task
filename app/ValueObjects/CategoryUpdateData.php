<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

final class CategoryUpdateData implements Arrayable
{

    public function __construct(public string $name, public string $slug, public ?string $description = null)
    {
    }

    public static function fromValidated(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ];
    }
}

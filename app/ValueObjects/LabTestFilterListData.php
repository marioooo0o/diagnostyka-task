<?php

namespace App\ValueObjects;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Arrayable;

final class LabTestFilterListData implements Arrayable
{
    public function __construct(
        public int     $perPage = Controller::PER_PAGE,
        public ?string $name = null,
        public ?string $createdFrom = null,
        public ?string $createdTo = null,
    )
    {
    }

    public static function fromValidated(array $data): self
    {
        return new self(
            perPage: $data['per_page'] ?? Controller::PER_PAGE,
            name: $data['name'] ?? null,
            createdFrom: $data['created_at']['from'] ?? null,
            createdTo: $data['created_at']['to'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'per_page' => $this->perPage,
            'name' => $this->name,
            'created_at' => [
                'from' => $this->createdFrom,
                'to' => $this->createdTo,
            ],
        ];
    }
}

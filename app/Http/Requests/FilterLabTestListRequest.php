<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterLabTestListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'per_page' => 'nullable|integer|min:1|max:30',
            'name' => 'nullable|string|max:255',
            'created_at.from' => 'nullable|date',
            'created_at.to' => 'nullable|date|after_or_equal:created_at.from',
        ];
    }
}

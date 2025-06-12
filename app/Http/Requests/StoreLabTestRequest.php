<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:32|unique:lab_tests,name',
            'slug' => 'required|string|max:64|unique:lab_tests,slug',
            'description' => 'nullable|string|max:1000',
            'test_preparation' => 'nullable|string|max:1000',
            'categories' => 'present|array',
            'categories.*' => 'integer|exists:categories,id',
        ];
    }
}

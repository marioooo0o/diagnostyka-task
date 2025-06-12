<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->route('category')->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->route('category')->id,
            'description' => 'nullable|string|max:1000',
        ];
    }
}

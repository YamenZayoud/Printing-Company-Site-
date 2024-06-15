<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categoryId' => [Rule::exists('categories', 'id')->whereNull('deleted_at'), 'required'],
            'name' => [Rule::unique('categories')->whereNull('deleted_at')->ignore($this->categoryId, 'id'), 'required'],
            'image' => 'nullable|image',
            ];
    }
}

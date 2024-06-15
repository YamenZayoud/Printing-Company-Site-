<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProductRequest extends FormRequest
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
            'category_id' => [Rule::exists('categories', 'id')->whereNull('deleted_at'), 'required'],
            'name' => 'required',
            'description' => 'required',
            'images' => 'required',
            'images.*' => 'required|image',
            'quantities' => 'required',
            'quantities.*.range_from' => 'required|numeric',
            'quantities.*.range_to' => 'required|numeric|gt:quantities.*.range_from',
            'quantities.*.price_per_unit' => 'required|numeric',
        ];
    }
}

<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RatingRequest extends FormRequest
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
        //changeWhenProductAdd change states to products
        return [
            'product_id' => [Rule::exists('products', 'id')->whereNull('deleted_at'), 'required'],
            'rating' => 'required|numeric|min:1|max:5',
        ];
    }
}

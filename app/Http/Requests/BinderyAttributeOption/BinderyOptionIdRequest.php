<?php

namespace App\Http\Requests\BinderyAttributeOption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BinderyOptionIdRequest extends FormRequest
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
            'binderyOptionId' => [Rule::exists('bindery_attribute_options', 'id')->whereNull('deleted_at'), 'required'],

        ];
    }
}

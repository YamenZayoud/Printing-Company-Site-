<?php

namespace App\Http\Requests\BinderyAttribute;

use App\Enums\AttributeTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddBinderyAttributeRequest extends FormRequest
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
           'name' => [Rule::unique('bindery_attributes')->whereNull('deleted_at'),'required'],
            'attribute_type' => [Rule::in(AttributeTypeEnum::toArray(),'numeric','required')],
        ];
    }
}

<?php

namespace App\Http\Requests\NormalAttribute;

use App\Enums\AttributeTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditNormalAttributeRequest extends FormRequest
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
            'normalAttId' => [Rule::exists('normal_attributes','id')->whereNull('deleted_at'),'required'],
            'name' => [Rule::unique('normal_attributes')->whereNull('deleted_at')->ignore($this->normalAttId,'id'),'required'],
            'attribute_type' => [Rule::in(AttributeTypeEnum::toArray(),'numeric','required')],
        ];
    }
}

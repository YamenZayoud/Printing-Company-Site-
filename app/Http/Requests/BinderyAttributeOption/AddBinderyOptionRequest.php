<?php

namespace App\Http\Requests\BinderyAttributeOption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddBinderyOptionRequest extends FormRequest
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
            'bindery_att_id' => [Rule::exists('bindery_attributes', 'id')->whereNull('deleted_at'), 'required'],
            'name' => [Rule::unique('bindery_attribute_options')
                ->whereNull('deleted_at')
                ->where('bindery_att_id', $this->bindery_att_id), 'required'],
            'setup_price' => 'required|numeric',
            'price_per_unit' => 'required|numeric',
            'markup' => 'required|numeric',
        ];
    }
}

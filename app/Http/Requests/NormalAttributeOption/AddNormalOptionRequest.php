<?php

namespace App\Http\Requests\NormalAttributeOption;

use App\Enums\PriceTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddNormalOptionRequest extends FormRequest
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
            'normal_att_id' => [Rule::exists('normal_attributes', 'id')->whereNull('deleted_at'), 'required'],
            'name' => [Rule::unique('normal_attribute_options')
                ->whereNull('deleted_at')
                ->where('normal_att_id', $this->normal_att_id)
                , 'required'],
            'price_type' => [Rule::in(PriceTypeEnum::toArray()), 'required'],
            'flat_price' => [Rule::requiredIf($this->price_type == PriceTypeEnum::FlatPrice),'numeric'],
            'formula_price' => [Rule::requiredIf($this->price_type == PriceTypeEnum::FormulaPrice)],
        ];
    }
}

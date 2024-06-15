<?php

namespace App\Http\Requests\NormalAttributeOption;

use App\Enums\PriceTypeEnum;
use App\Models\NormalAttributeOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditNormalOptionRequest extends FormRequest
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
            'normalOptionId' => [Rule::exists('normal_attribute_options', 'id')->whereNull('deleted_at'), 'required'],
            'name' => [Rule::unique('normal_attribute_options')
                ->whereNull('deleted_at')
                ->where(function ($query) {
                    $normalOption = NormalAttributeOption::find($this->normalOptionId);
                    $query->where('normal_att_id', $normalOption->normal_att_id);
                })
                ->ignore($this->normalOptionId, 'id')
                , 'required'],
            'price_type' => [Rule::in(PriceTypeEnum::toArray()), 'required'],
            'flat_price' => [Rule::requiredIf($this->price_type == PriceTypeEnum::FlatPrice),'numeric'],
            'formula_price' => [Rule::requiredIf($this->price_type == PriceTypeEnum::FormulaPrice)],
        ];
    }
}

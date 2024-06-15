<?php

namespace App\Http\Requests\Cart;

use App\Enums\AttributeTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
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
            'product_id' => [Rule::exists('products', 'id')->whereNull('deleted_at'), 'required'],
            'quantity_id' => [Rule::exists('product_quantities', 'id')->where('product_id', $this->product_id), 'required'],
            'custom_quantity' => 'nullable|numeric',
            'bindery_att' => 'required',
            'bindery_att.*.attribute_type' => [Rule::in(AttributeTypeEnum::toArray()), 'required'],
            'bindery_att.*.att_option' => [Rule::exists('bindery_attribute_options', 'id'), 'required'],
            'bindery_att.*.value' => 'numeric|required_if:bindery_att.*.attribute_type,' . AttributeTypeEnum::TextInput,
            'normal_att' => 'required',
            'normal_att.*.attribute_type' => [Rule::in(AttributeTypeEnum::toArray()), 'required'],
            'normal_att.*.att_option' => [Rule::exists('normal_attribute_options', 'id'), 'required'],
            'normal_att.*.value' => 'numeric|required_if:normal_att.*.attribute_type,' . AttributeTypeEnum::TextInput,
            'work_days_id' => [Rule::exists('settings','id')->where('description','$ work $ days $'),'required'],
        ];
    }
}

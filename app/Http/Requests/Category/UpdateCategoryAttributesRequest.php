<?php

namespace App\Http\Requests\Category;

use App\Models\BinderyAttributeOption;
use App\Models\NormalAttributeOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryAttributesRequest extends FormRequest
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
            // bindery Att Array
            'bindery_att' => 'required|array',
            'bindery_att.*.att_id' => [Rule::exists('bindery_attributes', 'id')
                ->whereNull('deleted_at'), 'required', 'distinct'],
            'bindery_att.*.att_options' => 'required|array',
            'bindery_att.*.att_options.*' => [Rule::exists('bindery_attribute_options', 'id')
                ->whereNull('deleted_at')
                , 'required', 'distinct', function ($attribute, $value, $fail) {
                    $currentAttId = (int)explode('.', $attribute)[1];
                    $value = BinderyAttributeOption::find($value);
                    if (!$value || $value->bindery_att_id != $this->bindery_att[$currentAttId]['att_id']) {
                        $fail("Option Not Exists In Attribute");
                    }
                }],
            // normal Att Array
            'normal_att' => 'required|array',
            'normal_att.*.att_id' => [Rule::exists('normal_attributes', 'id')
                ->whereNull('deleted_at'), 'required', 'distinct'],
            'normal_att.*.att_options' => 'required|array',
            'normal_att.*.att_options.*' => [Rule::exists('normal_attribute_options', 'id')
                ->whereNull('deleted_at'), 'required', 'distinct', function ($attribute, $value, $fail) {
                $currentAttId = (int)explode('.', $attribute)[1];
                $value = NormalAttributeOption::find($value);
                if (!$value || $value->normal_att_id != $this->normal_att[$currentAttId]['att_id']) {
                    $fail("Option Not Exists In Attribute");
                }
            }],
        ];
    }
}

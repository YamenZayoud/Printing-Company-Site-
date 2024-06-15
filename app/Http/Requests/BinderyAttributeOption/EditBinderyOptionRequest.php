<?php

namespace App\Http\Requests\BinderyAttributeOption;

use App\Models\BinderyAttributeOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditBinderyOptionRequest extends FormRequest
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
            'name' =>  [
        Rule::unique('bindery_attribute_options')
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $binderyOption = BinderyAttributeOption::find($this->binderyOptionId);
                $query->where('bindery_att_id', $binderyOption->bindery_att_id);
            })
            ->ignore($this->binderyOptionId, 'id')
        ,'required'],
            'setup_price' => 'required|numeric',
            'price_per_unit' => 'required|numeric',
            'markup' => 'required|numeric',
        ];
    }
}

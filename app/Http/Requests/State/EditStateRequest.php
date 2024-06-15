<?php

namespace App\Http\Requests\State;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditStateRequest extends FormRequest
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
            'stateId' => [Rule::exists('states','id')->whereNull('deleted_at'),'required'],
            'name' => [Rule::unique('states')->whereNull('deleted_at')->ignore($this->stateId,'id'),'required'],
        ];
    }
}

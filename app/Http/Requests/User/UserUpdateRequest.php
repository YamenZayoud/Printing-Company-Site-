<?php

namespace App\Http\Requests\User;

use App\Enums\ActiveStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'userId' => [Rule::exists('users', 'id')->whereNull('deleted_at'), 'required'],
            'f_name' => 'required',
            'l_name' => 'required',
            'company_name' => 'required',
            'email' => [Rule::unique('users')->whereNull('deleted_at')->ignore($this->userId), 'required', 'email'],
            'phone' => 'required|min:10|max:10',
            'display_name' => 'required',
            'state_id' => [Rule::exists('states', 'id')->whereNull('deleted_at')->where('is_active', ActiveStatusEnum::ACTIVE), 'required'],
            'address' => 'required',
            'zip_code' => 'required',
            'image' => 'nullable|image',

        ];
    }
}

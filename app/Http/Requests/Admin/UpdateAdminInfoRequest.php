<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminInfoRequest extends FormRequest
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
            'adminId' => [Rule::exists('admins', 'id')->whereNull('deleted_at'), 'required'],
            'name' => 'required',
            'email' => [Rule::unique('admins')->whereNull('deleted_at')->ignore($this->adminId, 'id'), 'required', 'email'],
        ];
    }
}

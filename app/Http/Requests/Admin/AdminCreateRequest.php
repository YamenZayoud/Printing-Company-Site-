<?php

namespace App\Http\Requests\Admin;

use App\Enums\ActiveStatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
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
            'name' => 'required',
            'email' => [Rule::unique('admins')->whereNull('deleted_at'),'required','email'],
            'password' => 'required|min:8|confirmed',
            'permissions' => 'required',
            'permissions.*'=> [Rule::exists('permissions','uuid'),'required','distinct'],
        ];
    }
}

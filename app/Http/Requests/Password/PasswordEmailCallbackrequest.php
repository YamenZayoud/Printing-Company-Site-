<?php

namespace App\Http\Requests\Password;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordEmailCallbackrequest extends FormRequest
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
            'token' => 'string|min:60',
            'email' => [Rule::exists('users','email')->whereNull('deleted_at'), 'required']
        ];
    }
}

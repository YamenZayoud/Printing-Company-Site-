<?php

namespace App\Http\Requests\Password;

use App\Rules\CheckIfExisits;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'id' => [new CheckIfExisits, 'required'],
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed',
        ];
    }
}

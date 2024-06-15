<?php

namespace App\Http\Requests\SocialPlatforms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddSocialPlatformRequest extends FormRequest
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
            'name' => [Rule::unique('socials')->whereNull('deleted_at'),'required'],
            'icon' => 'required|image',
        ];
    }
}

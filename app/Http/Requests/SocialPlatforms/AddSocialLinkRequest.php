<?php

namespace App\Http\Requests\SocialPlatforms;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddSocialLinkRequest extends FormRequest
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
            'social_id' => [Rule::exists('socials','id')->whereNull('deleted_at'),'required'],
            'link' => 'required',
        ];
    }
}

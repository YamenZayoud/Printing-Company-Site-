<?php

namespace App\Http\Requests\Quote;

use App\Enums\CartStatusEnum;
use App\Enums\QuoteStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeQuoteStatusRequest extends FormRequest
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
            'quoteId' => [Rule::exists('quotes', 'id'), 'required'],
            'status' => [Rule::in(QuoteStatusEnum::ChangeStatus()), 'required'],
        ];
    }
}

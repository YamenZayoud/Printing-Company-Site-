<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckIfExisits implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! (DB::table('users')->where('id', $value)->whereNull('deleted_at')->exists() || 
               DB::table('admins')->where('id', $value)->whereNull('deleted_at')->exists())) {

            $fail('The record not exist');
        }
    }
}

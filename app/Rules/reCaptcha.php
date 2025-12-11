<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Http;

class reCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  /\Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::get("https://www.google.com/recaptcha/api/siteverify", [
            "secret" => env('RECAPTCHA_SECRET_KEY'),
            "response" => $value
        ])->json();

        if(!$response['success']) {
            $fail("Google recaptcha tidak valid!");
        }
    }
}

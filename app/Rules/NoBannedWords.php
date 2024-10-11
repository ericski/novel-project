<?php

namespace App\Rules;

use App\Models\BannedWord;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoBannedWords implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Retrieve all banned words from the database
        $bannedWords = BannedWord::pluck('word')->toArray();
        //dd($bannedWords);

        // Check if any banned word is present in the title
        foreach ($bannedWords as $bannedWord) {
            if (stripos($value, $bannedWord) !== false) {
                $fail('The :attribute cannot contain the word "' . $bannedWord . '".');
            }
        }
    }

}

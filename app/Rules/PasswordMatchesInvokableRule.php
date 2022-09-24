<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Hash;

class PasswordMatchesInvokableRule implements InvokableRule
{
  /**
   * Run the validation rule.
   *
   * @param string $attribute
   * @param mixed $value
   * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
   * @return void
   */
  public function __invoke($attribute, $value, $fail)
  {
    if (!Hash::check($value, auth()->user()->password)) {
      $fail('Incorrect password!');
    }
  }
}

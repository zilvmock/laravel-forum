<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Hash;

class PasswordIsTheSameInvokableRule implements InvokableRule
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
    if (Hash::check($value, auth()->user()->password)) {
      $fail('New and current passwords are the same!');
    }
  }
}

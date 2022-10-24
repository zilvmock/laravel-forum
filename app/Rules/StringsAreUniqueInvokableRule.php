<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class StringsAreUniqueInvokableRule implements InvokableRule
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
    $tags = explode(',', $value);
    if (count($tags) > count(array_unique($tags))) {
      $fail('Tags must be unique!');
    }
  }
}

<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleLikes>
 */
class ArticleLikesFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'user_id' => rand(1, config('dbSeedAmounts.users')),
      'article_id' => rand(1, config('dbSeedAmounts.articles')),
    ];
  }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'content' => fake()->sentence(rand(2, 15)),
      'user_id' => rand(1, config('dbSeedAmounts.users')),
      'article_id' => rand(1, config('dbSeedAmounts.articles')),
    ];
  }
}

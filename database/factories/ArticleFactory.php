<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $title = str_replace('.', '', fake()->sentence(rand(2, 5)));
    return [
      'title' => $title,
      'slug' => Str::slug($title),
      'content' => fake()->paragraph(rand(5, 30)),
      'tags' => str_replace('.', '', str_replace(' ', ', ', fake()->sentence(rand(1, 4)))),
      'user_id' => rand(1, config('dbSeedAmounts.users')),
      'category_id' => rand(1, config('dbSeedAmounts.categories')),
    ];
  }
}

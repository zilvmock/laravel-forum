<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $title = str_replace('.', '', fake()->unique()->sentence(rand(2, 8)));
    return [
      'group_id' => rand(1, config('dbSeedAmounts.groups')),
      'title' => $title,
      'slug' => Str::Slug($title),
      'description' => fake()->sentence(rand(5, 20)),
    ];
  }
}

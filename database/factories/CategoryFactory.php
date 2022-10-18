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
    return [
      'title' => fake()->text(rand(20, 100)),
      'slug' => '',
      'description' => fake()->text(rand(100, 200)),
      'group_id' => Group::factory(),
    ];
  }
}

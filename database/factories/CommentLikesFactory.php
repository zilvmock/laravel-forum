<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommentLikes>
 */
class CommentLikesFactory extends Factory
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
      'comment_id' => rand(1, config('dbSeedAmounts.comments')),
    ];
  }
}

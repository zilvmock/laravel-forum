<?php

namespace Database\Seeders;

use App\Models\CommentLikes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentLikesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    CommentLikes::factory()->times(config('dbSeedAmounts.commentLikes'))->create();
  }
}

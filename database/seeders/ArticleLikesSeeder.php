<?php

namespace Database\Seeders;

use App\Models\ArticleLikes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleLikesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    ArticleLikes::factory()->times(config('dbSeedAmounts.articleLikes'))->create();
  }
}

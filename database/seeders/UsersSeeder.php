<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class UsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->clearAvatars();
    User::factory()->times(config('dbSeedAmounts.users'))->create();
  }

  private function clearAvatars()
  {
    $fs = new Filesystem;
    $prevAvatars = $fs->files(storage_path('app/public/avatars'));
    foreach ($prevAvatars as $avatar) {
      $fs->delete($avatar);
    }
  }
}

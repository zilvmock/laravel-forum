<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    Category::factory(5)->create();
    Group::factory(3)->create();
    //Group::factory(2)->has(Category::factory()->count(2))->create();
//        Category::factory(5)->create();
    //Category::factory(2)->has(Group::factory()->count(2))->create();
    // \App\Models\User::factory(10)->create();

    User::factory()->create();
  }
}

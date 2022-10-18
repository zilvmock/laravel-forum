<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\ArticleLikes;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentLikes;
use App\Models\Group;
use App\Models\User;
use Database\Factories\ArticleLikesFactory;
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
//    User::factory(5)->create();

//    Group::factory(5)->create();
    Category::factory(5)->create();
    Comment::factory(5)->create();
    ArticleLikes::factory(5)->create();
    CommentLikes::factory(5)->create();
    $categories = Category::all();
    $articles = Article::all();
    foreach ($categories as $category) {
      $category['slug'] = $category->slug;
      $category->save();
    }
    foreach ($articles as $article) {
      $article['slug'] = $article->slug;
      $article->save();
    }
//    Article::factory(5)->create();
    //Group::factory(2)->has(Category::factory()->count(2))->create();
//        Category::factory(5)->create();
    //Category::factory(2)->has(Group::factory()->count(2))->create();
    // \App\Models\User::factory(10)->create();

  }
}

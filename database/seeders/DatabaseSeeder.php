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
    $this->call(UsersSeeder::class);
    $this->call(GroupsSeeder::class);
    $this->call(CategoriesSeeder::class);
    $this->call(ArticlesSeeder::class);
    $this->call(ArticleLikesSeeder::class);
    $this->call(CommentsSeeder::class);
    $this->call(CommentLikesSeeder::class);

    //Old Way
//    Category::factory(5)->create();
//    Comment::factory(50)->create();
//    ArticleLikes::factory(5)->create();
//    CommentLikes::factory(5)->create();
//    $categories = Category::all();
//    $articles = Article::all();
//    foreach ($categories as $category) {
//      $category['slug'] = $category->slug;
//      $category->save();
//    }
//    foreach ($articles as $article) {
//      $article['slug'] = $article->slug;
//      $article->save();
//    }
  }
}

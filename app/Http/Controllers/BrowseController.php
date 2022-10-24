<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BrowseController extends Controller
{
  // Views
  // **********************
  public function showBrowseView()
  {
    $categories = Category::select('id', 'group_id', 'title', 'slug', 'description')->get();
    $uniqueGroups = Group::select('id', 'title')->distinct()->get();
    $groupIds = $categories->unique('group_id');
    $empty = collect();
    foreach ($groupIds as $id) {
      $empty->push($id['group_id']);
    }

    $categoriesData = [];
    $articles = Article::select('id', 'user_id', 'category_id', 'title', 'slug', 'created_at')->get();
    $comments = Comment::select('id', 'user_id', 'article_id', 'created_at')->get();
    foreach ($categories as $category) {
      $allArticlesInCategory = $articles->where('category_id', '=', $category->id);
      $latestComment = $comments->whereIn('article_id', $allArticlesInCategory->pluck('id'))->sortByDesc('created_at')->first();
      $latestArticle = $allArticlesInCategory->sortByDesc('created_at')->first();

      if ($latestComment == null && $latestArticle == null) {
        $latestActivity = null;
      } else if ($latestComment == null) {
        $latestActivity = $latestArticle;
      } else if ($latestArticle == null) {
        $latestActivity = $latestComment;
      } else {
        $latestActivity = $latestComment->created_at > $latestArticle->created_at ? $latestComment : $latestArticle;
      }

      $categoriesData[] = [
        'id' => $category['id'],
        'title' => $category['title'],
        'slug' => $category['slug'],
        'description' => $category['description'],
        'group' => $uniqueGroups->firstWhere('id', '=', $category->group_id)->title,
        'latestActivity' => $latestActivity,
      ];
    }

    $latestArticles = $articles->sortByDesc('created_at')->take(3);

    return view('forum.browse', [
      'categoriesData' => $categoriesData,
      'groups' => $uniqueGroups,
      'empty' => $empty,
      'latestArticles' => $latestArticles,
    ]);
  }

  public function showCategoryView(Request $request)
  {
    $articles = Article::select('id', 'user_id', 'title', 'slug', 'content', 'tags', 'created_at')->where('category_id', '=', $request->id)->paginate(10);
    $comments = Comment::select('id', 'article_id', 'user_id', 'created_at')->whereIn('article_id', $articles->pluck('id'))->get();
    $articleData = collect();
    foreach ($articles as $article) {
      $latestComment = $comments->where('article_id', '=', $article->id)->sortByDesc('created_at')->first();
      if ($latestComment == null && $article == null) {
        $latestActivity = null;
      } else if ($latestComment == null) {
        $latestActivity = $article;
      } else if ($article == null) {
        $latestActivity = $latestComment;
      } else {
        $latestActivity = $latestComment->created_at > $article->created_at ? $latestComment : $article;
      }
      $articleData->push([
        'id' => $article->id,
        'title' => $article->title,
        'slug' => $article->slug,
        'contentSnippet' => Str::limit($article->content, 100),
        'tags' => $article->tags,
        'latestActivity' => $latestActivity,
      ]);
    }
    $categoryInfo = Category::select('title', 'slug')->where('id', '=', $request->id)->first();
    $latestArticles = Article::select('id', 'user_id', 'category_id', 'title', 'slug', 'created_at')->get()->sortByDesc('created_at')->take(3);

    return view('forum.browse-category', [
      'articleData' => $articleData->paginate(10),
      'categoryData' => [
        'id' => $request->id,
        'title' => $categoryInfo->title,
        'slug' => $categoryInfo->slug,
      ],
      'latestArticles' => $latestArticles,
    ]);
  }

  public function showArticleView(Request $request)
  {
    $articleId = $request->id;
    $article = Article::where('id', '=', $articleId)->first();
    $articleComments = Comment::where('article_id', '=', $articleId)->paginate(7);
    return view('forum.view_article', [
      'article' => $article,
      'articleId' => $articleId,
      'articleComments' => $articleComments,
    ]);
  }
  // **********************
}

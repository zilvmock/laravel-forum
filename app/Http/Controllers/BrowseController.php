<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Group;
use Illuminate\Http\Request;


class BrowseController extends Controller
{
  // Views
  // **********************
  public function showBrowseView()
  {
    $comments = Comment::all();
    $articles = Article::all();
    $categories = Category::all();
    $groups = Group::all();

    // Grouping
    $uniqueGroups = $groups->unique('title');
    $groupIds = $categories->unique('group_id');
    $empty = collect();
    foreach ($groupIds as $id) {
      $empty->push($id['group_id']);
    }
    return view('forum/browse', [
      'articles' => $articles,
      'comments' => $comments,
      'categories' => $categories,
      'groups' => $uniqueGroups,
      'empty' => $empty
    ]);
  }

  public function showCategoryView(Category $category)
  {
    $articles = Article::all()->where('category_id', '==', $category->id);
    $comments = Comment::all();

    return view('forum.browse-category', [
      'category' => $category,
      'articles' => $articles,
      'comments' => $comments,
    ]);
  }

  public function showArticleView(Request $request)
  {
    $articleId = $request->id;
    $article = Article::firstWhere('id', '=', $articleId);
    $articleComments = Comment::where('article_id', '=', $articleId);
    return view('forum.view_article', [
      'article' => $article,
      'articleId' => $articleId,
      'articleComments' => $articleComments->paginate(7),
    ]);
  }
  // **********************
}

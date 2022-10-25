<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Rules\StringsAreUniqueInvokableRule;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
  // Return views
  // **********************
  public function showCreateArticle($categoryId)
  {
    return view('forum.create-article', [
      'categoryId' => $categoryId,
    ]);
  }

  public function showEditArticle(Request $request, $articleId)
  {
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $article = Article::firstWhere('id', '=', $articleId);
      return view('forum.edit-article', [
        'article' => $article,
      ]);
    }
  }
  // **********************
  // Store
  // **********************
  public function storeArticle(Request $request)
  {
    $fields = [
      'title' => strip_tags(clean($request->title)),
      'article_content' => $request->article_content,
      'tags' => strip_tags(clean($request->tags)),
    ];

    $validator = Validator::make($fields, [
      'title' => ['required', 'max:100'],
      'article_content' => ['required'],
      'tags' => ['required', 'max:100', new StringsAreUniqueInvokableRule],
    ], [
      'required' => 'The :attribute field can not be blank!',
      'tags.required' => 'Article must have at least one tag!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      $slug = SlugService::createSlug(Article::class, 'slug', $fields['title']);
      $articleId = Article::insertGetId([
        'title' => $fields['title'],
        'slug' => $slug,
        'content' => $fields['article_content'],
        'tags' => $fields['tags'],
        'created_at' => $timeNow,
        'updated_at' => $timeNow,
        'user_id' => auth()->user()->id,
        'category_id' => $request->categoryId,
      ]);
      return redirect('/forum/browse/' . Category::firstWhere('id', '=', $request->categoryId)->slug . '/' . $slug . '/' . $articleId)
        ->with([
          'article' => Article::all()->firstWhere('id', '=', $articleId),
          'articleComments' => Comment::where('article_id', '=', $articleId)->paginate(7),
          'articleId' => $articleId,
        ]);
    } else {
      return redirect()->back()->withInput()->withErrors($validator);
    }
  }

  public function updateArticle(Request $request, $articleId)
  {
    $fields = [
      'title' => strip_tags(clean($request->title)),
      'article_content' => $request->article_content,
      'tags' => strip_tags(clean($request->tags)),
    ];

    $validator = Validator::make($fields, [
      'title' => ['required', 'max:100'],
      'article_content' => ['required'],
      'tags' => ['required', 'max:100', new StringsAreUniqueInvokableRule],
    ], [
      'required' => 'The :attribute field can not be blank!',
      'tags.required' => 'Article must have at least one tag!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      $slug = SlugService::createSlug(Article::class, 'slug', $fields['title']);
      $article = Article::firstWhere('id', '=', $articleId);
      $article->update([
        'title' => $fields['title'],
        'slug' => $slug,
        'content' => $fields['article_content'],
        'tags' => $fields['tags'],
        'content_updated_at' => $timeNow,
      ]);
      $article->save();
      return redirect('/forum/browse/' . Category::firstWhere('id', '=', $article->category_id)->slug . '/' . $article->slug . '/' . $articleId)
        ->with([
          'article' => Article::all()->firstWhere('id', '==', $articleId),
          'articleComments' => Comment::all()->where('article_id', '==', $articleId),
        ])->with('message', 'Article has been updated!');
    } else {
      return redirect()->back()->withInput()->withErrors($validator);
    }
  }
  // **********************
  // Delete
  public function deleteArticle(Request $request, $articleId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }
    Article::all()->firstWhere('id', '=', $articleId)->delete();
    return redirect(route('browse'))->with('message', 'Article deleted!');
  }
  // **********************
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Rules\StringsAreUniqueInvokableRule;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
  // Return views
  // **********************
  public function showCreateArticle()
  {
    $categories = Category::all();
    return view('forum.create-article', [
      'categories' => $categories,
    ]);
  }

  public function showEditArticle(Request $request, $articleId)
  {
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $categories = Category::all();
      $article = Article::all()->firstWhere('id', '==', $articleId);
      return view('forum.edit-article', [
        'categories' => $categories,
        'article' => $article,
      ]);
    }
  }
  // **********************
  // Store
  // **********************
  public function storeArticle(Request $request)
  {
    $slug = SlugService::createSlug(Article::class, 'slug', $request->title);
    $slugValidator = Validator::make([$slug], [
      'slug' => 'unique:articles'
    ]);
    if ($slugValidator->passes()) {
      $validator = Validator::make($request->all(), [
        'title' => ['required', 'max:100'],
        'article_content' => ['required'],
        'tags' => ['required', 'max:100', new StringsAreUniqueInvokableRule],
        'categoryId' => ['required']
      ], [
        'required' => 'The :attribute field can not be blank!',
        'tags.required' => 'Article must have at least one tag!',
        'categoryId.required' => 'Category must be selected!'
      ]);

      if ($validator->passes()) {
        $timeNow = Carbon::now();

        $articleId = Article::insertGetId([
          'title' => $request->title,
          'slug' => $slug,
          'content' => $request->article_content,
          'tags' => $request->tags,
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
  }

  public function updateArticle(Request $request, $articleId)
  {
    $validator = Validator::make($request->all(), [
      'title' => ['required', 'max:100'],
      'article_content' => ['required'],
      'tags' => ['required', 'max:100', new StringsAreUniqueInvokableRule],
      'categoryId' => ['required']
    ], [
      'required' => 'The :attribute field can not be blank!',
      'tags.required' => 'Article must have at least one tag!',
      'categoryId.required' => 'Category must be selected!'
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      $article = Article::all()->firstWhere('id', '==', $articleId);
      $article->update([
        'title' => $request->title,
        'content' => $request->article_content,
        'tags' => $request->tags,
        'content_updated_at' => $timeNow,
      ]);
      $article->category_id = $request->categoryId;
      $article->save();
      return redirect('/forum/browse/' . Category::firstWhere('id', '=', $request->categoryId)->slug . '/' . $article->slug . '/' . $articleId)
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
  public function deleteArticle($articleId)
  {
    Article::all()->firstWhere('id', '==', $articleId)->delete();
    return redirect(route('browse'))->with('message', 'Article deleted!');
  }
  // **********************
}

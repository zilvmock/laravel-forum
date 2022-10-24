<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Group;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
  // View
  // **********************
  public function showCreateGroup(Request $request)
  {
    if ($request->user()->id != 1) {
      return redirect()->route('browse');
    } else {
      $categories = Category::select('id', 'title', 'description', 'group_id', 'description')->get();
      $categoryData = [];
      foreach ($categories as $category) {
        $articlesInCategory = Article::select('id', 'title')->where('category_id', $category->id);
        $commentsInCategory = Comment::select('id')->whereIn('article_id', $articlesInCategory->pluck('id'))->count();
        $categoryData[] = ([
          'id' => $category->id,
          'title' => $category->title,
          'description' => $category->description,
          'categoryTitle' => $category->title,
          'articleAmount' => $articlesInCategory->count(),
          'commentAmount' => $commentsInCategory,
        ]);
      }

      return view('forum.manage.create-group', [
        'categoryData' => $categoryData,
      ]);
    }
  }

  public function showCreateCategory(Request $request, $groupId)
  {
    if ($request->user()->id != 1) {
      return redirect()->route('browse');
    } else {
      $articles = Article::select('id', 'category_id', 'title', 'content')->get();
      $articleData = [];
      foreach ($articles as $article) {
        $articleData[] = ([
          'id' => $article->id,
          'category' => $article->category->title,
          'title' => $article->title,
          'content' => $article->content,
          'commentsAmount' => Comment::select()->where('article_id', '=', $article->id)->count(),
        ]);
      }

      return view('forum.manage.create-category', [
        'articleData' => $articleData,
        'groupId' => $groupId,
      ]);
    }
  }

  public function showEditGroup(Request $request, $groupId)
  {
    if ($request->user()->id != 1) {
      return redirect()->route('browse');
    } else {
      $group = Group::select()->where('id', '=', $groupId)->first();
      $categories = Category::select('id', 'title', 'description', 'group_id', 'description')->get();
      $groupCategories = $categories->where('group_id', '=', $groupId);
      $categoryData = [];
      foreach ($categories as $category) {
        $articlesInCategory = Article::select('id', 'title')->where('category_id', $category->id);
        $commentsInCategory = Comment::select('id')->whereIn('article_id', $articlesInCategory->pluck('id'))->count();
        $categoryData[] = ([
          'id' => $category->id,
          'title' => $category->title,
          'description' => $category->description,
          'groupCategories' => $groupCategories,
          'categoryTitle' => $category->title,
          'articleAmount' => $articlesInCategory->count(),
          'commentAmount' => $commentsInCategory,
        ]);
      }

      return view('forum.manage.edit-group', [
        'groupId' => $group->id,
        'groupTitle' => $group->title,
        'categoryData' => $categoryData,
        'groupCategories' => $groupCategories,
      ]);
    }
  }

  public function showEditCategory(Request $request, $categoryId)
  {
    if ($request->user()->id != auth()->id()) {
      return redirect()->route('browse');
    } else {
      $categoryData = Category::select('title', 'description')->where('id', '=', $categoryId)->first();
      $articles = Article::select('id', 'category_id', 'title', 'content')->get();
      $categoryArticles = $articles->where('category_id', '=', $categoryId);
      $articleData = [];
      foreach ($articles as $article) {
        $articleData[] = ([
          'id' => $article->id,
          'category' => $article->category->title,
          'title' => $article->title,
          'content' => $article->content,
          'commentsAmount' => Comment::select()->where('article_id', '=', $article->id)->count(),
        ]);
      }
      return view('forum.manage.edit-category', [
        'articleData' => $articleData,
        'categoryId' => $categoryId,
        'categoryData' => $categoryData,
        'categoryArticles' => $categoryArticles,
      ]);
    }
  }
  // Store
  // **********************
  public function storeGroup(Request $request)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }

    $fields = [
      'title' => strip_tags(clean($request->title)),
    ];

    $validator = Validator::make($fields, [
      'title' => ['required', 'max:128'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      $groupId = Group::insertGetId([
        'title' => $fields['title'],
        'created_at' => $timeNow,
        'updated_at' => $timeNow,
      ]);
      $categoryIds = explode(',', $request->category_ids);
      if (!empty($categoryIds)) {
        foreach ($categoryIds as $categoryId) {
          $category = Category::all()->firstWhere('id', '=', $categoryId);
          if ($category == null) {
            break;
          }
          $category->group_id = $groupId;
          $category->save();
        }
      }
      return redirect(route('browse'))->with('message', 'Group Created!');
    } else {
      return redirect()->back()->withInput()->withErrors($validator);
    }
  }

  public function storeCategory(Request $request, $groupId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }

    $fields = [
      'title' => strip_tags(clean($request->title)),
      'description' => strip_tags(clean($request->description)),
    ];

    $slug = SlugService::createSlug(Category::class, 'slug', $request->title);
    $slugValidator = Validator::make([$slug], [
      'slug' => 'unique:categories'
    ]);
    if ($slugValidator->passes()) {
      $validator = Validator::make($fields, [
        'title' => ['required', 'max:128'],
      ], [
        'required' => 'The :attribute field can not be blank!',
      ]);

      if ($validator->passes()) {
        $timeNow = Carbon::now();
        $slug = SlugService::createSlug(Article::class, 'slug', $request->title);
        $categoryId = Category::insertGetId([
          'group_id' => $groupId,
          'title' => $fields['title'],
          'slug' => $slug,
          'description' => $fields['description'],
          'created_at' => $timeNow,
          'updated_at' => $timeNow,
        ]);
        $articleIds = explode(',', $request->article_ids);
        if (!empty($articleIds)) {
          foreach ($articleIds as $articleId) {
            $article = Article::all()->firstWhere('id', '=', $articleId);
            if ($article == null) {
              break;
            }
            $article->category_id = $categoryId;
            $article->save();
          }
        }
        return redirect(route('browse'))->with('message', 'Category Created!');
      } else {
        return redirect()->back()->withInput()->withErrors($validator);
      }
    }
  }

  public function updateGroup(Request $request, $groupId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }

    $fields = [
      'title' => strip_tags(clean($request->title)),
    ];

    $validator = Validator::make($fields, [
      'title' => ['required', 'max:128'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      Group::all()->firstWhere('id', '=', $groupId)->update([
        'title' => $fields['title'],
        'updated_at' => $timeNow,
      ]);
      $categoryIds = explode(',', $request->category_ids);
      if ($categoryIds != "" || $groupId == null) {
        foreach ($categoryIds as $categoryId) {
          $category = Category::all()->firstWhere('id', '=', $categoryId);
          if ($category == null) {
            break;
          }
          $category->group_id = $groupId;
          $category->save();
        }
      }
      return redirect(route('browse'))->with('message', 'Group Updated!');
    } else {
      return redirect()->back()->withInput()->withErrors($validator);
    }
  }

  public function updateCategory(Request $request, $categoryId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }

    $fields = [
      'title' => strip_tags(clean($request->title)),
      'description' => strip_tags(clean($request->description)),
    ];

    $validator = Validator::make($fields, [
      'title' => ['required', 'max:128'],
      'description' => ['required', 'max:1024'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      Category::all()->firstWhere('id', '=', $categoryId)->update([
        'title' => $fields['title'],
        'description' => $fields['description'],
        'updated_at' => $timeNow,
      ]);
      $articleIds = explode(',', $request->article_ids);
      if (!empty($articleIds)) {
        foreach ($articleIds as $articleId) {
          $article = Article::firstWhere('id', '=', $articleId);
          if ($article == null) {
            break;
          }
          $article->category_id = $categoryId;
          $article->save();
        }
      }
      return redirect(route('browse'))->with('message', 'Category Updated!');
    } else {
      return redirect()->back()->withInput()->withErrors($validator);
    }
  }

  public function deleteGroup(Request $request, $groupId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }
    Group::all()->firstWhere('id', '==', $groupId)->delete();
    return redirect()->back()->with('message', 'Group Deleted!');
  }

  public function deleteCategory(Request $request, $categoryId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }
    Category::firstWhere('id', '=', $categoryId)->delete();
    return redirect()->back()->with('message', 'Category Deleted!');
  }

  public function deleteArticle(Request $request, $articleId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }
    Article::firstWhere('id', '=', $articleId)->delete();
    return redirect()->back()->with('message', 'Article Deleted!');
  }
}

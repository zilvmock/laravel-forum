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
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

class ForumController extends Controller
{
  // View
  // **********************
  public function showCreateGroup(Request $request)
  {
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $categories = Category::all();
      $articles = Article::all();
      $comments = Comment::all();
      return view('forum.manage.create-group', [
        'categories' => $categories,
        'articles' => $articles,
        'comments' => $comments,
      ]);
    }
  }

  public function showCreateCategory(Request $request, $groupId)
  {
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $articles = Article::all();
      $comments = Comment::all();
      return view('forum.manage.create-category', [
        'articles' => $articles,
        'comments' => $comments,
        'groupId' => $groupId,
      ]);
    }
  }

  public function showEditGroup(Request $request, $groupId)
  {
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $group = Group::all()->firstWhere('id', '=', $groupId);
      $categories = Category::all();
      $groupCategories = Category::all()->where('group_id', '=', $groupId);
      $articles = Article::all();
      $comments = Comment::all();
      return view('forum.manage.edit-group', [
        'group' => $group,
        'categories' => $categories,
        'groupCategories' => $groupCategories,
        'articles' => $articles,
        'comments' => $comments,
      ]);
    }
  }

  public function showEditCategory(Request $request, $categoryId)
  {
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $category = Category::firstWhere('id', '=', $categoryId);
      $categoryArticles = Article::all()->where('category_id', '=', $categoryId);
      $articles = Article::all();
      $comments = Comment::all();
      return view('forum.manage.edit-category', [
        'category' => $category,
        'categoryArticles' => $categoryArticles,
        'articles' => $articles,
        'comments' => $comments,
      ]);
    }
  }
  // Store
  // **********************
  public function storeGroup(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'title' => ['required', 'max:100'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      $groupId = Group::insertGetId([
        'title' => $request->title,
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
    $slug = SlugService::createSlug(Category::class, 'slug', $request->title);
    $slugValidator = Validator::make([$slug], [
      'slug' => 'unique:categories'
    ]);
    if ($slugValidator->passes()) {
      $validator = Validator::make($request->all(), [
        'title' => ['required', 'max:100'],
      ], [
        'required' => 'The :attribute field can not be blank!',
      ]);

      if ($validator->passes()) {
        $timeNow = Carbon::now();
        $slug = SlugService::createSlug(Article::class, 'slug', $request->title);
        $categoryId = Category::insertGetId([
          'group_id' => $groupId,
          'title' => $request->title,
          'slug' => $slug,
          'description' => $request->description,
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
    $validator = Validator::make($request->all(), [
      'title' => ['required', 'max:100'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      Group::all()->firstWhere('id', '=', $groupId)->update([
        'title' => $request->title,
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
    $validator = Validator::make($request->all(), [
      'title' => ['required', 'max:100'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      Category::all()->firstWhere('id', '=', $categoryId)->update([
        'title' => $request->title,
        'description' => $request->description,
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

  public function deleteGroup($groupId)
  {
    Group::all()->firstWhere('id', '==', $groupId)->delete();
    return redirect()->back()->with('message', 'Group Deleted!');
  }

  public function deleteCategory($categoryId)
  {
    Category::firstWhere('id', '=', $categoryId)->delete();
    return redirect()->back()->with('message', 'Category Deleted!');
  }

  public function deleteArticle($articleId)
  {
    Article::firstWhere('id', '=', $articleId)->delete();
    return redirect()->back()->with('message', 'Article Deleted!');
  }

  public function deleteComment($commentId)
  {
    Comment::firstWhere('id', '=', $commentId)->delete();
    return redirect()->back()->with('message', 'Article Deleted!');
  }
}

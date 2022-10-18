<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('home');
})->name('home');
// *********************
// Store
// *********************
// Profile
Route::put('/dashboard/edit-profile/store', [ProfileController::class, 'updateProfile'])
  ->middleware(['auth'])->name('update-profile');
Route::post('/like-article/{id}', [BrowseController::class, 'likeArticle'])
  ->middleware(['auth'])->name('likeArticle');
// Comments
Route::put('/post-comment/{id}', [CommentController::class, 'storeComment'])
  ->middleware(['auth'])->name('store-comment');
Route::delete('/delete-comment/{id}', [CommentController::class, 'deleteComment'])
  ->middleware(['auth'])->name('delete-comment');
Route::put('/edit-comment/{comment:id}{article:id}', [CommentController::class, 'editComment'])
  ->middleware(['auth'])->name('edit-comment');
Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth']], function () {
  Lfm::routes();
});
// Articles
Route::put('/store-article', [ArticleController::class, 'storeArticle'])
  ->middleware(['auth'])->name('store-article');
Route::put('/edit-article/{id}/store', [ArticleController::class, 'updateArticle'])
  ->middleware(['auth'])->name('update-article');
Route::delete('/delete-article/{id}', [ArticleController::class, 'deleteArticle'])
  ->middleware(['auth'])->name('delete-article');
// Manage (admin)
Route::put('forum/manage/create-group/store', [ForumController::class, 'storeGroup'])
  ->middleware(['auth'])->name('store_group');
Route::put('forum/manage/update-group/{id}', [ForumController::class, 'updateGroup'])
  ->middleware(['auth'])->name('update_group');
Route::delete('forum/manage/delete-group/{id}', [ForumController::class, 'deleteGroup'])
  ->middleware(['auth'])->name('delete_group');
Route::put('forum/manage/create-category/store/{id}', [ForumController::class, 'storeCategory'])
  ->middleware(['auth'])->name('store_category');
Route::put('forum/manage/update-category/{id}', [ForumController::class, 'updateCategory'])
  ->middleware(['auth'])->name('update_category');
Route::delete('forum/manage/delete-category/{id}', [ForumController::class, 'deleteCategory'])
  ->middleware(['auth'])->name('delete_category');
Route::delete('forum/manage/delete-article/{id}', [ForumController::class, 'deleteArticle'])
  ->middleware(['auth'])->name('delete_article');
Route::delete('forum/manage/delete-comment/{id}', [ForumController::class, 'deleteComment'])
  ->middleware(['auth'])->name('delete_comment');
// *********************
// Return Views
// *********************
// Profile
Route::get('/dashboard/profile', [ProfileController::class, 'showProfileView'])
  ->middleware(['auth'])->name('profile');
Route::get('/dashboard/edit-profile', [ProfileController::class, 'showEditProfileView'])
  ->middleware(['auth'])->name('edit-profile');
// Browse
Route::get('forum/browse', [BrowseController::class, 'showBrowseView'])
  ->middleware(['auth'])->name('browse');
Route::get('forum/browse/{category:slug}', [BrowseController::class, 'showCategoryView'])
  ->middleware(['auth'])->name('browse-category');
Route::get('forum/browse/{category:slug}/{article:slug}/{id}', [BrowseController::class, 'showArticleView'])
  ->middleware(['auth'])->name('view-article');
Route::get('forum/create-article', [ArticleController::class, 'showCreateArticle'])
  ->middleware(['auth'])->name('create-article');
Route::get('forum/edit-article/{id}', [ArticleController::class, 'showEditArticle'])
  ->middleware(['auth'])->name('edit-article');
// Manage (admin)
Route::get('forum/manage/create-group', [ForumController::class, 'showCreateGroup'])
  ->middleware(['auth'])->name('create_group');
Route::get('forum/manage/edit-group/{id}', [ForumController::class, 'showEditGroup'])
  ->middleware(['auth'])->name('edit_group');
Route::get('forum/manage/create-category/{id}', [ForumController::class, 'showCreateCategory'])
  ->middleware(['auth'])->name('create_category');
Route::get('forum/manage/edit-category/{id}', [ForumController::class, 'showEditCategory'])
  ->middleware(['auth'])->name('edit_category');
// *********************

require __DIR__ . '/auth.php';

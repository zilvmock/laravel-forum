<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Store
// *********************
Route::put('/dashboard/edit-profile/store', [ProfileController::class, 'updateProfile'])
    ->middleware(['auth'])->name('update-profile');

// Return Views
// *********************
Route::get('/dashboard/profile', [ProfileController::class, 'showProfileView'])
    ->middleware(['auth'])->name('profile');

Route::get('/dashboard/edit-profile', [ProfileController::class, 'showEditProfileView'])
    ->middleware(['auth'])->name('edit-profile');
// *********************

//Route::get('/trix', 'TrixController@index');
//Route::post('/upload', 'TrixController@upload');
//Route::post('/store', 'TrixController@store');

require __DIR__.'/auth.php';

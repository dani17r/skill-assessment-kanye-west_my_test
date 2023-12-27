<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::get('/', [Controller::class, 'view'])->name('main');


Route::middleware('auth')->group(function () {
  
  Route::middleware('is_admin')->group(function () {
    Route::post('/user/profile/update-by-admin', [ProfileController::class, 'update_by_admin']);
    Route::get('/user/profile/all', [ProfileController::class, 'view_all'])->name('users');
    Route::get('/user/all', [ProfileController::class, 'getAll']);
  });

  /** ---------DASHBOARD--------- */
  Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');

  /** ---------PROFILE--------- */
  Route::get('user/profile', [ProfileController::class, 'view'])->name('profile');
  Route::post('/user/profile/change-password', [ProfileController::class, 'changePassword']);
  Route::post('/user/profile/update', [ProfileController::class, 'update']);
  Route::get('/user/profile/show', [ProfileController::class, 'show']);

  /** ---------QUOTE--------- */
  Route::get('/quotes', [QuoteController::class, 'index']);

  Route::middleware('is_banning')->group(function () {
    /** ---------FAVORITE--------- */
    Route::post('/favorite/delete', [FavoriteController::class, 'destroy']);
    Route::get('/favorite', [FavoriteController::class, 'view'])->name('favorite');
    Route::post('/favorite', [FavoriteController::class, 'updateOrCreate']);
    Route::get('/favorite/all', [FavoriteController::class, 'getAll']);
  });

});

/** ---------AUTH--------- */
require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::get('/', [Controller::class, 'index']);

/** ---------PROFILE--------- */
Route::get('user/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/user/profile/change-password', [ProfileController::class, 'changePassword']);
Route::post('/user/profile/update', [ProfileController::class, 'update']);
Route::get('/user/profile/show', [ProfileController::class, 'show']);

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
Route::post('/favorite', [FavoriteController::class, 'updateOrCreate']);

/** ---------AUTH--------- */
require __DIR__.'/auth.php';

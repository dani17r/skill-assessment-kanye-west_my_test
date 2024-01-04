<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@view')->name('main');

Route::middleware('auth')->group(function () {
  
  /** ---------DASHBOARD--------- */
  Route::get('/dashboard', 'MainController@view_dashboard')->name('dashboard');
  
  /** ---------PROFILE--------- */
  Route::get('/user/profile/all', 'ProfileController@view_all')->name('users');
  Route::get('/user/profile', 'ProfileController@view')->name('profile');

  /** ---------FAVORITE--------- */
  Route::get('/favorite', 'FavoriteController@view')->name('favorite');
});

/** ---------AUTH--------- */
require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->group(function () {
    
    /** ---------PROFILE--------- */
    Route::post('/user/profile/update-by-admin', 'ProfileController@update_by_admin');
    Route::post('/user/profile/change-password', 'ProfileController@changePassword');
    Route::post('/user/profile/update', 'ProfileController@update');
    Route::get('/user/profile/all', 'ProfileController@getAll');
    Route::get('/user/profile/show', 'ProfileController@show');
    
    /** ---------FAVORITE--------- */
    Route::post('/favorite/delete', 'FavoriteController@destroy');
    Route::post('/favorite', 'FavoriteController@updateOrCreate');
    Route::get('/favorite/all', 'FavoriteController@getAll');

    /** ---------QUOTE--------- */
    Route::get('/quotes', 'QuoteController@index');
});
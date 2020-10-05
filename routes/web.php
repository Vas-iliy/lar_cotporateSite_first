<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'IndexController@index')->name('home');

Route::resource('portfolios', 'PortfolioController')->parameters([
    'portfolios' => 'alias'
])->only(['index', 'show']);

Route::resource('articles', 'ArticlesController')->parameters([
    'articles' => 'alias'
])->only(['index', 'show']);

Route::get('articles/cat/{cat_alias?}', 'ArticlesController@index')
    ->name('articlesCat')
    ->where('cat_alias', '[\w-]+');

Route::resource('comments', 'CommentsController');

Route::get('/contacts', 'ContactsController@index')->name('contacts');
Route::post('/contacts', 'ContactsController@input');

//Auth
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', 'Admin\IndexController@index')->name('adminIndex');

    Route::resource('/articles', 'Admin\ArticlesController');
});


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

Route::resource('/', 'IndexController')->only(['index'])->names(['index' => 'home']);

Route::resource('portfolios', 'PortfolioController')->parameters([
    'portfolios' => 'alias'
]);

Route::resource('articles', 'ArticlesController')->parameters([
    'articles' => 'alias'
])->only(['index', 'show']);

Route::get('articles/cat/{cat_alias?}', 'ArticlesController@index')
    ->name('articlesCat')
    ->where('cat_alias', '[\w-]+');

Route::resource('comments', 'CommentsController');

Auth::routes();


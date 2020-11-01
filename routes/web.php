<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/books/{slug}', 'BooksController@show')->name('books.show');
Route::resource('books', 'BooksController',['except' => ['create','show','edit']]);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/saveExpressions','HomeController@ajaxSaveExpressions');

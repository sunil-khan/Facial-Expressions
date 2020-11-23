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

Route::group(['middleware' => ['auth:web']],function() {
    Route::get('/home', 'BooksController@index')->name('home');
    Route::get('/books/{slug}', 'BooksController@show')->name('books.show');
    Route::resource('books', 'BooksController', ['except' => ['create', 'show', 'edit']]);
});

Route::get('/books/reading/iframe', 'BooksController@iFrameBookReading')->name('books.reading.iframe');

Route::get('/admin/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
Route::post('/admin/dashboard/filter-graph-data-ajax', 'Admin\DashboardController@getFilterGraphAjax')->name('admin.filter-graph-data-ajax');
Route::post('/admin/dashboard/get-book-pages-ajax', 'Admin\DashboardController@getBookPagesAjax')->name('admin.get-book-pages-ajax');

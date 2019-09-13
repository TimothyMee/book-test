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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/create-books', 'BookController@index')->name('create-book');
Route::post('/books/create', 'BookController@create');
Route::get('/books', 'BookController@getAll');
Route::delete('/books/{i}', 'BookController@delete');

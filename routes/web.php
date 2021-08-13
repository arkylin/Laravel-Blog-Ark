<?php

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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/page/{page}.html', 'StaticPagesController@page')->name('home.page');

Route::get('/admin', 'AdminController@admin')->name('admin_home');
Route::get('/admin/edit', 'AdminController@edit')->name('admin_edit');
Route::post('/admin/edit', 'AdminController@edit')->name('admin_edit_post');
Route::post('/admin/upload', 'AdminController@upload')->name('admin_upload');

Route::get('/posts/{post}.html', 'PostsController@show')->name('post_slug');
Route::get('/posts/api/id/{post}', 'PostsController@show')->name('post_api');

Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login_post');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

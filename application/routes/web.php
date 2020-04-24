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

/**
 * フロントサイド
 */
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * 管理サイド
 */
Route::prefix('admin')->namespace('Admin')->as('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login');
    });
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::get('home', 'HomeController@index')->name('home');

        Route::get('admin_users/create', 'AdminUserController@create')->name('admin_users_create');
        Route::post('admin_users', 'AdminUserController@store')->name('admin_users_store');

        Route::get('admin_users/{admin_user}/edit', 'AdminUserController@edit')->name('admin_users_edit');
        Route::put('admin_users/edit/{admin_user}', 'AdminUserController@update')->name('admin_users_update');

        Route::get('admin_users', 'AdminUserController@index')->name('admin_users_index');
        Route::get('admin_users/{admin_user}', 'AdminUserController@show')->name('admin_users_show');

        Route::delete('admin_users/{admin_user}', 'AdminUserController@destroy')->name('admin_users_destroy');
    });
});

/**
 * リダイレクト
 */
Route::redirect('/', '/home');
Route::redirect('/admin', '/admin/home');

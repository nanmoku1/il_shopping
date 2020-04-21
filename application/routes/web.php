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
        Route::get('admin_users', 'AdminUsersController@index')->name('admin_users_list');
        Route::get('admin_users/create', 'AdminUsersController@create_page')->name('admin_users_create_page');
        Route::get('admin_users/{id}/edit', 'AdminUsersController@edit_page')->name('admin_users_edit_page');
        Route::get('admin_users/{id}', 'AdminUsersController@detail')->name('admin_users_detail');
        Route::post('admin_users', 'AdminUsersController@create')->name('admin_users_create');
        Route::delete('admin_users/{id}', 'AdminUsersController@delete')->name('admin_users_delete');
        Route::put('admin_users/edit/{id}', 'AdminUsersController@edit')->name('admin_users_edit');;
    });
});

/**
 * リダイレクト
 */
Route::redirect('/', '/home');
Route::redirect('/admin', '/admin/home');

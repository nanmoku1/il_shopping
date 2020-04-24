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
        //オーナー権限ユーザーのみ利用可
        Route::middleware('can:manager-admin-only')->group(function () {
            Route::get('admin_users', 'AdminUserController@index')->name('admin_users_list');
            Route::get('admin_users/create', 'AdminUserController@createPage')->name('admin_users_create_page');
            Route::post('admin_users', 'AdminUserController@create')->name('admin_users_create');
        });
        //オーナー権限ユーザーかログインユーザー本人でなければ利用不可
        Route::middleware('can:manager-admin-or-me,adminUser')->group(function () {
            Route::get('admin_users/{adminUser}', 'AdminUserController@detail')->name('admin_users_detail');
            Route::get('admin_users/{adminUser}/edit', 'AdminUserController@editPage')->name('admin_users_edit_page');
            Route::put('admin_users/edit/{adminUser}', 'AdminUserController@edit')->name('admin_users_edit');;
        });
        //オーナー権限ユーザーで、ログイン中のユーザー以外のユーザーのみ利用可
        Route::middleware('can:manager-admin-and-not-me,adminUser')->group(function () {
            Route::delete('admin_users/{adminUser}', 'AdminUserController@delete')->name('admin_users_delete');
        });
    });
});

/**
 * リダイレクト
 */
Route::redirect('/', '/home');
Route::redirect('/admin', '/admin/home');

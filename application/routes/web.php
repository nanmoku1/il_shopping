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
Route::resource('products', 'ProductController')->only([
    'index',
    'show',
]);

Route::middleware('auth:user')->group(function () {
    Route::resource('users', 'UserController')->only([
        'edit',
        'update',
    ]);

    Route::post('/wish_products/{product}', 'WishProductController@store');
    Route::delete('/wish_products/{product}', 'WishProductController@destroy');

    Route::get('/products/{product}/product_reviews/create', 'ProductReviewController@create')->name('product_reviews.create');
    Route::post('/products/{product}/product_reviews', 'ProductReviewController@store')->name('product_reviews.store');
    Route::get('/products/{product}/product_reviews/{product_review}/edit', 'ProductReviewController@edit')->name('product_reviews.edit');
    Route::put('/products/{product}/product_reviews/{product_review}', 'ProductReviewController@update')->name('product_reviews.update');
});

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
        Route::resource('users', 'UserController');
        Route::resource('products', 'ProductController');
        Route::resource('product_categories', 'ProductCategoryController');
        Route::resource('admin_users', 'AdminUserController');
    });
});

/**
 * リダイレクト
 */
Route::redirect('/', '/home');
Route::redirect('/admin', '/admin/home');

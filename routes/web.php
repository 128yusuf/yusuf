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


Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/', function () {
    return view('auth.login');
});
Route::group(['middleware' => ['auth'] ], function(){

    Route::group(['middleware' => ['shop_role'], 'prefix' => 'shop', 'namespace' => 'Shop' ], function(){
        Route::get('/products', 'ProductController@index')->name('products');

        Route::group(['prefix' => 'products'], function(){
            Route::get('/ajax', 'ProductController@ajax')->name('product.ajax');
            Route::post('/delete', 'ProductController@delete')->name('product.delete');
            Route::get('/add', 'ProductController@add')->name('product.add');
            Route::post('/store', 'ProductController@store')->name('product.store');
            Route::get('/edit/{id}', 'ProductController@edit')->name('product.edit');
            Route::post('/update/{id}', 'ProductController@update')->name('product.update');
        });
    });

    Route::group(['middleware' => ['user_lang','user_role'], 'namespace' => 'User' ], function(){

            Route::get('/', 'ProductController@index')->name('user.product');

            Route::group(['prefix' => 'product'], function(){
                Route::post('/add-to-cart', 'ProductController@addToCart')->name('user.addtocart');
                Route::post('/checkout', 'ProductController@checkOut')->name('user.product.checkout');
                Route::get('{id}/detail', 'ProductController@detail')->name('user.product.detail');
                Route::get('/cart', 'ProductController@cart')->name('user.product.cart');
                Route::post('/user-product-remove', 'ProductController@removeFromCart')->name('user.product.remove');
            });
    });

});



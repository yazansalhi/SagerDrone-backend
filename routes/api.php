<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    //Auth
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
    //

Route::group(['middleware' => 'auth:api'], function () {

    //products 
	Route::get('/products', 'ProductController@index');
    Route::post('/products', 'ProductController@create');
    Route::put('/products/{id}', 'ProductController@edit');
    Route::delete('/products/{id}', 'ProductController@destroy');
    Route::post('/products/remove-quantity', 'ProductController@removeQuantity');
    //

    //categories
    Route::get('/categories', 'CategoryController@index');
    Route::post('/categories', 'CategoryController@create');
    Route::put('/categories/{id}', 'CategoryController@edit');
    Route::delete('/categories/{id}', 'CategoryController@destroy');
    //

    //users
    Route::get('/users', 'UserController@index');
    Route::post('/users', 'UserController@create');
    Route::put('/users/{id}', 'UserController@edit');
    Route::delete('/users/{id}', 'UserController@destroy');
    //

});
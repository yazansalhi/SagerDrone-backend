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
Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

Route::group(['middleware' => 'auth:api'], function () {
	Route::get('/products', 'ProductsController@index');
    Route::post('/products', 'ProductsController@create');
    Route::put('/products/{id}', 'ProductsController@edit');
    Route::delete('/products/{id}', 'ProductsController@destroy');

    Route::post('/products/remove-quantity', 'ProductsController@removeQuantity');
});
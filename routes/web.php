<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Frontend'], function () {
    Route::view('/',                    'layouts.frontend_app');
    Route::get('global-data',           'LibController@index');
    Route::get('get-menus',             'HomeController@menus');
    Route::get('get-home-page',         'HomeController@homePage');
});

// USER LOGIN
Route::get('login',         'Auth\LoginController@showLoginForm')->name('login');
Route::get('login-check',   'Auth\LoginController@loginCheck');

// USER DASHBOARD
Route::group(['namespace' => 'Frontend', 'prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::view('dashboard',       'layouts.frontend_app');
    Route::view('profile',         'layouts.frontend_app');
});



/**-------------------------------------------------
 ** PAYMENT WITH SSL
 ** ---------------------------------------------**/
Route::namespace('BankApi')->group(function () {
    Route::get('/ssl-payment/{id}',         'SslCommerzPaymentController@index');
    Route::post('/success-from-ssl',        'SslCommerzPaymentController@success');
    Route::post('/failed-from-ssl',         'SslCommerzPaymentController@fail');
    Route::post('/cancel-from-ssl',         'SslCommerzPaymentController@cancel');
    Route::post('/ipn',                     'SslCommerzPaymentController@ipn');
});
Route::view('/ssl-payment-success',         'layouts.frontend_app');
Route::view('/ssl-payment-cancel',          'layouts.frontend_app');
Route::view('/ssl-payment-failed',          'layouts.frontend_app');


// AUTH VERIFY FALSE
Auth::routes(['verify' => false]);

// FOR STORAGE LINKED IN PUBLIC FOLDER
Route::get('/sym', function () {
    File::link(storage_path('app/public'), public_path('storage'));
    return response()->json("Link Create Successfully!");
});

// CACHE CLEAR
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return response()->json("Cache Cleared Successfully!");
});

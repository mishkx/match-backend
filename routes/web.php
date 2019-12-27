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

Auth::routes();

Route::group(['prefix' => 'oauth', 'as' => 'oauth.', 'middleware' => ['guest', 'throttle']], function () {
    Route::get('/{provider}', 'Auth\SocialiteController@redirectToProvider')
        ->name('login')->where('provider', config('options.oauth.services'));
    Route::get('/{provider}/callback', 'Auth\SocialiteController@handleProviderCallback')
        ->name('callback')->where('provider', config('options.oauth.services'));
});

Route::group(['middleware' => ['auth', 'throttle']], function () {
    Route::get('password/save', 'Auth\SavePasswordController@showForm')->name('password.save');
    Route::post('password/save', 'Auth\SavePasswordController@savePassword');
});

Route::group(['middleware' => ['auth', 'user.password.missed', 'throttle']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::group(['prefix' => 'api/v1', 'as' => 'api.v1.'], function () {
    Route::group(['prefix' => 'docs', 'as' => 'docs.'], function () {
        Route::get('redoc', 'DocsController@redoc')->name('redoc');
        Route::get('swagger', 'DocsController@swagger')->name('swagger');
    });
});

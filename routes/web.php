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

Route::get('login/as/{id}', 'Auth\LoginAsController@loginAs')
    ->name('login.as');

Route::group(['prefix' => 'oauth', 'as' => 'oauth.', 'middleware' => ['guest', 'throttle']], function () {
    Route::get('{provider}', 'Auth\SocialiteController@redirectToProvider')
        ->name('login')
        ->where('provider', config('options.oauth.services'));
    Route::get('{provider}/callback', 'Auth\SocialiteController@handleProviderCallback')
        ->name('callback')
        ->where('provider', config('options.oauth.services'));
});

Route::group(['middleware' => ['auth', 'throttle']], function () {
    Route::get('password/save', 'Auth\SavePasswordController@showForm')
        ->name('password.save');
    Route::post('password/save', 'Auth\SavePasswordController@savePassword');
});

Route::group(['prefix' => 'api/v1', 'as' => 'api.v1.'], function () {
    Route::group(['prefix' => 'docs', 'as' => 'docs.'], function () {
        Route::get('redoc', 'DocsController@redoc')
            ->name('redoc');
        Route::get('swagger', 'DocsController@swagger')
            ->name('swagger');
    });

    Route::get('user', 'User\UserController@data')
        ->name('user.data');
    Route::put('user', 'User\UserController@update')
        ->name('user.update');
    Route::post('user/photo', 'User\UserPhotoController@add')
        ->name('user.photo.add');
    Route::delete('user/photo', 'User\UserPhotoController@delete')
        ->name('user.photo.delete');

    Route::get('recommendations', 'User\RecommendationController@collection')
        ->name('recommendations.collection');

    Route::post('choice/{id}/like', 'User\ChoiceController@like')
        ->name('choice.like');
    Route::post('choice/{id}/dislike', 'User\ChoiceController@dislike')
        ->name('choice.dislike');

    Route::get('matches', 'User\MatchController@collection')
        ->name('matches.collection');
    Route::get('matches/{id}', 'User\MatchController@single')
        ->name('matches.single');
    Route::delete('matches/{id}', 'User\MatchController@delete')
        ->name('matches.delete');

    Route::get('chats', 'User\ChatController@collection')
        ->name('chats.collection');
    Route::get('chats/{id}', 'User\ChatController@single')
        ->name('chats.single');
    Route::post('chats/{id}/message', 'User\ChatController@sendMessage')
        ->name('chats.message.send');

    Route::get('app/config', 'AppController@config')
        ->name('app.config');
});

Route::group(['middleware' => ['auth', 'user.password.missed', 'throttle']], function () {
    Route::get('{all}', 'AppController@root')
        ->name('root')
        ->where('all', '^(?!(_debugbar|test)).*$');
});

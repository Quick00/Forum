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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::delete('user/{id}', 'UserController@destroy');

Route::delete('topic/{id}', 'TopicController@destroy');

Route::post('login', 'UserController@login');

Route::post('register' , 'UserController@register');

Route::post('getuser', 'UserController@getuser');

Route::get('user', 'UserController@index');

Route::get('showtopic', 'TopicController@show');

Route::post('topics' , 'TopicController@index');

Route::post('maketopic', 'TopicController@store');

Route::post('topic' , 'TopicController@disscusion');

Route::get('threads' , 'ThreadsController@index');

Route::post('threads' , 'ThreadsController@store');

Route::post('comment', 'CommentController@store');

Route::post('getcomment' , 'CommentController@index');

Route::delete('deletecomment/{id}' , 'CommentController@destroy');
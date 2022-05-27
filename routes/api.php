<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return $request->user();

});


Route::post('/register',"Auth\AuthController@register" );
Route::post('/login',"Auth\AuthController@login" );


Route::middleware(['auth:sanctum'])->group(function () {
	// Post 
	Route::post('/post/create', 'PostController@create');
	Route::post('/post/delete',"PostController@destory");
	Route::post('/post/edit',"PostController@edit");
	Route::post('/post/date/{id}', "PostController@date");
	Route::post('/post/user/{id}',"PostController@userData");
	Route::post('/post/{id}', "PostController@PostAll");
	Route::post('/post/iflike/{id}/{user_id}', "PostController@ifLike");
	Route::post('/post/like/{id}/{user_id}', "PostController@Like");
	Route::post('/post/unlike/{id}/{user_id}', "PostController@UnLike");

	// Comment 
	Route::post('/comment/create', "CommentsController@create");
	Route::post('/comment/{id}', "CommentsController@show");

	// Profile Details 
	Route::post('/detail-add',"DetailsController@create" );
	Route::post('/details/edit',"DetailsController@edit" );
	Route::post('/details',"DetailsController@show" );

});

Route::post('image-upload', function() {
    //
});
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

// Auth 
Route::post('/register',"Auth\AuthController@register" );
Route::post('/login',"Auth\AuthController@login" );


Route::middleware(['auth:sanctum'])->group(function () {
	// Post 
	
	Route::group(['prefix' => 'post'], function() {
		Route::post('/create', 'PostController@create');
		Route::post('/update', 'PostController@update');
		Route::post('/save', 'PostController@SavePost');
		Route::post('/save/{id}', 'PostController@SavePosts');
		Route::post('/unsave', 'PostController@UnSavePost');
		Route::post('/ifsave', 'PostController@IfSavePost');
		Route::post('/{id}/delete',"PostController@destroy");
		Route::post('/edit',"PostController@edit");
		Route::post('/date/{id}', "PostController@date");
		Route::post('/user/{id}',"PostController@userData");
		Route::post('/{id}', "PostController@PostAll");
		Route::post('/iflike/{id}/{user_id}', "PostController@ifLike");
		Route::post('/like/{id}/{user_id}', "PostController@Like");
		Route::post('/unlike/{id}/{user_id}', "PostController@UnLike");
		Route::post('/like/{id}', "PostController@whoLikedThePost");
	});
	

	// Comment 
	
	Route::group(['prefix' => 'comment'], function() {
		Route::post('/create', "CommentsController@create");
		Route::post('/{id}', "CommentsController@show");
		Route::post('/date/{id}',"CommentsController@Date");
		Route::post('/user/{id}',"CommentsController@UserData");
		Route::post('/edit/{id}',"CommentsController@Edit");
		Route::post('/delete/{id}',"CommentsController@destroy");
		Route::post('/save/{id}','CommentsController@SaveComment');
		Route::post('/saves/{id}','CommentsController@SaveComments');
		Route::post('/unsave/{id}','CommentsController@UnSaveComment');
		Route::post('/ifsave/{id}','CommentsController@IfSaveComment');
	});
	
	

	// Profile Details 
	Route::post('/detail-add',"DetailsController@create" );
	Route::post('/details/edit',"DetailsController@edit" );
	Route::post('/details',"DetailsController@show" );

	// Profile View 
	Route::post('/profile/{id}',"ProfileController@GetUser");
	Route::post('/user/posts',"PostController@FriPostAll");
	Route::post('/user/save',"ProfileController@SaveUser");
	Route::post('/user/unsave',"ProfileController@UnSaveUser");
	Route::post('/user/ifsave',"ProfileController@IfSaveUser");
	Route::post('/user/saves/{id}',"ProfileController@SaveUsers");
	Route::post('/user/name_update',"ProfileController@ChangeName");
	Route::post('/user/password_update',"ProfileController@ChangePassword");
	

	// Friends
	
	Route::group(['prefix' => 'friend'], function() {
		Route::post('/add',"FriendsController@AddTo");
		Route::post('/is-pendding',"FriendsController@isPendding");
		Route::post('/is-request',"FriendsController@ifRequest");
		Route::post('/get-fri-req',"FriendsController@getFriendRequests");
		Route::post('/get-fri-pending',"FriendsController@GetPendingFriendships");
		Route::post('/accept',"FriendsController@Accept");
		Route::post('/deny',"FriendsController@deny");
		Route::post('/block',"FriendsController@block");
		Route::post('/ifblock',"FriendsController@ifBlock");
		Route::post('/UnBlock',"FriendsController@unblock");
		Route::post('/unfriend',"FriendsController@Unfriend");
		Route::post('/all-friends',"FriendsController@AllFriends");
		Route::post('/get-friends-count',"FriendsController@GetFriendsCount");
		Route::post('/block-list',"FriendsController@BlockList");
		Route::post('/is-friend',"FriendsController@isFriendWith");
		Route::post('/matual-fri',"FriendsController@GetMutualFriends");
	});
	
	
	// New Feed 
	Route::post('new-feed',"NewFeedController@GetPost");
	

	// Messenger 
	Route::group(['prefix' => 'messenger'], function() {
		
		Route::post('send',"MessagesController@send");
		Route::post('get',"MessagesController@get");
		Route::post('delete',"MessagesController@delete");
		Route::post('friends',"MessagesController@Friends");
		
	});
	

});
  // For Image Uploader Actions 
Route::post('image-uploader', function() {
    //
});





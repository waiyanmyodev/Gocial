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
	Route::post('/post/create', 'PostController@create');
	Route::post('/post/update', 'PostController@update');
	Route::post('/post/save', 'PostController@SavePost');
	Route::post('/post/save/{id}', 'PostController@SavePosts');
	Route::post('/post/unsave', 'PostController@UnSavePost');
	Route::post('/post/ifsave', 'PostController@IfSavePost');
	Route::post('/post/{id}/delete',"PostController@destroy");
	Route::post('/post/edit',"PostController@edit");
	Route::post('/post/date/{id}', "PostController@date");
	Route::post('/post/user/{id}',"PostController@userData");
	Route::post('/post/{id}', "PostController@PostAll");
	Route::post('/post/iflike/{id}/{user_id}', "PostController@ifLike");
	Route::post('/post/like/{id}/{user_id}', "PostController@Like");
	Route::post('/post/unlike/{id}/{user_id}', "PostController@UnLike");
	Route::post('/post/like/{id}', "PostController@whoLikedThePost");

	// Comment 
	Route::post('/comment/create', "CommentsController@create");
	Route::post('/comment/{id}', "CommentsController@show");
	Route::post('/comment/date/{id}',"CommentsController@Date");
	Route::post('/comment/user/{id}',"CommentsController@UserData");
	Route::post('/comment/edit/{id}',"CommentsController@Edit");
	Route::post('/comment/delete/{id}',"CommentsController@destroy");
	Route::post('/comment/save/{id}','CommentsController@SaveComment');
	Route::post('/comment/saves/{id}','CommentsController@SaveComments');
	Route::post('/comment/unsave/{id}','CommentsController@UnSaveComment');
	Route::post('/comment/ifsave/{id}','CommentsController@IfSaveComment');


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
	Route::post('friend/add',"FriendsController@AddTo");
	Route::post('friend/is-pendding',"FriendsController@isPendding");
	Route::post('friend/is-request',"FriendsController@ifRequest");
	Route::post('friend/get-fri-req',"FriendsController@getFriendRequests");
	Route::post('friend/get-fri-pending',"FriendsController@GetPendingFriendships");
	Route::post('friend/accept',"FriendsController@Accept");
	Route::post('friend/deny',"FriendsController@deny");
	Route::post('friend/block',"FriendsController@block");
	Route::post('friend/ifblock',"FriendsController@ifBlock");
	Route::post('friend/UnBlock',"FriendsController@unblock");
	Route::post('friend/unfriend',"FriendsController@Unfriend");
	Route::post('friend/all-friends',"FriendsController@AllFriends");
	Route::post('friend/get-friends-count',"FriendsController@GetFriendsCount");
	Route::post('friend/block-list',"FriendsController@BlockList");
	Route::post('friend/is-friend',"FriendsController@isFriendWith");
	Route::post('friend/matual-fri',"FriendsController@GetMutualFriends");
	
	// New Feed 
	Route::post('new-feed',"NewFeedController@GetPost");


});
  // For Image Uploader Actions 
Route::post('image-uploader', function() {
    //
});


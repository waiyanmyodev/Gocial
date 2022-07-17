<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class FriendsController extends Controller
{
    public function AddTo(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->befriend($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }
    public function getFriendRequests(Request $request)
    {
        $user = User::find($request->user_id);
        if($user->getFriendRequests() == null){
            return json_encode(true);
        }else {
            return $user->getFriendRequests();
        }
    }

    public function Accept(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->acceptFriendRequest($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function Deny(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->denyFriendRequest($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function isPendding(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->hasFriendRequestFrom($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function ifRequest(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->hasSentFriendRequestTo($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function Block(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->blockFriend($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function UnBlock(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->unblockFriend($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function Unfriend(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->unfriend($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function AllFriends(Request $request)
    {
        $user = User::find($request->user_id);
        if($user->getAcceptedFriendships() == null){
            return json_encode(1);
        }else {
            return $user->getAcceptedFriendships();
        }
    }
    public function GetFriendsCount(Request $request)
    {
        $user = User::find($request->user_id);
        $list = array();
        $list['friends_count'] = count($user->getAcceptedFriendships());
        $list['pending_count'] = count($user->getPendingFriendships());
        $list['requests_count'] = count($user->getFriendRequests());
        return $list;

    }

    public function BlockList(Request $request)
    {
        $user = User::find($request->user_id);
        return $user->getBlockedFriendships();
    }

    public function isFriendWith(Request $request)
    {
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        if($user->isFriendWith($friend)){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function GetPendingFriendships(Request $request){
        $user = User::find($request->user_id);
        if($user->getPendingFriendships() != null){
            return $user->getPendingFriendships();
        }else {
            return json_encode(false);
        }
    }


    public function GetMutualFriends(Request $request){
        $user = User::find($request->user_id);
        $friend = User::find($request->friend_id);
        return $user->getMutualFriendsCount($friend);

    }

    
}

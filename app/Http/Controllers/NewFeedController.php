<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class NewFeedController extends Controller
{
    public function GetPost(Request $request) {
        $id = $request->user_id;
        $user = User::find($id);
        $friends = $user->getAcceptedFriendships();
        $pending_fri = $user->getPendingFriendships();
        $users_id = array();
        foreach ($friends as $item) {
           if($item['sender_id'] != $id){
              $users_id[] = $item['sender_id'];
           }
           if($item['recipient_id'] != $id) {
              $users_id[] = $item['recipient_id'];
           }
        }

        foreach ($pending_fri as $item) {
            if($item['sender_id'] != $id){
               $users_id[] = $item['sender_id'];
            }
            if($item['recipient_id'] != $id) {
               $users_id[] = $item['recipient_id'];
            }
         }

         $posts = array();
        foreach($users_id as $id){
            $post = Post::where('user_id',$id)->first();
            $posts[] = $post;
        }
        return $posts;
    }
}

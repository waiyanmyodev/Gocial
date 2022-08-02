<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;


class MessagesController extends Controller
{
    public function send(Request $req)
    {
        $msg = new Message;
        $msg->sender_id = Auth::id();
        $msg->receiver_id = $req->receiver_id;
        $msg->data = $req->data;
        $msg->type = $req->type;
        $user =  Auth::user();
        $data= array('data'=>$req->data,"sender_id"=>$req->sender_id);
        if($msg->save()){
            event(new MessageEvent($data,$user));
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    public function get(Request $req)
    {
        $receiver_id = $req->receiver_id;
        $conservation = Message::query()
                        ->where('sender_id',  Auth::id())
                        ->where('receiver_id',  $receiver_id)
                        ->orWhere('receiver_id',  Auth::id())
                        ->where('sender_id', $receiver_id)
                        ->with('sender')
                        ->with('receiver')
                        ->get();
        return json_encode($conservation);
    }

    public function Friends()
    {
        $user = User::find(Auth::id());
        if($user->getAcceptedFriendships()){
            $id = Auth::id();
            $friends = $user->getAcceptedFriendships();
            $users_id = array();
            foreach ($friends as $item) {
            if($item['sender_id'] != $id){
                $users_id[] = $item['sender_id'];
            }
            if($item['recipient_id'] != $id) {
                $users_id[] = $item['recipient_id'];
            }
            }


            $tmp = array();
            foreach($users_id as $id){
                $receiver_id = $id;
                $user = User::find($id);
                $conservation = Message::query()
                        ->where('sender_id',  Auth::id())
                        ->where('receiver_id',  $receiver_id)
                        ->orWhere('receiver_id',  Auth::id())
                        ->where('sender_id', $receiver_id)
                        ->with('sender')
                        ->with('receiver')
                        ->latest()->first();
                if($conservation != null){
                    $user['created_at'] = $conservation['created_at'];
                }else {

                }
                $user['message'] = $conservation;
                $tmp[] = $user;
            }
            return json_encode($tmp);
        }
    }
}

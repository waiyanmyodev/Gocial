<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use DateTime;

class PostController extends Controller
{

    public function index($id)
    {
    }


    public function create(Request $request)
    {
        // it is fucking crazy but usefull
        function is_true($val)
        {
            if ($val == 'true') {
                return true;
            } else {
                return false;
            }
        }
        // Request Validation 
        $request->validate([
            'user_id' => 'required',
            'status' => 'required',
            'reach_to' => 'required',
            'comment_open' => 'required',
            'share_open' => 'required',
        ]);
        // PUBLICPTH 
        if ($request->file('images')) {
            $iamges = array();
            foreach ($request->file('images') as $image) {
                # code...
                $image_name = uniqid() . "_" . $image->getClientOriginalName();
                $path = public_path('PostPhato');
                $image->move($path, $image_name);
                $iamges[] = $image_name;
            }
        } else {
            $iamges = array();
        }
        // Creating Post 
        $db = new Post;
        $db->user_id = $request->user_id;
        $db->content = $request->status;
        $db->phato = json_encode($iamges);
        $db->likes = '0';
        $db->comments = '0';
        $db->shares = '0';
        $db->comment_open = is_true($request->comment_open);
        $db->share_open = is_true($request->share_open);
        $db->reach_to = $request->reach_to;
        // if user is choice the text color 
        if ($request->text_color != '') {
            $db->text_color = $request->text_color;
        } else {
            $db->text_color = "none";
        }
        // if user is choice the feeling 
        if ($request->feeling != '') {
            $db->feeling = $request->feeling;
        }
        // User is not         +y+++++++++++++
        else {
            $db->feeling = "none";
        }
        // Post Save 
        if ($db->save()) {
            return true;
        } else {
            return false;
        }
    }


    public function date($id)
    {
        $post =  Post::find($id);
        $datetime = array(
            'years' => date_format($post->created_at, 'Y'),
            'month' => date_format($post->created_at, 'M'),
            'months' => date_format($post->created_at, 'm'),
            'day' => date_format($post->created_at, 'D'),
            'days' => date_format($post->created_at, 'd'),
            'hour' => date_format($post->created_at, 'h'),
            'secounds' => date_format($post->created_at, 's'),
            'minutes' => date_format($post->created_at, 'i'),

        );
        return $datetime;
    }


    public function userData($id)
    {
        $user = User::find($id);
        $user_ary = array();
        $user_ary['id'] = $user->id;
        $user_ary['name'] = $user->name;
        $user_ary['profile_phato'] = $user->profile_phato;
        return $user_ary;
    }


    public function PostAll($id)
    {
        $posts = Post::where('user_id', $id)->get();
        return $posts;
    }

    /*
                    LIKE System 
    --------------------------------------------------------
     Server is check the like system before show the post 
     If User is liked return True and user is not like return False
     My be User is unlike the post we are need to destroy the like 
    */
    // Checking the user status 
    public function ifLike($id, $user_id)
    {
        $post = Like::where('user_id', $user_id)->where('post_id', $id)->first();
        if (isset($post->user_id) && isset($post->post_id)) {
            if ($post->user_id == $user_id && $post->post_id == $id) {
                return true;
            }
        } else {
            return false;
        }
    }
    // Like to a post 
    public function Like($id, $user_id)
    {
        $post = Like::where('user_id', $user_id)->where('post_id', $id)->first();
        if (isset($post->user_id) && isset($post->post_id)) {
            if ($post->user_id == $user_id && $post->post_id == $id) {
                $like =  Like::find($post->id);
                $like->delete();
                $post = Post::find($id);
                $post->likes--;
                $post->save();
                return false;
            }
        } else {
            // UnLike a post 
            $like = new Like;
            $like->user_id = $user_id;
            $like->post_id = $id;
            $Plus = Post::find($id);
            $Plus->likes++;
            $Plus->update();
            if ($like->save()) {
                return true;
            } else {
                return false;
            }
        }
    }    

    public function destroy(Request $request,$id)
    {
        $check = Post::where('id',$id)->get();
        if($request->user_id == $check[0]->user_id){
            $post = Post::find($id);
            $post->delete();
            return true;
        }else {
            return false;
        }
    }

    public function whoLikedThePost($id)
    {
        # searching from database who like the post 
        $likes = Like::where('post_id',$id)->get();
        $likes_data = $likes;
        # people data array building 
        $peoples = array();
        $people = array();
        for($i=0;$i<count($likes);$i++){
            $user_id =  json_encode($likes_data[$i]->user_id);
            $user    = User::where('id',json_decode($user_id))->get();
            $people['id'] = $user[0]->id;
            $people['name'] = $user[0]->name;
            $people['phato'] = $user[0]->profile_phato;
            $peoples[] = $people;

        }
        return json_encode($peoples);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // it is fucking crazy but usefull
        function is_true($val)
        {
            if($val == 'true'){
                return true;
            }else {
                return false;
            }
        }
        // Request Validation 
        $request->validate([
            'user_id'=>'required',
            'image'=>'required|image|mimes:jpg,png,jpeg',
            'status'=>'required',
            'reach_to'=>'required',
            'comment_open'=>'required',
            'share_open'=>'required',
        ]);
        // PUBLIC PATH 
        $path = public_path('PostPhato');
        // IMAGE NAME 
        $Img  = uniqid()."_".$request->file('image')->getClientOriginalName();
        // IMAGE FILE MOVING
        $request->file('image')->move($path,$Img);
        // Creating Post 
        $db = new Post;
        $db->user_id = $request->user_id;
        $db->content = $request->status;
        $db->phato = $Img;
        $db->likes = '0';
        $db->comments = '0';
        $db->shares = '0';
        $db->comment_open = is_true($request->comment_open);
        $db->share_open = is_true($request->share_open);
        $db->reach_to = $request->reach_to;
        // if user is choice the text color 
        if($request->text_color != ''  ){
            $db->text_color = $request->text_color;
        }
        else {
            $db->text_color ="none";
        }
        // if user is choice the feeling 
        if ($request->feeling != '') {
            $db->feeling = $request->feeling;
        }
        // User is not 
        else {
            $db->feeling = "none";
        }
        // Post Save 
        if($db->save()){
            return true;
        }else {
            return false;
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function date($id)
    {
        $post =  Post::find($id);
        $datetime = array(
            'years'=>date_format($post->created_at,'Y'),    
            'month'=>date_format($post->created_at,'M'),    
            'months'=>date_format($post->created_at,'m'),    
            'day'=>date_format($post->created_at,'D'),    
            'days'=>date_format($post->created_at,'d'),    
            'hour'=>date_format($post->created_at,'h'),    
            'secounds'=>date_format($post->created_at,'s'),    
            'minutes'=>date_format($post->created_at,'i'),    

        );
        return $datetime;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userData($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function PostAll($id)
    {
        $posts = Post::where('user_id',$id)->get();
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
    public function ifLike($id,$user_id)
    {
        $post = Like::where('user_id',$user_id)->where('post_id',$id)->first();
        if(isset($post->user_id) && isset($post->post_id)){
            if($post->user_id == $user_id && $post->post_id == $id){
                return true;
            }
        }
        else {
            return false;
        }

    }
    // Like to a post 
    public function Like($id,$user_id)
    {
        $post = Like::where('user_id',$user_id)->where('post_id',$id)->first();
        if(isset($post->user_id) && isset($post->post_id)){
            if($post->user_id == $user_id && $post->post_id == $id){
                $like =  Like::find($post->id);
                $like->delete();
                $post = Post::find($id);
                $post->likes--;
                $post->save();
                return false;
            }
        }
        else {
            $like = new Like;
            $like->user_id = $user_id;
            $like->post_id = $id;
            $Plus = Post::find($id);
            $Plus->likes++;
            $Plus->update();
            if($like->save()){
                return true;
            }else { return false; }
        }


    }
    // UnLike a post 
    public function unLike($user_id, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

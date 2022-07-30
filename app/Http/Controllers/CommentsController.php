<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Save;
use Illuminate\Support\Facades\Auth;
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        if($comment->save()){
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cmts = Comment::where('post_id',$id)->get();
        return $cmts;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Date($id)
    {
        $post =  Comment::find($id);
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

    public function UserData($id)
    {
        # code...
        $user = User::find($id);
        $user_ary = array();
        $user_ary['id'] = $user->id;
        $user_ary['name'] = $user->name;
        $user_ary['profile_phato'] = $user->profile_phato;
        return $user_ary;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Edit(Request $request,$id)
    {
        $comment  = Comment::find($id);
        $comment->content = $request->content;
        if($comment->update()){
            return json_encode(true);
        }else {
            return json_encode(false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if(Auth::user()->id == $request->user_id){
            $comment = Comment::find($id);
            if($comment->delete()){
                return json_encode(true);
            }else {
                return json_encode(false);
            }
        }
    }

    public function SaveComment(Request $req){
        $data = Save::where('user_id',$req->user_id)
                    ->where('save_category_id',$req->save_category_id)
                    ->where('save_type',$req->save_type)
                    ->first();
        if($data == null){
            $save = new Save;
            $save->user_id = $req->user_id;
            $save->save_category_id = $req->save_category_id;
            $save->save_type = $req->save_type;
            if($save->save()){
                return json_encode(true);
            }
        }else {
            return json_encode(false);
        }
        
    }

    public function UnSaveComment(Request $req){
        $data = Save::where('user_id',$req->user_id)
                    ->where('save_category_id',$req->save_category_id)
                    ->where('save_type',$req->save_type)
                    ->first();
        if($data != null){
            $save = Save::find($data->id);
            if($save->delete()){
                return json_encode(true);
            }
        }else {
            return json_encode(false);
        }
        
    }

    public function IfSaveComment(Request $req){
        $data = Save::where('user_id',$req->user_id)
                    ->where('save_category_id',$req->save_category_id)
                    ->where('save_type',$req->save_type)
                    ->first();
        if($data == null){
            return json_encode(false);
        }else {
            return json_encode(true);
        }
    }

    public function SaveComments($id)
    {
        $save = Save::where('user_id', $id)->where('save_type','Post')->get();
        $posts= array();
        foreach ($save as $data) {
            $id = $data->save_category_id;
            $post = Comment::find( $data->save_category_id);
            if(Comment::find( $data->save_category_id)){
               $user_data = array();
               $user_data['id'] = User::find( $post->user_id)->id;
               $user_data['name'] = User::find( $post->user_id)->name;
               $user_data['profile_phato'] = User::find( $post->user_id)->profile_phato;
               $post['user_data'] =  $user_data; 
               $posts[] = $post;
            }
        }
        return $posts;
    }
}

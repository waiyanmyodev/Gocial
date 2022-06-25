<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
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
    public function update(Request $request, $id)
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

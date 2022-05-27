<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail;
class DetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $db = new Detail;
        $db->phone_number = 'none'; 
        $db->website = 'none'; 
        $db->links = 'none'; 
        $db->nickname = 'none'; 
        $db->user_id = $request->user_id;
        if($db->save()){
            return "OK";
        }else {
            return "Fail";
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
    public function show(Request $request)
    {
        $details = Detail::where('user_id',$request->user_id)->get();
        return $details;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $table = Detail::find($request->id);

            // if action is be work 
        if($request->action == 'work')
            { 
                $table->work = $request->value; 
                $table->update();
                echo "ok";
            }
            // if action is be phone_number 
        if($request->action == 'phone_number')
            { 
                $table->phone_number = $request->value; 
                $table->update();
            }
            // if action is be nickname 
        if($request->action == 'nickname')
            { 
                $table->nickname = $request->value; 
                $table->update();
                echo "ok";
            }
            // if action is be link 
        if($request->action == 'links')
            { 
                $table->links = $request->value; 
                $table->save();
                echo "ok";
            }
            // if action is be website 
        if($request->action == 'website')
            { 
                $table->website = $request->value; 
                $table->update();
                echo "ok";
            }
            // if action is be relationship_status 
        if($request->action == 'relationship_status')
            { 
                $table->relationship_status = $request->value; 
                $table->update();
                echo "ok";
            }
        
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

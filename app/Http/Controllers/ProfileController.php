<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function GetUser($id)
    {
        $user = User::find($id);
        $data_ary = array();
        $data_ary['id'] =  $user->id;
        $data_ary['profile_phato'] = $user->profile_phato;
        $data_ary['name'] = $user->name;
        $data_ary['gender'] = $user->gender;
        $data_ary['birthday'] = $user->birthday;
        return $data_ary;
    }

    public function SaveUser(Request $req){
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

    public function UnSaveUser(Request $req){
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

    public function IfSaveUser(Request $req){
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

    public function SaveUsers($id)
    {
        $save = Save::where('user_id', $id)->where('save_type',"User")->get();
        $users= array();
        foreach ($save as $data) {
            $id = $data->save_category_id;
            $user = User::find($id);
            $data_ary = array();
            $data_ary['id'] =  $user->id;
            $data_ary['profile_phato'] = $user->profile_phato;
            $data_ary['name'] = $user->name;
            $data_ary['gender'] = $user->gender;
            $data_ary['save_at'] = $data->created_at;
            $users[] = $data_ary;
        }
        return json_encode($users);
    }

    public function ChangeName(Request $request){
        if(Hash::check($request->password, Auth::user()->password)){
            $user = User::find($request->id);
            $user->name = $request->name;
            if($user->update()){
                return json_encode(true);
            }
        }else {
            return json_encode(false);
        }
    }

    public function ChangePassword(Request $request){
        if(Hash::check($request->current_password,Auth::user()->password)){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            if($user->update()){
                return json_encode(true);
            }
        }else {
            return json_encode(false);
        }
    }

}

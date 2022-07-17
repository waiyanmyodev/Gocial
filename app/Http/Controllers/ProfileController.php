<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

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

    public function Tester($id){
        
        

    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // FORM VALIDATION 
        $request->validate([
            'image'=>'required|image|mimes:jpg,png,jpeg',
            'name'=>'required',
            'birthday'=>'required',
            'gender'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required'
        ]);
        // PUBLIC PATH 
        $path = public_path('ProfilePhato');
        // IMAGE NAME 
        $Img  = uniqid()."_".$request->file('image')->getClientOriginalName();
        // IMAGE FILE MOVING
        $request->file('image')->move($path,$Img);
        // NEW DATABASE SETUP 
        $db = new User;
        $db->name = $request->name; // NAME 
        $db->profile_phato = $Img; // PROFILE PHATO 
        $db->gender = $request->gender; // GENDER
        $db->birthday = $request->birthday; // BIRTHDAY 
        $db->email = $request->email; // EMAIL
        $password = Hash::make($request->password); // PASSWORD HASH
        $db->password = Hash::make($request->password); // PASSWORD
        if($db->save()){
            if(Auth::attempt($request->only('email','password'))){
                $user = Auth::user();
                $token = $user->createToken('token')->plainTextToken;
                return $token;
            }else {
                echo "fail";
            }

        }


    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=> 'required',
            'password'=>'required'
        ]);
        if(Auth::attempt($request->only('email','password'))){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return $token;
        }else {
            echo "fail";
        }


    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

 
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

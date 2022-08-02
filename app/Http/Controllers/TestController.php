<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    //
    public function Test(){
        $users = User::all(['id','name','profile_phato'])[1] = 'tset';
        return $users;
    }
}

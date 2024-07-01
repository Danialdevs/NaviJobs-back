<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Register(request $request){
        return(view('register'));
    }
    public function Login(request $request){
        return(view('login'));
    }
}

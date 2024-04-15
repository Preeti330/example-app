<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getuserdetails($id){
        return view('user', [
            'user' => $id
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index ()
    {
        return view('register.index');
    }

    public function store () 
    {
        return request()->all();
    }
}

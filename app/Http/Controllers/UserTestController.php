<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserTestController extends Controller
{
    public function index() 
    {
        $users = User::all();
        return $users;
    }

    public function show($id) 
    {
        $users = User::find($id);
        return $users;
    }
}

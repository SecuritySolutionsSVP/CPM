<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function userView() {
        return view('user-view');
    }

    function profileView() {
        return view('profile-settings');
    }
}

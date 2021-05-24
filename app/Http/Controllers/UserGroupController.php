<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    function allUsergroupsView() {
        return view('usergroup-overview');
    }
    
    function groupPasswordsView () {
        return view('usergroup-passwords-view');
    }
}

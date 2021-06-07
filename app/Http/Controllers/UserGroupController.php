<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserGroupController extends Controller
{
    function allUsergroupsView() {
        return view('usergroup-overview', [
            "groups" => Group::all(),
        ]);
    }
    
    function groupPasswordsView () { // do we need this?
        return view('usergroup-passwords-view');
    }

    function myPasswordsView () {
        return view('user-password-view',[
            "credentials" => Auth::user()->getAllUserCredentials(),
        ]);
    }
}

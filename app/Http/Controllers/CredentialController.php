<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CredentialController extends Controller
{
    function notificationCredentialsView() {
        return view('dashboard');
    }

    function allCredentialsView() {
        return view('passwords-view');
    }
}

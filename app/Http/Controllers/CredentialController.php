<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CredentialController extends Controller
{
    function notificationPasswordsView() {
        return view('dashboard');
    }

    function allPasswordsView() {
        return view('passwords-view');
    }
}

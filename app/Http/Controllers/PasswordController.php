<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    function notificationPasswordsView() {
        return view('dashboard');
    }

    function allPasswordsView() {
        return view('passwords-view', [
            "credentials" => Credential::all(),
        ]);
    }
}

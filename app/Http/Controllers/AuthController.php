<?php

namespace App\Http\Controllers;

use App\Models\TwoFactorUserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function loginView() {
        return view('login');
    }

    function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');
        $remember = $request['remember_me'];

        if(Auth::attempt($credentials, $remember)) {
            $token = TwoFactorUserToken::factory()->create(['user_id' => Auth::user()]);
            // return redirect("/login/token/$token->id");
            return redirect()->intended();
        } else {
            return redirect('login');
        }
    }

    function logout() {
        Auth::logout();
        return redirect('login');
    }
}

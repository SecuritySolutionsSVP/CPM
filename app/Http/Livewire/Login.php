<?php

namespace App\Http\Livewire;

use App\Mail\TwoFactorMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Login extends Component
{
    public function render()
    {
        return view('livewire.login');
    }

    public function checkCredentialsAndSendEmailToken($credentials) {
        // maybe extract custom values? Idk.
        $authenticated = Auth::check($credentials);

        if($authenticated) {
            Mail::to($credentials["email"])->send(new TwoFactorMail());
        }

        return Auth::check($credentials);
    }
    public function authenticate($credentials, $token) {
        // authenticate after checking credentials, sending email
        $user = User::find($credentials['email']);
    }
}

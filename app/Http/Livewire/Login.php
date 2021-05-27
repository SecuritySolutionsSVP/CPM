<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public function render()
    {
        return view('livewire.login');
    }

    public function checkCredentialsAndSendEmailToken($credentials) {
        // maybe extract custom values? Idk.
        return Auth::check($credentials);
    }
    public function authenticate($credentials, $token) {
        // authenticate after checking credentials, sending email
        $user = User::find($credentials['email']);
    }
}

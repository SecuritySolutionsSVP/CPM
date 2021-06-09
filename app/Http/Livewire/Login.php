<?php

namespace App\Http\Livewire;

use App\Mail\TwoFactorMail;
use App\Models\TwoFactorUserToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember;
    public $token;
    public $showModal;

    public function mount() {
        $this->email = user::first()->email;
        $this->password = "password";
    }
    public function render()
    {
        return view('livewire.login');
    }

    public function validateCredentials() {
        $credentials = [
            "email" => $this->email,
            "password" => $this->password
        ];

        if(Auth::attempt($credentials, $this->remember, false)) {
            $this->token = TwoFactorUserToken::factory()->create(['user_id' => Auth::user()]);
            return redirect()->intended();
        } else {
            return redirect('login');
        }
        $this->showModal = true;
    }

    public function validateToken() {
        if(Auth::attempt($credentials, $this->remember, false)) {
            $this->token = TwoFactorUserToken::factory()->create(['user_id' => Auth::user()]);
            return redirect()->intended();
        } else {
            return redirect('login');
        }
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

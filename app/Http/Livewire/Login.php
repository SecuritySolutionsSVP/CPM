<?php

namespace App\Http\Livewire;

use App\Mail\TwoFactorMail;
use App\Mail\TwoFactorUserMail;
use App\Models\TwoFactorUserToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Login extends Component
{
    public $showModal;
    public $token;
    public $credentials;

    public function render()
    {
        return view('livewire.login');
    }

    public function checkCredentialsAndSendEmailToken($formData) {

        $credentials['email'] = $formData['email'];
        $credentials['password'] = $formData['password'];
        if(Auth::attempt($credentials, false, false)) {
            $this->credentials = $credentials;
            // successful credentials
            $user = User::where('email', $credentials['email'])->first();
            if($user->two_factor_expiration_bypass_time != null && $user->two_factor_expiration_bypass_time >= Carbon::now()) {
                Auth::attempt($credentials);
                return redirect()->intended();
            }

            $this->showModal = true;
            $this->token = TwoFactorUserToken::create([
                'user_id' => $user->id,
                'token' => TwoFactorUserToken::generateCode(6),
                'expiration' => Carbon::now()->addMinutes(10),
            ]);
            Mail::to($user)->send(new TwoFactorUserMail($this->token));
        }
    }
    public function authenticate($formData) {
        if($this->token->token == $formData['token']) {
            if(Auth::attempt($this->credentials)) {
                $user = Auth::user();
                $user->two_factor_expiration_bypass_time = Carbon::now()
                                    ->addDays(env('APP_2FA_REMEMBER_DAYS', 0))
                                    ->addHours(env('APP_2FA_REMEMBER_HOURS', 0))
                                    ->addMinutes(env('APP_2FA_REMEMBER_MINUTES', 0));
                $user->save();
                return redirect()->intended();
            } else {
                return redirect('/login');
            }
        }
    }
}

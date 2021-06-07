<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\TwoFactorMail;
use App\Models\TwoFactorUserToken;
use App\Models\TwoFactorCredentialToken;
use App\Models\User;
use Carbon\Carbon;

class MailController extends Controller
{
    function twoFactorUser(Request $request){

        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
        ]);

        $input = $request->only('user_id');

        $code = TwoFactorUserToken::generateCode(6);
        $input['token'] = bcrypt($code);
        $input['expiration'] = Carbon::now()->addMinutes(5);
        $twoFA = TwoFactorUserToken::create($input);

        $user = User::find($input['user_id']);

        $to_name = $user->first_name . " " . $user->last_name;
        $to_email = $user->email;
        $data = array('name'=>"$to_name", "body" => "Code: ", "TwoFactorToken"=> "$code");
        Mail::send('mail.two_factor_mail', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Laravel Test Mail');
        $message->from('no-reply@datatekniker.dev','Test Mail');
        });
    }

    function twoFactorCredential(Request $request){

        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
            'credential_id' => 'required',
        ]);

        $userID = $request->only('user_id');
        $user = User::find($userID['user_id']);
        $code = TwoFactorCredentialToken::generateCode(6);

        $input = $request->only('credential_id');
        $input['token'] = bcrypt($code);
        $input['expiration'] = Carbon::now()->addMinutes(5);
        $twoFA = TwoFactorCredentialToken::create($input);

        $to_name = $user->first_name . " " . $user->last_name;
        $to_email = $user->email;
        $data = array('name'=>"$to_name", "body" => "Code: ", "TwoFactorToken"=> "$code");
        Mail::send('mail.two_factor_mail', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Laravel Test Mail');
        $message->from('no-reply@datatekniker.dev','Test Mail');
        });
    }
}

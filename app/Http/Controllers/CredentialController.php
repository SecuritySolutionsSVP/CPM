<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Credential;
use App\Models\User;


class CredentialController extends Controller
{
    function notificationPasswordsView() {
        return view('dashboard');
    }

    function allPasswordsView() {
        return view('passwords-view');
    }

    public function getUserCredentials(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
        ]);

        $input = $request->only('user_id');
        $user = User::find($input['user_id']);
        
        $credentials = [];
        foreach ($user->personalCredentialPrivileges as $credential) {
            $credentials[] = $credential->pivot->credential_id;
        }

        return $credentials;
    }

    public function getCredentialUsers(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'credential_id' => 'required',
        ]);

        $input = $request->only('credential_id');
        $credential = Credential::find($input['credential_id']);

        $users = [];
        foreach ($credential->privilegedUsers as $user) {
            $users[] = $user->pivot->user_id;
        }

        return $users;
    }

    public function addUserToCredential(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
            'credential_id' => 'required',
        ]);

        $input = $request->only('user_id', 'credential_id');

        $user = User::find($input['user_id']);
        $credential = Credential::find($input['credential_id']);
        
        $user->personalCredentialPrivileges()->attach($credential);
    }

    public function removeUserFromCredential(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
            'credential_id' => 'required',
        ]);

        $input = $request->only('user_id', 'credential_id');

        $user = User::find($input['user_id']);
        $credential = Credential::find($input['credential_id']);
        
        $user->personalCredentialPrivileges()->detach($credential);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Credential;

class UserController extends Controller
{
    function userView() {
        $users = User::all();
        $users->searchable();
        return view('user-view', [
            "users" => $users,
        ]);
    }

    function profileView() {
        return view('profile-settings');
    }

    function userCredentialsView() {
        $request = new Request();
        $request->replace(['user_id' => request('id')]);
        $credentials = UserController::getUserCredentials($request);
        $request->replace(['id' =>  $credentials]);
        return view('user-credentials-overview', [
            "credentials" => CredentialController::getCredentialsInfo($request),
            "userID" => request('id')
        ]);
    }

    /** 
     * Get Group Credential
     * 
     * @return User 
     */ 
    public static function getUserCredentials(Request $request) {
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

    /** 
     * Add Credential to Group 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public static function addCredentialToUser(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'credential_id' => 'required',
            'user_id' => 'required',
        ]);

        $input = $request->only('credential_id', 'user_id');

        $credential = Credential::find($input['credential_id']);
        $user = User::find($input['user_id']);
        
        $credential->privilegedUsers()->attach($user);
    }

    /** 
     * Remove Credential from Group 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public static function removeCredentialFromUser(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'credential_id' => 'required',
            'user_id' => 'required',
        ]);

        $input = $request->only('credential_id', 'user_id');

        $credential = Credential::find($input['credential_id']);
        $user = User::find($input['user_id']);
        
        $credential->privilegedUsers()->detach($user);
    }

    /** 
     * Get Group Credential
     * 
     * @return Credential 
     */ 
    public static function getNoneUserCredentials(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
        ]);

        $input = $request->only('user_id');

        $request = new Request();
        $request->replace(['user_id' => $input['user_id']]);
        $credentials = UserController::getUserCredentials($request);

        $noneCredentials = Credential::all()->whereNotIn('id', $credentials);

        return $noneCredentials;
    }

    /** 
     * Get Group Users
     * 
     * @return User 
     */ 
    public static function getUsersInfo(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'id' => 'required',
        ]);

        $input = $request->only('id');
        foreach ($input as $key => $value) {
            $users = User::find($value);
        }

        return $users;
    }

    /** 
     * Create User 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function create(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'first_name' => 'required', 
            'last_name' => 'required', 
            'role_id' => 'required',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required', 
            'c_password' => 'required|same:password',
        ]);

        $input = $request->all();

        if ($validator->fails()) { 
            if ($input['password'] != $input['c_password']) {
                return redirect('/users')->with('error', 'Adgangskoden matcher ikke.'); 
            }
            return redirect('/users')->with('error', 'Brugeren eksisterer');          
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        return redirect('/users');
    }

    /** 
     * Update User
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function update(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'id' => 'required', 
            'first_name' => 'required', 
            'last_name' => 'required', 
            'role_id' => 'required',
            'email' => 'required|email', 
        ]);

        $input = $request->only('id', 'first_name', 'last_name', 'role_id', 'email');

        $user = User::find($input['id']);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->role_id = $input['role_id'];
        $user->email = $input['email'];
        $user->save();
        return redirect('/users');
    }

    /** 
     * Update Password
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function updatePassword(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'id' => 'required',
            'email' => 'required',
            'current_password' => 'required',
            'password' => 'required|different:current_password',
            'c_password' => 'same:password',
        ]);

        $input = $request->only('id', 'password', 'c_password');
        $credentials = $request->only('email');
        $credentials['password'] = $request['current_password'];

        if ($validator->fails()) { 
            return redirect('/user/ret');
        }
        
        $user = User::find($input['id']);
        if (!empty($input['password']) && Auth::attempt($credentials,false,false)) {
            $user->password = bcrypt($input['password']);
        }
        $user->save();
        return redirect('/users');
    }

    /** 
     * Delete User 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function delete(Request $request) 
    { 
        $user = User::find(request('id'));
        $user->delete();
        return redirect('/users');
    }

    /** 
     * Force Delete User 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function forceDelete(Request $request) 
    { 
        User::where('id', request('id'))->forceDelete();
        return redirect('/users');
    }
}

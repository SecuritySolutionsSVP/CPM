<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function userView() {
        return view('user-view');
    }

    function profileView() {
        return view('profile-settings');
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
            'password' => '', 
            'c_password' => 'same:password', 
        ]);

        $input = $request->all(); 

        if ($validator->fails()) { 
            if ($input['password'] != $input['c_password']) {
                return redirect('/user/ret')->with('error', 'Adgangskoden matcher ikke.'); 
            }
            return redirect('/user/ret')->with('error', 'Brugeren eksisterer');          
        }

        $user = User::find($input['id']);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->role_id = $input['role_id'];
        $user->email = $input['email'];
        if (!empty($input['password'])) {
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credential;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    function notificationPasswordsView() {
        return view('dashboard');
    }

    function allPasswordsView() {
        return view('passwords-view');
    }

    /** 
     * Create Credential 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function create(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'username' => 'required', 
            'password' => 'required', 
            'credential_group_id' => 'required',
            'is_sensitive' => 'required', 
        ]);

        $input = $request->all();

        if ($validator->fails()) { 
            return redirect('/password');          
        }

        $input['password'] = bcrypt($input['password']);
        $credential = Credential::create($input);
        return redirect('/password');
    }

    /** 
     * Update Credential
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function update(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'id' => 'required', 
            'username' => 'required', 
            'password' => 'required', 
            'credential_group_id' => 'required',
            'is_sensitive' => 'required',  
        ]);

        $input = $request->only('id', 'username', 'password', 'credential_group_id', 'is_sensitive');

        $credential = Credential::find($input['id']);
        $credential->username = $input['username'];
        $credential->password = $input['password'];
        $credential->credential_group_id = $input['credential_group_id'];
        $credential->is_sensitive = $input['is_sensitive'];
        $credential->save();
        return redirect('/password');
    }

    /** 
     * Delete Credential 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function delete(Request $request) 
    { 
        $credential = Credential::find(request('id'));
        $credential->delete();
        return redirect('/password');
    }
}

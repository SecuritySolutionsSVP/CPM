<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Credential;
use App\Models\Group;
use App\Models\User;


class CredentialController extends Controller
{
    function notificationPasswordsView() {
        return view('dashboard');
    }

    function allPasswordsView() {
        return view('passwords-view');
    }

    /** 
     * Get User Credentials
     * 
     * @return Credential 
     */
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

    /** 
     * Get Credential Users
     * 
     * @return User 
     */
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

    /** 
     * Get Group Credentials
     * 
     * @return Credential 
     */
    public function getGroupCredentials(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'group_id' => 'required',
        ]);

        $input = $request->only('group_id');
        $group = Group::find($input['group_id']);
        
        $credentials = [];
        foreach ($group->credentialPrivileges as $credential) {
            $credentials[] = $credential->pivot->credential_id;
        }

        return $credentials;
    }

    /** 
     * Get Credential Groups
     * 
     * @return Group 
     */
    public function getCredentialGroups(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'credential_id' => 'required',
        ]);

        $input = $request->only('credential_id');
        $credential = Credential::find($input['credential_id']);

        $groups = [];
        foreach ($credential->privilegedGroups as $group) {
            $groups[] = $group->pivot->group_id;
        }

        return $groups;
    }

    /** 
     * Add Group to Credential
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function addGroupToCredential(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'group_id' => 'required',
            'credential_id' => 'required',
        ]);

        $input = $request->only('group_id', 'credential_id');

        $group = Group::find($input['group_id']);
        $credential = Credential::find($input['credential_id']);
        
        $group->credentialPrivileges()->attach($credential);
    }

    /** 
     * Add User to Credential
     * 
     * @return \Illuminate\Http\Response 
     */
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

    /** 
     * Remove Group from Credential
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function removeGroupFromCredential(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'group_id' => 'required',
            'credential_id' => 'required',
        ]);

        $input = $request->only('group_id', 'credential_id');

        $group = Group::find($input['group_id']);
        $credential = Credential::find($input['credential_id']);
        
        $group->credentialPrivileges()->detach($credential);
    }

    /** 
     * Remove User from Credential
     * 
     * @return \Illuminate\Http\Response 
     */ 
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

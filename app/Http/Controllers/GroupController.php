<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Group;

class GroupController extends Controller
{
    function groupsView() {
        return view('group-overview');
    }

    /** 
     * Get User Groups
     * 
     * @return Group 
     */
    public function getUserGroups(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
        ]);

        $input = $request->only('user_id');
        $user = User::find($input['user_id']);
        
        $groups = [];
        foreach ($user->groups as $group) {
            $groups[] = $group->pivot->group_id;
        }

        return $groups;
    }

    /** 
     * Get Group Users
     * 
     * @return User 
     */ 
    public function getGruopUsers(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'group_id' => 'required',
        ]);

        $input = $request->only('group_id');
        $group = Group::find($input['group_id']);

        $users = [];
        foreach ($group->users as $user) {
            $users[] = $user->pivot->user_id;
        }

        return $users;
    }

    /** 
     * Add User to Group 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function addUserToGroup(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
            'group_id' => 'required',
        ]);

        $input = $request->only('user_id', 'group_id');

        $user = User::find($input['user_id']);
        $group = Group::find($input['group_id']);
        
        $user->groups()->attach($group);
    }

    /** 
     * Remove User from Group 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function removeUserFromGroup(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required',
            'group_id' => 'required',
        ]);

        $input = $request->only('user_id', 'group_id');

        $user = User::find($input['user_id']);
        $group = Group::find($input['group_id']);
        
        $user->groups()->detach($group);
    }

    /** 
     * Create Group 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function create(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'name' => 'required|unique:groups,name',
        ]);

        $input = $request->only('name');

        if ($validator->fails()) { 
            return redirect('/groups')->with('error', 'Gruppe eksisterer');          
        }

        $group = Group::create($input);
        return redirect('/groups');
    }

    /** 
     * Update Group
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function update(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'id' => 'required', 
            'name' => 'required|unique:groups,name',
        ]);

        $input = $request->only('name');

        if ($validator->fails()) { 
            return redirect('/group/ret')->with('error', 'Gruppe eksisterer');          
        }

        $group = Group::find($input['id']);
        $group->name = $input['name'];
        $group->save();
        return redirect('/groups');
    }

    /** 
     * Delete Group 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function delete(Request $request) 
    { 
        $group = Group::find(request('id'));
        $group->delete();
        return redirect('/groups');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Group;

class GroupController extends Controller
{
    function groupsView() {
        $groups = Group::all();
        $groups->searchable();
        return view('group-overview', [
            "groups" => $groups,
        ]);
    }

    function groupUsersView() {
        $request = new Request();
        $request->replace(['group_id' => request('id')]);
        $users = GroupController::getGroupUsers($request);
        $request->replace(['id' =>  $users]);
        return view('group-users-overview', [
            "users" => UserController::getUsersInfo($request),
            "groupID" => request('id')
        ]);
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
    public static function getGroupUsers(Request $request) {
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
     * Get Group Users
     * 
     * @return User 
     */ 
    public static function getNoneGroupUsers(Request $request) {
        $validator = Validator::make($request->all(), 
        [ 
            'group_id' => 'required',
        ]);

        $input = $request->only('group_id');

        $request = new Request();
        $request->replace(['group_id' => $input['group_id']]);
        $users = GroupController::getGroupUsers($request);

        $noneUsers = User::all()->whereNotIn('id', $users);

        return $noneUsers;
    }

    /** 
     * Add User to Group 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public static function addUserToGroup(Request $request) {
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
    public static function removeUserFromGroup(Request $request) {
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
    public static function create(Request $request) 
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
    public static function update(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'id' => 'required', 
            'name' => 'required|unique:groups,name',
        ]);

        $input = $request->only('id','name');

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
    public static function delete(Request $request) 
    {
        $group = Group::find($request['id']);
        $group->delete();
        return redirect('/groups');
    }
}

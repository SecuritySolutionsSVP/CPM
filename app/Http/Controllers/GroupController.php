<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Group;

class GroupController extends Controller
{
    function groupsView() {
        return view('group-overview');
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
            'name' => 'required',
        ]);

        $input = $request->all();

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
            'name' => 'required',
        ]);

        $input = $request->all(); 

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

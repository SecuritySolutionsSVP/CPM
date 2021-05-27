<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;

class RoleController extends Controller
{
    function rolesView() {
        return view('roles-overview');
    }

    /** 
     * Create Role 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function create(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'name' => 'required',
            'priviledge_level' => 'required',
        ]);

        $input = $request->all();

        if ($validator->fails()) { 
            return redirect('/roles')->with('error', 'Rolle eksisterer');          
        }

        $role = Role::create($input);
        return redirect('/roles');
    }

    /** 
     * Update Role
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function update(Request $request) 
    { 
        $validator = Validator::make($request->all(), 
        [ 
            'id' => 'required', 
            'name' => 'required',
            'priviledge_level' => 'required',
        ]);

        $input = $request->all(); 

        if ($validator->fails()) { 
            return redirect('/role/ret')->with('error', 'Rolle eksisterer');          
        }

        $role = Role::find($input['id']);
        $role->name = $input['name'];
        $role->priviledge_level = $input['priviledge_level'];
        $role->save();
        return redirect('/roles');
    }

    /** 
     * Delete Role 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function delete(Request $request) 
    { 
        $role = Role::find(request('id'));
        $role->delete();
        return redirect('/roles');
    }
}

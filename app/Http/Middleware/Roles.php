<?php

namespace App\Http\Middleware;

//use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\Role;
use App\Http\Controllers\RoleController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\IsNull;

class Roles
{
    public function handle(Request $request, Closure $next, $roles)
    {
        $user = Auth::user();
        $roleList = Role::all()->where('name', $roles);

        foreach($roleList as $role) {
            if ($role['id'] == $user->role_id) {
                return $next($request);
            }
        }

        return redirect('/');
    }
}

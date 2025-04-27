<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleController extends Controller
{
    public function showRoles()
    {
      $users=User::all();
 
    
    
      return view('role.users',compact('users'));
    
  
    }
    public function roleIndex(){
      $roles=ModelsRole::all();
      return view('role.index',compact('roles'));
    }

}

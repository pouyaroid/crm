<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function create(){
        $roles=Role::all();
        return view('role.create-user',compact('roles'));
    }
    public function store(Request $request){
       $request->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6',
        'role'=>'required|exists:roles,name',

       ]);
       $user=User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
       ]);
       $user->assignRole($request->role);

       return redirect()->route('users.create')->with('success', 'کاربر با موفقیت ایجاد شد.');


    }
    public function index()
{
    $users = User::all(); // دریافت همه کاربران
    return view('users.index', compact('users'));
}

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSupervisor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
      
        $users = User::all();
        return view('supervisors.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'supervisor_id' => 'required|exists:users,id|different:user_id',
        ]);

        UserSupervisor::updateOrCreate(
            ['user_id' => $request->user_id],
            ['supervisor_id' => $request->supervisor_id]
        );

        return back()->with('success', 'سرپرست تعیین شد.');
    }
}

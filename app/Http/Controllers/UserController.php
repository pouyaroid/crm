<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // نمایش فرم ایجاد کاربر با لیست تمام نقش‌ها
    public function create()
    {
        $roles = Role::all(); // گرفتن همه نقش‌ها
        return view('role.create-user', compact('roles'));
    }

    // ذخیره کاربر جدید با چند نقش
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles'    => 'required|array',
            'roles.*'  => 'exists:roles,name', // بررسی وجود داشتن هر نقش
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles); // اختصاص چند نقش به کاربر

        return redirect()->route('users.create')->with('success', 'کاربر با موفقیت ایجاد شد.');
    }

    // لیست کاربران + جستجو
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('users.index', compact('users'));
    }
}

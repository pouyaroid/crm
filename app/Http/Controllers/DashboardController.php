<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user(); // دریافت اطلاعات کاربر لاگین شده
        return view('dashboard', ['user' => $user]); // ارسال اطلاعات به ویو
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

    $query = Complaint::with(['user', 'images', 'response']);

    if ($user->role === 'sales_agent') {
        $query->whereHas('user', function ($q) use ($user) {
            $q->where('sales_agent_id', $user->id);
        });
    } elseif ($user->role === 'sales_manager') {
        $query->where('user_id', $user->id);
    }
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }
    

    $complaints = $query->latest()->paginate(10);

    return view('admin.dashboard', compact('complaints'));
    }
   
}

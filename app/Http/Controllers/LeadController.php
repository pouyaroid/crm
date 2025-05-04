<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function leadsStore(Request $request){
        $validate=$request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'interest_level' => 'required|in:کم,متوسط,زیاد',
            'note' => 'nullable|string',
            'status' => 'required|in:در انتظار تماس,تماس گرفته شد,تبدیل به مشتری شد',
        ]);
        Lead::create($validate);
        return redirect()->route('leads.create')->with('success', 'مشتری احتمالی با موفقیت ثبت شد.');
       
       

    }
    public function index(){
        $leads = Lead::paginate(20); // یا مثلاً 15 یا هر تعداد دلخواه
        return view('leads.index', compact('leads'));
        
        
    }
    public function create(){
        return view('leads.create');
    }
}

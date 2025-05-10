<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function leadsStore(Request $request){
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'company' => 'nullable|string|max:255',
                'source' => 'nullable|string|max:255',
                'interest_level' => 'required|in:کم,متوسط,زیاد',
                'note' => 'nullable|string',
                'status' => 'required|in:در انتظار تماس,تماس گرفته شد,تبدیل به مشتری شد',
            ]);
    
            Lead::create($validated);
    
            return redirect()
                ->route('leads.create')
                ->with('success', 'مشتری احتمالی با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput() // برای حفظ اطلاعات فرم در صورت خطا
                ->with('error', 'خطا در ثبت اطلاعات. لطفاً دوباره تلاش کنید.');
        }
       
       

    }
    public function index(Request $request){
        $query = Lead::query();

        $query = Lead::query();

        // جستجو بر اساس نام یا تلفن
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }
    
        // فیلترهای جداگانه
        if ($request->filled('company')) {
            $query->where('company', 'like', "%{$request->company}%");
        }
    
        if ($request->filled('source')) {
            $query->where('source', 'like', "%{$request->source}%");
        }
    
        if ($request->filled('interest_level')) {
            $query->where('interest_level', $request->interest_level);
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $leads = $query->latest()->paginate(20)->withQueryString();
        return view('leads.index', compact('leads'));
        
    }
    public function create(){
        return view('leads.create');
    }
    public function edit(Lead $lead)
{
    return view('leads.edit', compact('lead'));
}
public function update(Request $request, Lead $lead)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'company' => 'nullable|string|max:255',
        'source' => 'nullable|string|max:255',
        'interest_level' => 'required|in:کم,متوسط,زیاد',
        'note' => 'nullable|string',
        'status' => 'required|in:در انتظار تماس,تماس گرفته شد,تبدیل به مشتری شد',
    ]);

    $lead->update($validated);

    return redirect()->route('leads.index')->with('success', 'اطلاعات مشتری احتمالی با موفقیت ویرایش شد.');
}
}

<?php

namespace App\Http\Controllers;

use App\Jobs\CheckLeadForCall;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function leadsStore(Request $request){
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
        
            try {
                $validated['user_id'] = auth()->id();
        
                // ایجاد سرنخ
                $lead = Lead::create($validated);
        
                // اجرای Job برای بررسی تماس پس از ۳ روز
                CheckLeadForCall::dispatch($lead)->delay(now()->addDays(3));
                // // CheckLeadForCall::dispatch($lead);

        
                return redirect()
                    ->route('leads.create')
                    ->with('success', 'مشتری احتمالی با موفقیت ثبت شد.');
            } catch (\Exception $e) {
                \Log::error('خطا در ثبت سرنخ: ' . $e->getMessage());
        
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'خطا در ثبت اطلاعات. لطفاً دوباره تلاش کنید.');
            }
       }
   

    }
    public function index(Request $request){
        $query = Lead::with('user');
    
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
    
        // صفحه‌بندی نهایی پس از فیلتر
        $leads = $query->latest()->paginate(15)->withQueryString();
    
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
public function exportCsv()
{
    $leads = Lead::all(); // دریافت تمامی Lead ها

    $fileName = 'leads_' . date('Y_m_d_H_i_s') . '.csv';

    $headers = [
        "Content-type"        => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['نام', 'تلفن', 'شرکت', 'منبع', 'سطح علاقه', 'یادداشت', 'وضعیت', 'کاربر'];

    $callback = function() use ($leads, $columns) {
        $file = fopen('php://output', 'w');

        // اضافه کردن BOM برای پشتیبانی از UTF-8 در نرم‌افزارهایی مانند اکسل
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($file, $columns); // اضافه کردن هدرها

        foreach ($leads as $lead) {
            $row = [
                $lead->name,
                $lead->phone,
                $lead->company,
                $lead->source,
                $lead->interest_level,
                $lead->note,
                $lead->status,
                $lead->user->name ?? 'ناشناس'
            ];

            fputcsv($file, $row);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
public function importForm()
{
    return view('leads.import');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048'
    ]);

    $path = $request->file('file')->getRealPath();
    $data = array_map('str_getcsv', file($path));

    $header = array_shift($data);

    $records = 0;
    foreach ($data as $row) {
        if (count($header) != count($row)) {
            Log::error('تعداد ستون‌های نامعتبر در ردیف: ' . implode(',', $row));
            continue;
        }

        try {
            $record = array_combine($header, $row);

            Lead::create([
                'name' => $record['نام'],
                'phone' => $record['تلفن'],
                'company' => $record['شرکت'] ?? null,
                'source' => $record['منبع'] ?? null,
                'interest_level' => $record['سطح علاقه'],
                'note' => $record['یادداشت'] ?? null,
                'status' => $record['وضعیت'],
                'user_id' => auth()->id()
            ]);
            $records++;
        } catch (\Exception $e) {
            Log::error('خطا در ایمپورت ردیف: ' . $e->getMessage() . ' - داده: ' . implode(',', $row));
        }
    }

    return redirect()->route('leads.index')->with('success', $records . ' رکورد با موفقیت ایمپورت شد.');
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showCustomReportForm()
    {
        // تنظیم تاریخ پیش‌فرض (مثلاً ۷ روز اخیر)
        $defaultStartDate = Carbon::now()->subDays(7)->format('Y-m-d');
        $defaultEndDate = Carbon::now()->format('Y-m-d');
    
        return view('admin.complaints.reports.custom-form', [
            'defaultStartDate' => $defaultStartDate,
            'defaultEndDate' => $defaultEndDate
        ]);
    }
    public function generateCustomReport(Request $request)
{
    // اعتبارسنجی
    $validated = $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date'
    ]);

    // تبدیل تاریخ‌ها به Carbon
    $startDate = Carbon::parse($validated['start_date'])->startOfDay();
    $endDate = Carbon::parse($validated['end_date'])->endOfDay();

    // دریافت داده‌ها
    $report = Complaint::selectRaw('status, COUNT(*) as count')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('status')
        ->pluck('count', 'status');

    return view('admin.complaints.reports.custom-result', [
        'report' => $report,
        'startDate' => $startDate->format('Y-m-d'),
        'endDate' => $endDate->format('Y-m-d')
    ]);
}
}

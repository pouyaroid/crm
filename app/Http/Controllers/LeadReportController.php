<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadReportController extends Controller
{
    public function index(Request $request){

        $leads = $this->filterLeadsByDate($request);

    // گروه‌بندی بر اساس روز ثبت
    $grouped = $leads->groupBy(function ($lead) {
        return $lead->created_at->format('Y-m-d');
    });

    // ساخت لیبل‌ها و داده‌ها برای نمودار
    $labels = [];
    $data = [];

    $start = $leads->min('created_at') ?? now()->subDays(7);
    $end = $leads->max('created_at') ?? now();

    $period = \Carbon\CarbonPeriod::create($start->startOfDay(), $end->endOfDay());

    foreach ($period as $date) {
        $day = $date->format('Y-m-d');
        $labels[] = $day;
        $data[] = isset($grouped[$day]) ? count($grouped[$day]) : 0;
    }

    $chartData = [
        'labels' => $labels,
        'data' => $data,
    ];

    return view('leads.reaports.reaport', compact('leads', 'chartData'));
    }
    private function filterLeadsByDate(Request $request)
    {
        $query = Lead::query();
        $range = $request->input('range');

        if ($range === '7days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($range === '1month') {
            $query->where('created_at', '>=', now()->subMonth());
        } elseif ($range === '1year') {
            $query->where('created_at', '>=', now()->subYear());
        } elseif ($range === 'custom' && $request->filled(['from', 'to'])) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        return $query->latest()->get();
    }

}

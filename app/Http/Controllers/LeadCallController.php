<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadCallController extends Controller
{
    public function create(Lead $lead)
    {
        return view('leadscall.create', compact('lead'));
    }

    public function store(Request $request, Lead $lead)
    {
        $request->validate([
            'call_summary' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'call_time' => 'nullable|date',
        ]);

        $lead->calls()->create($request->only('call_summary', 'notes', 'call_time'));

        return redirect()->route('leads.show', $lead)->with('success', 'تماس خروجی با موفقیت ثبت شد.');
    }
    public function show(Lead $lead)
{
    return view('leadscall.show', compact('lead'));
}

}

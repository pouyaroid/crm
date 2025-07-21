<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use Illuminate\Http\Request;

class CustomerCaseController extends Controller
{
    public function index(CustomerInfo $customer)
    {
        $cases = $customer->cases()->with('documents')->latest()->get();

        return view('customer_cases.index', compact('customer', 'cases'));
    }

    public function create(CustomerInfo $customer)
    {
        return view('cases.create', compact('customer'));
    }

    public function store(Request $request, CustomerInfo $customer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files.*' => 'file|mimes:pdf,jpg,png,jpeg|max:2048',
            'file_types.*' => 'required|string',
        ]);
    
        $case = $customer->cases()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $path = $file->store('customer_documents', 'public');
    
                $case->documents()->create([
                    'file_type' => $request->file_types[$index] ?? 'نامشخص',
                    'file_path' => $path,
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }
    
        return redirect()->route('customers.index')->with('success', 'پرونده و مدارک با موفقیت ثبت شدند.');
    }
}

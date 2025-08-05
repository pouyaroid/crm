<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerCall;
use App\Models\CustomerInfo;

class CustomerCallController extends Controller
{
    public function index($customerId)
    {
        $customer = CustomerInfo::findOrFail($customerId);
        $calls = $customer->calls()->latest()->get();

        return view('CustomerCall.index', compact('customer', 'calls'));
    }

    public function create($customerId)
    {
        $customer = CustomerInfo::findOrFail($customerId);
        return view('CustomerCall.create', compact('customer'));
    }

    public function store(Request $request, $customerId)
    
    {
        $customer = CustomerInfo::findOrFail($customerId);
        // dd($request->all());
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            
        ]);

        CustomerCall::create([
            'customer_info_id' => $customerId,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'called_at' =>  now(), 
        ]);

        return redirect()->route('customer.calls.index', $customerId)->with('success', 'تماس با موفقیت ثبت شد.');
    }

    public function edit($customerId, $id)
    {
        $customer = CustomerInfo::findOrFail($customerId);
        $call = CustomerCall::findOrFail($id);

        return view('CustomerCall.edit', compact('customer', 'call'));
    }

    public function update(Request $request, $customerId, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'called_at' => 'required|date',
        ]);

        $call = CustomerCall::findOrFail($id);
        $call->update($request->only(['title', 'description', 'called_at']));

        return redirect()->route('customers.calls.index', $customerId)->with('success', 'تماس ویرایش شد.');
    }

    public function destroy($customerId, $id)
    {
        $call = CustomerCall::findOrFail($id);
        $call->delete();

        return redirect()->route('customers.calls.index', $customerId)->with('success', 'تماس حذف شد.');
    }
}

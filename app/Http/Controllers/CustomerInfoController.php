<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerInfoController extends Controller
{
    public function create(){
        return view('Custumer.createcustomer');
        
    }
    public function store(Request $request){
       
       
        try {
            $validate = $request->validate([
                'company_name'     => 'required',
                'company_type'     => 'nullable',
                'personal_name'    => 'required',
                'email'            => 'required|email',
                'address'          => 'required',
                'ceo'              => 'required',
                'bank'             => 'required',
                'note'             => 'nullable',
                'account_number'   => 'required|numeric',
                'company_phone'    => 'required|numeric',
                'mobile_phone'     => 'required|numeric',
                'id_meli'          => 'required|numeric',
                'postal_code'      => 'required|numeric',
                'code_eghtesadi'   => 'required|numeric',
            ]);
    
            $validate['user_id'] = auth()->id();
    
            CustomerInfo::create($validate);
    
            return redirect()->route('customers.create')->with('success', 'مشتری با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            // ثبت خطا در لاگ
            Log::error('خطا در ثبت مشتری: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
    
            return redirect()->route('customers.create')->with('error', 'خطایی در ثبت اطلاعات رخ داد. لطفاً دوباره تلاش کنید.');
        }
    }
       
public function ajax(Request $request)
{
    $query = $request->search;
    $customers = CustomerInfo::when($query, function ($q) use ($query) {
        $q->where('personal_name', 'like', "%$query%")
            ->orWhere('company_name', 'like', "%$query%")
            ->orWhere('mobile_phone', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%");
    })->latest()->paginate(15);

    return view('Custumer.partials.table', compact('customers'))->render();
}
public function edit($id)
{
    $customer = CustomerInfo::findOrFail($id);
    return view('Custumer.edit', compact('customer'));
}

public function update(Request $request, $id)
{
    $customer = CustomerInfo::findOrFail($id);
    $customer->update($request->all());

    return redirect()->route('customers.index')->with('success', 'مشتری با موفقیت ویرایش شد.');
}

public function destroy($id)
{
    $customer = CustomerInfo::findOrFail($id);
    $customer->delete();

   

}
}


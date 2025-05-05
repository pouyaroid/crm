<?php

namespace App\Http\Controllers;

use App\Jobs\SendCustomerEmail;
use App\Mail\CustomerMessage;
use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
    public function index()
{
    // مثلاً نمایش همه اطلاعات مشتری
    $customers = CustomerInfo::all();
    return view('Custumer.index', compact('customers'));
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
    return redirect()->route('customers.index')->with('success', 'مشتری با موفقیت حذف شد.');

   

}
public function showMessageForm($id)
{
    $customer = CustomerInfo::findOrFail($id);
    return view('Custumer.email.message-single', compact('customer'));
}
public function bulkMessageForm(Request $request)
{
    $ids = $request->input('selected_customers', []);
    $customers = CustomerInfo::whereIn('id', $ids)->get();
    return view('Custumer.email.message-bulk', compact('customers'));
}
public function sendMessage(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customer_infos,id',
        'message' => 'required|string|max:1000'
    ]);

    $customer = CustomerInfo::findOrFail($request->customer_id);

    Mail::raw($request->message, function ($message) use ($customer) {
        $message->to($customer->email)
                ->subject('پیام جدید از سامانه');
    });

    return redirect()->route('customers.index')->with('success', 'پیام ایمیل ارسال شد.');
}
public function sendBulkMessage(Request $request)
{
    $request->validate([
        'selected_customers' => 'required|array',
        'message' => 'required|string|max:1000',
    ]);

    // گرفتن مشتریان انتخاب‌شده
    $customers = CustomerInfo::whereIn('id', $request->selected_customers)->get();

    // ارسال ایمیل به هر مشتری انتخاب‌شده
    foreach ($customers as $customer) {
        if (!empty($customer->email)) {
            Mail::raw($request->message, function ($message) use ($customer) {
                $message->to($customer->email)
                        ->subject('پیام جدید از سامانه');
            });
        }
    }

    return redirect()->route('customers.index')->with('success', 'پیام‌ها با موفقیت ارسال شدند.');
}
}

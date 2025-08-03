<?php

namespace App\Http\Controllers;

use App\Jobs\SendCustomerEmail;
use App\Mail\BulkMessageMail;
use App\Mail\CustomerMessage;
use App\Models\CustomerInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CustomerInfoController extends Controller
{
    public function create(){
        $salesAgents = User::role('sales_agent')->get();
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
            dd($e->getMessage());
            // ثبت خطا در لاگ
            Log::error('خطا در ثبت مشتری: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
    
            return redirect()->route('customers.create')->with('error', 'خطایی در ثبت اطلاعات رخ داد. لطفاً دوباره تلاش کنید.');
        }
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $query = CustomerInfo::query();
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('personal_name', 'LIKE', "%$search%")
                  ->orWhere('company_name', 'LIKE', "%$search%")
                  ->orWhere('mobile_phone', 'LIKE', "%$search%");
            });
        }
    
        $customers = $query->paginate(10);
    
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

    $tableView = view('customers.partials.table', compact('customers'))->render();
    $cardsView = view('customers.partials.cards', compact('customers'))->render();

    return response()->json([
        'table' => $tableView,
        'cards' => $cardsView,
    ]);
}
public function edit($id)
{
    $customer = CustomerInfo::findOrFail($id);
    $salesAgents = User::role('sales_agent')->get();
    return view('Custumer.edit', compact('customer','salesAgents'));
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
    $customers = CustomerInfo::all(); // همه مشتری‌ها برای انتخاب
    return view('Custumer.email.email-group', compact('customers'));
}
public function sendMessage(Request $request)
{
    dd($request->all());
    $request->validate([
        'customer_id' => 'required|exists:customer_infos,id',
        'message' => 'required|string|max:1000'
    ]);

    $customer = CustomerInfo::findOrFail($request->customer_id);
    // 

    Mail::raw($request->message, function ($message) use ($customer) {
        $message->to($customer->email)
                ->subject('پیام جدید از سامانه');
    });

    return redirect()->route('customers.index')->with('success', 'پیام ایمیل ارسال شد.');
}

public function showCustomerSelection()
    {
        $customers = CustomerInfo::all();
        return view('Custumer.select', compact('customers'));
    }
    public function showBulkMessageForm(Request $request)
    {
        $ids = $request->input('selected_customers', []);
        $customers = CustomerInfo::whereIn('id', $ids)->get();

        return view('Custumer.message_form', compact('customers', 'ids'));
    }
    public function sendBulkMessage(Request $request)
{
    $request->validate([
        'message' => 'required|string',
        'customer_ids' => 'required|array',
    ]);

    $customers = CustomerInfo::whereIn('id', $request->customer_ids)->get();

    foreach ($customers as $customer) {
        if ($customer->email) {
            Mail::to($customer->email)->send(new BulkMessageMail($customer, $request->message));
        }
    }

    return redirect()->route('customers.select')->with('success', 'ایمیل‌ها با قالب سفارشی ارسال شدند.');
}
    public function sendSingleMessage(Request $request)
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
public function exportCsv()
{
    $customers = CustomerInfo::all();

    $fileName = 'customers_' . date('Y_m_d_H_i_s') . '.csv';

    $headers = [
        "Content-type"        => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = [
        'نام شرکت', 'نوع شرکت', 'نام مسئول', 'ایمیل', 'آدرس', 'مدیر عامل',
        'بانک', 'یادداشت', 'شماره حساب', 'تلفن شرکت', 'تلفن همراه',
        'کد ملی', 'کد پستی', 'کد اقتصادی'
    ];

    $callback = function() use ($customers, $columns) {
        $file = fopen('php://output', 'w');
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // اضافه کردن BOM برای UTF-8

        fputcsv($file, $columns);

        foreach ($customers as $customer) {
            $row = [
                $customer->company_name,
                $customer->company_type,
                $customer->personal_name,
                $customer->email,
                $customer->address,
                $customer->ceo,
                $customer->bank,
                $customer->note,
                $customer->account_number,
                $customer->company_phone,
                $customer->mobile_phone,
                $customer->id_meli,
                $customer->postal_code,
                $customer->code_eghtesadi,
            ];
            fputcsv($file, $row);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function importForm()
{
    return view('Custumer.import');
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

            CustomerInfo::create([
                'company_name' => $record['نام شرکت'],
                'company_type' => $record['نوع شرکت'] ?? null,
                'personal_name' => $record['نام مسئول'],
                'email' => $record['ایمیل'],
                'address' => $record['آدرس'],
                'ceo' => $record['مدیر عامل'],
                'bank' => $record['بانک'],
                'note' => $record['یادداشت'] ?? null,
                'account_number' => $record['شماره حساب'],
                'company_phone' => $record['تلفن شرکت'],
                'mobile_phone' => $record['تلفن همراه'],
                'id_meli' => $record['کد ملی'],
                'postal_code' => $record['کد پستی'],
                'code_eghtesadi' => $record['کد اقتصادی'],
                'user_id' => auth()->id()
            ]);
            $records++;
        } catch (\Exception $e) {
            Log::error('خطا در ایمپورت ردیف: ' . $e->getMessage() . ' - داده: ' . implode(',', $row));
        }
    }

    return redirect()->route('customers.index')->with('success', $records . ' رکورد با موفقیت ایمپورت شد.');
}
    
}


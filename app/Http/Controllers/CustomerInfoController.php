<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use Illuminate\Http\Request;

class CustomerInfoController extends Controller
{
    public function create(){
        return view('Custumer.createcustomer');
    }
    public function store(Request $request){
        $validate = $request->validate([
            'company_name' => 'required',
            'company_type' => 'required',
            'personal_name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'ceo' => 'required',
            'bank' => 'required',
            'note' => 'required',
            'account_number' => 'required',
            'company_phone' => 'required',
            'mobile_phone' => 'required',
            'id_meli' => 'required',
            'postal_code' => 'required',
            'code_eghtesadi' => 'required',
        ]);
    
        // اضافه کردن user_id قبل از ایجاد
        $validate['user_id'] = auth()->id();
    
        CustomerInfo::create($validate);
    
        return redirect()->route('customers.create')->with('success', 'مشتری با موفقیت ثبت شد.');
}
    public function index(Request $request){
        $customers = CustomerInfo::latest()->paginate(15);
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
}}
// $table->id();
// $table->string('company_name');
// $table->string('company_type');
// $table->string('personal_name');
// $table->string('email');
// $table->string('ceo');
// $table->string('address');
// $table->string('bank');
// $table->text('note');
// $table->integer('account_number');
// $table->integer('company_phone');
// $table->integer('mobile_phone');
// $table->integer('postal_code');
// $table->integer('id_meli');
// $table->integer('code_eghtesadi');
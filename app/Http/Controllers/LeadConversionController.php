<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadConversionController extends Controller
{
    public function convert($id)
    {
        $lead = Lead::findOrFail($id);
    
        if ($lead->status === 'تبدیل به مشتری شد') {
            return redirect()->back()->with('error', 'این سرنخ قبلاً تبدیل شده است.');
        }
    
        // اگر ایمیل در لید وجود داشت، همونو بردار، در غیر این صورت ایمیل ساختگی بساز
        $email = $lead->email ?? 'lead_' . $lead->id . '@nomail.local';
    
        // ساخت مشتری با استفاده از اطلاعات موجود در لید
        $customer = CustomerInfo::create([
            'company_name'      => $lead->company ?? 'نامشخص',
            'company_type'      => 'نوع شرکت', // می‌تونی اینو از فرم بگیری
            'personal_name'     => $lead->name,
            'email'             => $email,
            'ceo'               => $lead->name,
            'address'           => 'نامشخص',
            'bank'              => 'نام بانک',
            'note'              => $lead->note,
            'account_number'    => '0000000000',
            'company_phone'     => $lead->phone,
            'mobile_phone'      => $lead->phone,
            'postal_code'       => '0000000000',
            'id_meli'           => '0000000000',
            'code_eghtesadi'    => '0000000000',
            'user_id'           => auth()->id(),
        ]);
    
        $lead->update(['status' => 'تبدیل به مشتری شد']);
    
        return redirect()->back()->with('success', 'سرنخ با موفقیت به مشتری تبدیل شد.');
    }
    
}

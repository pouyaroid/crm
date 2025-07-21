<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    protected $fillable = [
        'company_name',
        'company_type',
        'personal_name',
        'email',
        'address',
        'ceo',
        'bank',
        'note',
        'account_number',
        'company_phone',
        'mobile_phone',
        'id_meli',
        'postal_code',
        'code_eghtesadi',
        'user_id',
        'sales_agent_id',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function customers()
    {
        return $this->hasMany(CustomerInfo::class, 'sales_agent_id'); // فرض بر این است که فیلد `sales_agent_id` در جدول CustomerInfo وجود دارد
    }
    public function cases()
    {
        return $this->hasMany(CustomerCase::class, 'customer_id'); // 'customer_id' نام ستون کلید خارجی در جدول customer_cases
    }
}

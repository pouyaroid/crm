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
        'ceo',
        'address',
        'bank',
        'note',
        'account_number',
        'company_phone',
        'mobile_phone',
        'id_meli',
        'postal_code',
        'code_eghtesadi',
         'user_id',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}

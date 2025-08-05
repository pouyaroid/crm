<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCall extends Model
{
    protected $fillable = [
        'customer_info_id',
        'user_id',
        'title',
        'description',
        'called_at',
    ];
    public function customer()
{
    return $this->belongsTo(CustomerInfo::class, 'customer_info_id');
}

public function user()
{
    return $this->belongsTo(User::class);
}
}

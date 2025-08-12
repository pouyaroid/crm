<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Reminder extends Model
{
    protected $fillable = [
        'user_id',
        'remindable_id',
        'remindable_type',
        'title',
        'description',
        'remind_at',
        'is_notified',
    ];
    protected $casts = [
        'is_notified' => 'boolean',
        'remind_at' => 'datetime',
    ];
    public function remindable()
{
    return $this->morphTo();
}

public function user()
{
    return $this->belongsTo(User::class);
}
public function customer()
{
    // اگر remindable مربوط به CustomerCall باشه و در CustomerCall رابطه customerInfo تعریف شده باشه
    return $this->remindable ? $this->remindable->customerInfo : null;
}
public function getCustomer()
{
    return $this->remindable ? $this->remindable->customerInfo : null;
}
}

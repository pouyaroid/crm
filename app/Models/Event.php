<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'event_date',
        'end_date', // اضافه کردن فیلد تاریخ پایان
    ];

    // تعریف فیلدهای تاریخ برای تبدیل خودکار به Carbon
    protected $casts = [
        'event_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

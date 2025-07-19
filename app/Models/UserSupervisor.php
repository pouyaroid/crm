<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserSupervisor extends Model
{
    use HasFactory;

    protected $table = 'user_supervisors';  // اسم جدول دقیق

    protected $fillable = ['user_id', 'supervisor_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subordinates()
    {
        return $this->belongsToMany(User::class, 'user_supervisors', 'supervisor_id', 'user_id');
    }
    
    // سرپرستانی که این کاربر زیرمجموعه آن‌هاست (در صورت نیاز)
    public function supervisors()
    {
        return $this->belongsToMany(User::class, 'user_supervisors', 'user_id', 'supervisor_id');
    }
}


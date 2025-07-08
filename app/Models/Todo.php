<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'is_done',
        'user_id',
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'due_date' => 'datetime',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}

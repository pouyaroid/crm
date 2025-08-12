<?php

namespace App\Models;
use App\Models\LeadCall;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public function  leadCalls()
    {
        return $this->hasMany(LeadCall::class,'lead_id');
    }
    protected $fillable = [
        'name', 'phone', 'company', 'source', 'interest_level', 'note', 'status','user_id'
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}

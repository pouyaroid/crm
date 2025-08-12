<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadCall extends Model

{
    use HasFactory;
    protected $table = 'lead_calls';
    
    public function lead()
{
    return $this->belongsTo(Lead::class,'lead_id');
}
protected $fillable = [
    'lead_id',
    'call_summary',
    'notes',
    'call_time',
];
}

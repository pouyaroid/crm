<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCall extends Model
{
    public function lead()
{
    return $this->belongsTo(Lead::class);
}
protected $fillable = [
    'lead_id',
    'call_summary',
    'notes',
    'call_time',
];
}

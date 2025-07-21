<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCase extends Model
{
    protected $fillable = ['customer_id', 'title', 'description'];

    public function customer()
    {
        return $this->belongsTo(CustomerInfo::class);
    }

    public function documents()
    {
        return $this->hasMany(CaseDocument::class);
    }
}

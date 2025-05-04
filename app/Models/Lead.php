<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public function calls()
    {
        return $this->hasMany(LeadCall::class);
    }
    protected $fillable = [
        'name', 'phone', 'company', 'source', 'interest_level', 'note', 'status'
    ];
}

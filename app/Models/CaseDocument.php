<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseDocument extends Model
{
    protected $fillable = ['customer_case_id', 'file_type', 'file_path', 'uploaded_by'];

    public function customerCase()
    {
        return $this->belongsTo(CustomerCase::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintResponse extends Model
{
    protected $fillable = ['response'];
    public function complaint()
{
    return $this->belongsTo(Complaint::class);
}
}

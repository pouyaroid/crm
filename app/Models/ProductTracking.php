<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTracking extends Model
{
    protected $table = 'products_tracking';

    protected $fillable = [
        'product_code',
        'note',
        'status',
    ];
}

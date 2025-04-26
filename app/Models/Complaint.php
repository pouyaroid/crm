<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}
protected $fillable = [
    'user_id',
    'ordernumber',
    'title',
    'description',
    'image',
    'video_path',
    'status',
];
public function images()
{
    return $this->hasMany(ComplaintImage::class);
}
public function response()
{
    return $this->hasOne(ComplaintResponse::class);
}

}

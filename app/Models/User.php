<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    public function complaints(){
        return $this->hasMany(Complaint::class);
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
public function customers()
{
    return $this->hasMany(User::class, 'sales_agent_id');
}
public function salesAgent()
{
    return $this->belongsTo(User::class, 'sales_agent_id');
}
public function leads()
{
    return $this->hasMany(Lead::class);
}
public function todos()
{
    return $this->hasMany(Todo::class);
}
public function supervisors()
{
    return $this->belongsToMany(User::class, 'user_supervisors', 'user_id', 'supervisor_id');
}

public function subordinates()
{
    return $this->belongsToMany(User::class, 'user_supervisors', 'supervisor_id', 'user_id');
}}

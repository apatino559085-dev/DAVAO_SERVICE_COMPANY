<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name', 'email', 'password', 'address', 'role', 'is_active',
];

public function jobPosts()
{
    return $this->hasMany(JobPost::class);
}

public function applications()
{
    return $this->hasMany(Application::class);
}

public function isAdmin()    { return $this->role === 'admin'; }
public function isHR() { return $this->role === 'hr' || $this->role === 'staff' || $this->role === 'employer'; }
public function isApplicant(){ return $this->role === 'applicant'; }

public function getDisplayRoleAttribute()
{
    if ($this->isAdmin()) return 'System Administrator';
    if ($this->isHR()) return 'HR Admin';
    return 'Applicant';
}

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
}

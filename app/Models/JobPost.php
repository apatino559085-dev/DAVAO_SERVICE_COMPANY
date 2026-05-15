<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'user_id', 'title', 'company', 'logo_path', 'location', 'description', 'requirements', 'salary', 'type', 'expires_at', 'industry', 'is_terminated', 'terminated_at'
    ];

    protected $casts = [
        'expires_at' => 'date',
        'terminated_at' => 'datetime',
        'is_terminated' => 'boolean',
    ];

    /**
     * Scope to only include active (non-terminated) jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_terminated', false);
    }

    /**
     * Scope to only include terminated jobs.
     */
    public function scopeTerminated($query)
    {
        return $query->where('is_terminated', true);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
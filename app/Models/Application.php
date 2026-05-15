<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'job_post_id',
        'user_id',
        'cover_letter',
        'resume_path',
        'id_picture_path',
        'certificates_path',
        'status',
        'is_archived',
        'interview_at',
        'interview_location',
        'rating'
    ];

    protected $casts = [
        'interview_at' => 'datetime',
    ];

    public function jobPost()  { return $this->belongsTo(JobPost::class); }
    public function applicant(){ return $this->belongsTo(User::class, 'user_id'); }
}
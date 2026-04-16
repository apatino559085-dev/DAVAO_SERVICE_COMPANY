<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['job_post_id','user_id','cover_letter','status'];

    public function jobPost()  { return $this->belongsTo(JobPost::class); }
    public function applicant(){ return $this->belongsTo(User::class, 'user_id'); }
}
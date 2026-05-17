<?php
namespace App\Policies;

use App\Models\User;
use App\Models\JobPost;

class JobPostPolicy
{
    public function update(User $user, JobPost $job): bool
    {
        return $user->isAdmin() || $user->isHR() || $user->id === $job->user_id;
    }

    public function delete(User $user, JobPost $job): bool
    {
        return $user->isAdmin();
    }
}
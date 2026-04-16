<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPost;
use App\Models\Application;

class AdminController extends Controller
{
    public function dashboard()
    
    {
        $users     = User::latest()->paginate(5);
        $jobs      = JobPost::with('employer')->latest()->get();
        $appCount  = Application::count();
        return view('admin.dashboard', compact('users', 'jobs', 'appCount'));
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "User account has been {$status}.");
    }

    public function destroyJob(JobPost $job)
    {
        $job->delete();
        return back()->with('success', 'Job post deleted.');
    }
}
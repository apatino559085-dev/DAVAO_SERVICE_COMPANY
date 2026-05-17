<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users      = User::latest()->paginate(5);
        $jobs       = JobPost::with('employer')->active()->latest()->get();
        $appCount   = Application::count();
        $activities = ActivityLog::with('user')->latest()->limit(10)->get();

        // Stats for Charts
        $stats = [
            'pending'   => Application::where('status', 'pending')->count(),
            'interview' => Application::where('status', 'for interview')->count(),
            'approved'  => Application::where('status', 'approved')->count(),
            'rejected'  => Application::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('users', 'jobs', 'appCount', 'activities', 'stats'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'User Status Toggled',
            'description' => "Admin {$status} account for {$user->name}."
        ]);
        
        return back()->with('success', "User account has been {$status}.");
    }

    public function destroyJob(JobPost $job)
    {
        $title = $job->title;
        
        // Terminate instead of delete — move to archive
        $job->update([
            'is_terminated' => true,
            'terminated_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Job Terminated',
            'description' => "Admin terminated the role: {$title}."
        ]);

        return back()->with('success', "Job post \"{$title}\" has been terminated and moved to archive.");
    }

    public function archivedJobs()
    {
        $jobs = JobPost::with('employer')->withCount('applications')->terminated()->latest('terminated_at')->get();

        return view('admin.archived-jobs', compact('jobs'));
    }

    public function generateReport()
    {
        $jobs = JobPost::withCount('applications')->latest()->get();
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => JobPost::count(),
            'total_applications' => Application::count(),
            'pending'   => Application::where('status', 'pending')->count(),
            'interview' => Application::where('status', 'for interview')->count(),
            'approved'  => Application::where('status', 'approved')->count(),
            'rejected'  => Application::where('status', 'rejected')->count(),
        ];

        $pdf = Pdf::loadView('admin.report', compact('jobs', 'stats'));
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Report Generated',
            'description' => 'Admin downloaded the Monthly Hiring Report.'
        ]);

        return $pdf->download('DCS_Monthly_Hiring_Report.pdf');
    }
}
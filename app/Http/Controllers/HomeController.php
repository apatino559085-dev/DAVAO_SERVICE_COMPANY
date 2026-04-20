<?php
namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return view('landing');
        }

        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->isHR()) {
            $myJobs = JobPost::where('user_id', auth()->id())->latest()->get();
            $recentApplications = Application::whereIn('job_post_id', $myJobs->pluck('id'))
                ->with('applicant', 'jobPost')
                ->latest()
                ->take(5)
                ->get();
            
            return view('home', compact('myJobs', 'recentApplications'));
        }

        $jobs = JobPost::with('employer')->latest()->take(6)->get();
        return view('home', compact('jobs'));
    }
}
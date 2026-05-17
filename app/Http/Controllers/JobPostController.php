<?php
namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with('employer')->withCount('applications')->active()->latest();

        if ($request->has('industry') && $request->industry) {
            $query->where('industry', $request->industry);
        }

        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Hide jobs where the logged-in applicant has an active (non-rejected) application
        $user = auth()->user();
        if ($user && $user->role === 'applicant') {
            $activeJobIds = Application::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved', 'for interview'])
                ->pluck('job_post_id')
                ->toArray();

            if (!empty($activeJobIds)) {
                $query->whereNotIn('id', $activeJobIds);
            }
        }

        $jobs = $query->paginate(5)->withQueryString();
        
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'requirements'=> 'nullable|string',
            'salary'      => 'nullable|string|max:100',
            'type'        => 'required|in:full-time,part-time,remote,contract',

            'logo'        => 'nullable|image|max:2048',
            'expires_at'  => 'nullable|date|after:today',
            'industry'    => 'required|string',
        ]);

        $data['company'] = 'Davao Central Services Company';

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('company_logos', 'public');
        }

        $job = auth()->user()->jobPosts()->create($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Job Posted',
            'description' => "HR posted a new role: {$job->title}."
        ]);

        return redirect()->route('jobs.index')->with('success', 'Role created!');
    }

    public function show(JobPost $job)
    {
        $job->load('employer', 'applications');

        // Check if current user already has an application for this job
        $existingApplication = null;
        $user = auth()->user();
        if ($user && $user->role === 'applicant') {
            $existingApplication = Application::where('user_id', $user->id)
                ->where('job_post_id', $job->id)
                ->first();
        }

        return view('jobs.show', compact('job', 'existingApplication'));
    }

    public function edit(JobPost $job)
    {
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));   
    }

    public function update(Request $request, JobPost $job)
    {
        $this->authorize('update', $job);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'requirements'=> 'nullable|string',
            'salary'      => 'nullable|string|max:100',
            'type'        => 'required|in:full-time,part-time,remote,contract',

            'logo'        => 'nullable|image|max:2048',
            'expires_at'  => 'nullable|date',
            'industry'    => 'required|string',
        ]);

        $data['company'] = 'Davao Central Services Company';

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('company_logos', 'public');
        }

        $job->update($data);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Job Updated',
            'description' => "HR updated the role: {$job->title}."
        ]);

        return redirect()->route('jobs.index')->with('success', 'Role updated!');
    }

    public function destroy(JobPost $job)
    {
        $this->authorize('delete', $job);
        
        $job->update([
            'is_terminated' => true,
            'terminated_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Job Terminated',
            'description' => "User terminated the role: {$job->title}."
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job post terminated and moved to archive!');
    }

    public function myJobs(Request $request)
    {
        $user = auth()->user();
        $query = JobPost::withCount('applications')->active()->latest();

        // If not admin or HR, only show own jobs
        if (!$user->isAdmin() && $user->role !== 'hr') {
            $query->where('user_id', $user->id);
        }

        if ($request->has('industry') && $request->industry) {
            $query->where('industry', $request->industry);
        }

        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $jobs = $query->paginate(6)->withQueryString();
        return view('jobs.my', compact('jobs'));
    }
}
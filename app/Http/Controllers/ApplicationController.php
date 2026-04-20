<?php
namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Applicant: submit application
    public function store(Request $request, JobPost $job)
    {
        $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $exists = Application::where('job_post_id', $job->id)
            ->where('user_id', auth()->id())->exists();

        if ($exists) {
            return back()->with('error', 'You already applied for this job.');
        }

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'job_post_id'  => $job->id,
            'user_id'      => auth()->id(),
            'cover_letter' => $request->cover_letter,
            'resume_path'  => $resumePath,
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    // Applicant: view my applications
    public function myApplications()
    {
        $applications = auth()->user()->applications()->with('jobPost')->latest()->get();
        return view('applications.my', compact('applications'));
    }

    // Employer: view all applicants for a specific job
    public function jobApplicants(JobPost $job)
    {
        // Only the job owner or admin can see applicants
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $applications = $job->applications()->with('applicant')->latest()->get();
        return view('applications.job_applicants', compact('job', 'applications'));
    }

    // Employer: update application status (accept/reject) and ARCHIVE directly
    public function updateStatus(Request $request, Application $application)
    {
        $request->validate(['status' => 'required|in:accepted,rejected']);

        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $application->update([
            'status' => $request->status,
            'is_archived' => true
        ]);

        $statusLabel = ucfirst($request->status);
        return back()->with('success', "Application {$statusLabel} and moved to archive!");
    }

    // Employer: manual archive
    public function archive(Application $application)
    {
        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $application->update(['is_archived' => true]);
        return back()->with('success', "Application stashed to archive!");
    }

    // Employer: view ALL applications received across all jobs (NOT archived)
    public function receivedApplications()
    {
        $user = auth()->user();
        
        $query = Application::with(['jobPost', 'applicant'])
            ->where('is_archived', false)
            ->latest();

        if (!$user->isAdmin()) {
            $query->whereIn('job_post_id', function($q) use ($user) {
                $q->select('id')->from('job_posts')->where('user_id', $user->id);
            });
        }

        $applications = $query->get();

        return view('applications.received', compact('applications'));
    }

    // Employer: view ONLY archived applications
    public function archivedApplications(Request $request)
    {
        $user = auth()->user();
        
        $query = Application::with(['jobPost', 'applicant'])
            ->where('is_archived', true)
            ->latest();

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if (!$user->isAdmin()) {
            $query->whereIn('job_post_id', function($q) use ($user) {
                $q->select('id')->from('job_posts')->where('user_id', $user->id);
            });
        }

        $applications = $query->get();

        return view('applications.archived', compact('applications'));
    }
}
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
        $request->validate(['cover_letter' => 'nullable|string']);

        $exists = Application::where('job_post_id', $job->id)
            ->where('user_id', auth()->id())->exists();

        if ($exists) {
            return back()->with('error', 'You already applied for this job.');
        }

        Application::create([
            'job_post_id'  => $job->id,
            'user_id'      => auth()->id(),
            'cover_letter' => $request->cover_letter,
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

    // Employer: update application status (accept/reject)
    public function updateStatus(Request $request, Application $application)
    {
        $request->validate(['status' => 'required|in:accepted,rejected']);

        // Only the job owner or admin can update status
        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $application->update(['status' => $request->status]);

        $statusLabel = ucfirst($request->status);
        return back()->with('success', "Application {$statusLabel} successfully!");
    }

    // Employer: view ALL applications received across all jobs
    public function receivedApplications()
    {
        $user = auth()->user();
        
        $query = Application::with(['jobPost', 'applicant'])->latest();

        if (!$user->isAdmin()) {
            $query->whereIn('job_post_id', function($q) use ($user) {
                $q->select('id')->from('job_posts')->where('user_id', $user->id);
            });
        }

        $applications = $query->get();

        return view('applications.received', compact('applications'));
    }
}
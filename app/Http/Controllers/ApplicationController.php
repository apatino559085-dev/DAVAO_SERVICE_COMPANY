<?php
namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Applicant: submit application
    public function store(Request $request, JobPost $job)
    {
        $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'id_picture' => 'nullable|image|max:2048',
            'certificates' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:4096'
        ]);

        $exists = Application::where('job_post_id', $job->id)
            ->where('user_id', auth()->id())->exists();

        if ($exists) {
            return back()->with('error', 'You already applied for this role.');
        }

        $resumePath = $request->file('resume')->store('resumes', 'public');
        $idPicturePath = null;
        if ($request->hasFile('id_picture')) {
            $idPicturePath = $request->file('id_picture')->store('id_pictures', 'public');
        }
        $certificatesPath = null;
        if ($request->hasFile('certificates')) {
            $certificatesPath = $request->file('certificates')->store('certificates', 'public');
        }

        Application::create([
            'job_post_id'  => $job->id,
            'user_id'      => auth()->id(),
            'cover_letter' => $request->cover_letter,
            'resume_path'  => $resumePath,
            'id_picture_path' => $idPicturePath,
            'certificates_path' => $certificatesPath,
            'status'       => 'pending',
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Application Submitted',
            'description' => "Applicant submitted an application for {$job->title}."
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
        if ($job->user_id !== auth()->id() && !auth()->user()->isAdmin() && !auth()->user()->isHR()) {
            abort(403);
        }

        $applications = $job->applications()->with('applicant')->latest()->get();
        return view('applications.job_applicants', compact('job', 'applications'));
    }

    // Employer: update application status (accept/reject) and ARCHIVE directly
    public function updateStatus(Request $request, Application $application)
    {
        $request->validate(['status' => 'required|in:pending,for interview,approved,rejected']);

        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin() && !auth()->user()->isHR()) {
            abort(403);
        }

        $oldStatus = $application->status;
        $application->update([
            'status' => $request->status,
            'is_archived' => in_array($request->status, ['approved', 'rejected'])
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Status Updated',
            'description' => "HR updated application status for {$application->applicant->name} from {$oldStatus} to {$request->status}."
        ]);

        $statusLabel = ucfirst($request->status);
        $msg = "Application status updated to {$statusLabel}.";
        if ($application->is_archived) {
            $msg .= " Moved to archive.";
        }
        
        return back()->with('success', $msg);
    }

    // HR: schedule interview
    public function scheduleInterview(Request $request, Application $application)
    {
        $request->validate([
            'interview_at' => 'required|date',
            'interview_location' => 'required|string|max:255'
        ]);

        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin() && !auth()->user()->isHR()) {
            abort(403);
        }

        $application->update([
            'interview_at' => $request->interview_at,
            'interview_location' => $request->interview_location,
            'status' => 'for interview'
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Interview Scheduled',
            'description' => "HR scheduled an interview for {$application->applicant->name} on {$request->interview_at}."
        ]);

        return back()->with('success', "Interview scheduled and status set to 'For Interview'!");
    }

    // HR: rate applicant
    public function rateApplicant(Request $request, Application $application)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin() && !auth()->user()->isHR()) {
            abort(403);
        }

        $application->update([
            'rating' => $request->rating
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Applicant Rated',
            'description' => "HR rated applicant {$application->applicant->name} with {$request->rating} stars."
        ]);

        return back()->with('success', "Applicant rated successfully!");
    }

    // Employer: manual archive
    public function archive(Application $application)
    {
        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin() && !auth()->user()->isHR()) {
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

        if (!$user->isAdmin() && !$user->isHR()) {
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
        
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized. Only administrators can access the Archive.');
        }

        $query = Application::with(['jobPost', 'applicant'])
            ->where('is_archived', true)
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('job_title')) {
            $query->whereHas('jobPost', function($q) use ($request) {
                $q->where('title', $request->job_title);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('applicant', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!$user->isAdmin() && !$user->isHR()) {
            $query->whereIn('job_post_id', function($q) use ($user) {
                $q->select('id')->from('job_posts')->where('user_id', $user->id);
            });
        }

        $applications = $query->paginate(9);
        
        $jobTitles = JobPost::distinct()->pluck('title');

        return view('applications.archived', compact('applications', 'jobTitles'));
    }

    // Employer/HR: Undo archival/status decision
    public function undoStatus(Application $application)
    {
        $job = $application->jobPost;
        if (auth()->id() !== $job->user_id && !auth()->user()->isAdmin() && !auth()->user()->isHR()) {
            abort(403);
        }

        $application->update([
            'status' => 'pending',
            'is_archived' => false
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Decision Reversed',
            'description' => "HR undid the archival decision for {$application->applicant->name}."
        ]);

        return back()->with('success', "Application restored to 'Received Applications'. Status reset to Pending.");
    }
}
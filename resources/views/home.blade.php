@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@if(auth()->user()->isStaff())
    <!-- STAFF DASHBOARD -->
    <div style="margin-bottom: 40px;">
        <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Hiring Dashboard</h1>
        <div style="display: flex; gap: 20px; margin-top: 24px;">
            <div style="flex: 1; background: #6366f1; border-radius: 20px; padding: 24px; color: white;">
                <div style="font-size: 13px; font-weight: 700; opacity: 0.8; text-transform: uppercase;">Active Jobs</div>
                <div style="font-size: 32px; font-weight: 900; margin-top: 8px;">{{ $myJobs->count() }}</div>
            </div>
            <div style="flex: 1; background: #0f172a; border-radius: 20px; padding: 24px; color: white;">
                <div style="font-size: 13px; font-weight: 700; opacity: 0.8; text-transform: uppercase;">Total Applicants</div>
                <div style="font-size: 32px; font-weight: 900; margin-top: 8px;">{{ $recentApplications->count() }}</div>
            </div>
        </div>
    </div>

    <!-- RECENT APPLICANTS -->
    <div style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: 800; color: #0f172a;">Recent Applicants</h2>
            <a href="{{ route('applications.received') }}" style="color: #6366f1; font-size: 14px; font-weight: 700; text-decoration: none;">View All →</a>
        </div>
        
        <div style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden;">
            @forelse($recentApplications as $app)
            <div style="padding: 20px 28px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 16px; align-items: center;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #6366f1; font-weight: 900;">
                        {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size: 15px; font-weight: 800; color: #0f172a;">{{ $app->applicant->name }}</div>
                        <div style="font-size: 13px; color: #64748b; font-weight: 600;">Applied for <span style="color: #6366f1;">{{ $app->jobPost->title }}</span></div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 12px; font-weight: 700; color: #94a3b8;">{{ $app->created_at->diffForHumans() }}</span>
                    <a href="{{ route('applications.received') }}" style="background: #f8fafc; color: #334155; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; border: 1px solid #e2e8f0;">Review</a>
                </div>
            </div>
            @empty
            <div style="padding: 60px; text-align: center; color: #94a3b8;">
                No applicants yet.
            </div>
            @endforelse
        </div>
    </div>

    <!-- YOUR ACTIVE JOBS -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: 800; color: #0f172a;">Your Active Jobs</h2>
            <a href="{{ route('jobs.create') }}" style="background: #eef2ff; color: #6366f1; font-size: 13px; font-weight: 800; padding: 8px 16px; border-radius: 10px; text-decoration: none;">+ Post New</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            @foreach($myJobs as $job)
            <div style="background: white; border-radius: 20px; padding: 24px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $job->title }}</h3>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 13px; color: #64748b; font-weight: 600;">
                        <span>{{ $job->applications->count() }} Applicants</span>
                        <span>•</span>
                        <span>{{ $job->location }}</span>
                    </div>
                </div>
                <a href="{{ route('jobs.show', $job) }}" style="background: #0f172a; color: white; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none;">Details</a>
            </div>
            @endforeach
        </div>
    </div>

@else
    <!-- APPLICANT DASHBOARD (Basic for now) -->
    <!-- ... existing applicant home logic ... -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 900; color: #0f172a;">Recommended Jobs</h1>
    </div>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        @foreach($jobs as $job)
        <div style="background: white; border-radius: 20px; padding: 24px; border: 1px solid #eef2f7;">
            <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #6366f1; color: white; display: flex; align-items: center; justify-content: center; font-weight: 900;">{{ substr($job->company,0,1) }}</div>
                <div>
                    <h3 style="font-size: 15px; font-weight: 800;">{{ $job->title }}</h3>
                    <p style="font-size: 13px; color: #64748b;">{{ $job->company }}</p>
                </div>
            </div>
            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 14px; font-weight: 700; color: #0f172a;">{{ $job->salary }}</span>
                <a href="{{ route('jobs.show', $job) }}" style="color: #6366f1; font-weight: 700; text-decoration: none; font-size: 13px;">View Details</a>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
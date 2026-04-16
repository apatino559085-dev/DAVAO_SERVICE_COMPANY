@extends('layouts.app')
@section('title', 'Applicants — ' . $job->title)
@section('content')

<!-- Breadcrumb -->
<div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 28px;">
    <a href="{{ route('home') }}" style="color: #94a3b8; text-decoration: none;">Home</a>
    <span>›</span>
    <a href="{{ route('jobs.show', $job) }}" style="color: #94a3b8; text-decoration: none;">{{ Str::limit($job->title, 20) }}</a>
    <span>›</span>
    <span style="color: #0f172a;">Applicants</span>
</div>

<!-- Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Applicants</h1>
        <p style="font-size: 14px; color: #94a3b8; font-weight: 600; margin-top: 4px;">
            <span style="color: #6366f1; font-weight: 800;">{{ $applications->count() }}</span> people applied for
            <span style="color: #0f172a; font-weight: 800;">{{ $job->title }}</span> at {{ $job->company }}
        </p>
    </div>
    <a href="{{ route('jobs.show', $job) }}" style="background: #f1f5f9; color: #334155; text-decoration: none; padding: 10px 22px; border-radius: 12px; font-size: 13px; font-weight: 700;">
        ← Back to Job
    </a>
</div>

<!-- Applicant Cards -->
@forelse($applications as $app)
<div style="background: white; border-radius: 20px; padding: 28px; margin-bottom: 16px; border: 1px solid #eef2f7;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
        <!-- Applicant Info -->
        <div style="display: flex; align-items: center; gap: 16px; flex: 1;">
            <div style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #a855f7); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 20px; flex-shrink: 0;">
                {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $app->applicant->name }}</h2>
                <p style="font-size: 13px; color: #64748b; font-weight: 600;">{{ $app->applicant->email }}</p>
                <p style="font-size: 12px; color: #94a3b8; font-weight: 600; margin-top: 2px;">📍 {{ $app->applicant->address ?? 'No address' }} · Applied {{ $app->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <!-- Status + Actions -->
        <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
            @if($app->status === 'pending')
                <form method="POST" action="{{ route('applications.updateStatus', $app) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="accepted">
                    <button style="background: #059669; color: white; border: none; padding: 10px 22px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit;">
                        ✓ Accept
                    </button>
                </form>
                <form method="POST" action="{{ route('applications.updateStatus', $app) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button style="background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; padding: 10px 22px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit;">
                        ✕ Reject
                    </button>
                </form>
            @else
                <span style="padding: 8px 20px; border-radius: 100px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
                    {{ $app->status === 'accepted' ? 'background: #ecfdf5; color: #059669;' : 'background: #fef2f2; color: #ef4444;' }}">
                    {{ ucfirst($app->status) }}
                </span>
            @endif
        </div>
    </div>

    <!-- Cover Letter -->
    @if($app->cover_letter)
    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
        <p style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Cover Letter</p>
        <p style="font-size: 14px; color: #475569; line-height: 1.7; font-weight: 500; white-space: pre-line;">{{ $app->cover_letter }}</p>
    </div>
    @endif
</div>
@empty
<div style="text-align: center; padding: 80px 40px; background: white; border-radius: 24px; border: 2px dashed #e2e8f0;">
    <div style="font-size: 48px; margin-bottom: 16px;">📭</div>
    <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">No applicants yet</h3>
    <p style="font-size: 15px; color: #94a3b8; font-weight: 500;">Share your job post to attract candidates.</p>
</div>
@endforelse

@endsection

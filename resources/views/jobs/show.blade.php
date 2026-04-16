@extends('layouts.app')
@section('title', $job->title)
@section('content')

<div style="max-width: 900px; margin: 0 auto;">
    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 28px;">
        <a href="{{ route('home') }}" style="color: #94a3b8; text-decoration: none;">Home</a>
        <span>›</span>
        <a href="{{ route('jobs.index') }}" style="color: #94a3b8; text-decoration: none;">Jobs</a>
        <span>›</span>
        <span style="color: #0f172a;">{{ Str::limit($job->title, 25) }}</span>
    </div>

    <!-- Job Header Card -->
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; padding: 36px; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="width: 64px; height: 64px; border-radius: 20px; background: linear-gradient(135deg, #6366f1, #a855f7); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 26px; flex-shrink: 0;">
                    {{ strtoupper(substr($job->company, 0, 1)) }}
                </div>
                <div>
                    <h1 style="font-size: 26px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">{{ $job->title }}</h1>
                    <p style="font-size: 15px; color: #64748b; font-weight: 600;">{{ $job->company }}</p>
                    <div style="display: flex; align-items: center; gap: 14px; margin-top: 10px; flex-wrap: wrap;">
                        <span style="font-size: 13px; color: #64748b; font-weight: 600;">📍 {{ $job->location }}</span>
                        @if($job->salary)
                        <span style="font-size: 13px; color: #6366f1; font-weight: 700;">💰 {{ $job->salary }}</span>
                        @endif
                        <span style="font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 8px; text-transform: uppercase;
                            {{ $job->type === 'full-time' ? 'background: #ecfdf5; color: #059669;' :
                               ($job->type === 'remote' ? 'background: #eef2ff; color: #6366f1;' : 'background: #fefce8; color: #ca8a04;') }}">
                            {{ ucfirst($job->type) }}
                        </span>
                    </div>
                </div>
            </div>
            @auth
            @if(auth()->user()->isAdmin() || auth()->id() === $job->user_id)
            <div style="display: flex; gap: 12px; align-items: center;">
                <a href="{{ route('jobs.applicants', $job) }}" style="background: #6366f1; color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 800; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(99,102,241,0.25); transition: all 0.2s;" onmouseover="this.style.background='#4f46e5'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#6366f1'; this.style.transform='translateY(0)'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manage Applicants
                </a>
                <a href="{{ route('jobs.edit', $job) }}" style="background: white; border: 1px solid #e2e8f0; color: #64748b; text-decoration: none; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.borderColor='#ca8a04'; this.style.color='#ca8a04'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </a>
                <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Archive this position?')" style="display: inline;">
                    @csrf @method('DELETE')
                    <button style="background: white; border: 1px solid #e2e8f0; color: #64748b; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#ef4444'; this.style.color='#ef4444'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
            @endif
            @endauth
        </div>

        <!-- Stats Row -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 32px; padding-top: 28px; border-top: 1px solid #f1f5f9;">
            <div style="background: #f8fafc; padding: 20px; border-radius: 16px; text-align: center; border: 1px solid transparent;">
                <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Job Type</div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a; text-transform: capitalize;">{{ $job->type }}</div>
            </div>
            <div style="background: #f8fafc; padding: 20px; border-radius: 16px; text-align: center; border: 1px solid transparent;">
                <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Posted</div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $job->created_at->diffForHumans() }}</div>
            </div>

            @php
                $isOwner = auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $job->user_id);
            @endphp

            @if($isOwner)
            <a href="{{ route('jobs.applicants', $job) }}" 
               style="background: #eef2ff; padding: 20px; border-radius: 16px; text-align: center; border: 2px solid #c7d2fe; text-decoration: none; display: block; transition: all 0.2s;"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(99,102,241,0.15)'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="font-size: 11px; font-weight: 800; color: #6366f1; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Applicants</div>
                <div style="font-size: 16px; font-weight: 900; color: #4338ca; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    {{ $job->applications->count() }}
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </div>
            </a>
            @else
            <div style="background: #f8fafc; padding: 20px; border-radius: 16px; text-align: center; border: 1px solid transparent;">
                <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Applicants</div>
                <div style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $job->applications->count() }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Description -->
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; padding: 36px; margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">Job Description</h2>
        <p style="color: #475569; white-space: pre-line; line-height: 1.8; font-size: 15px; font-weight: 500;">{{ $job->description }}</p>
    </div>

    <!-- Apply Section -->
    @auth
    @if(auth()->user()->isApplicant())
    <div style="background: linear-gradient(135deg, #eef2ff, #faf5ff); border-radius: 24px; padding: 36px; border: 1px solid #e0e7ff;">
        <h3 style="font-size: 20px; font-weight: 800; color: #312e81; margin-bottom: 20px;">Apply for This Position</h3>
        <form method="POST" action="{{ route('applications.store', $job) }}">
            @csrf
            <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">
                Cover Letter <span style="color: #94a3b8;">(optional)</span>
            </label>
            <textarea name="cover_letter" rows="5"
                      style="width: 100%; border: 2px solid #c7d2fe; border-radius: 16px; padding: 16px; font-size: 15px; font-weight: 500; outline: none; background: white; resize: vertical; font-family: inherit;"
                      placeholder="Tell the staff why you're a great fit..."></textarea>
            <button type="submit"
                    style="margin-top: 16px; background: #6366f1; color: white; border: none; padding: 14px 32px; border-radius: 14px; font-size: 15px; font-weight: 800; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(99,102,241,0.3);">
                Submit Application
            </button>
        </form>
    </div>
    @endif
    @else
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; padding: 40px; text-align: center;">
        <p style="color: #64748b; font-size: 16px; font-weight: 600; margin-bottom: 20px;">You must be logged in as an applicant to apply.</p>
        <a href="{{ route('login') }}"
           style="background: #6366f1; color: white; text-decoration: none; padding: 14px 32px; border-radius: 14px; font-weight: 800; display: inline-block;">
            Log in to Apply
        </a>
    </div>
    @endauth
</div>
@endsection
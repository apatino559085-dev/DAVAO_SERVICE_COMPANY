@extends('layouts.app')
@section('title', $job->title)
@section('content')

<style>
    /* Premium Animations & Effects */
    body {
        background-color: #f8fafc;
    }
    
    .show-animate {
        animation: showIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
    }
    .show-animate:nth-child(1) { animation-delay: 0s; }
    .show-animate:nth-child(2) { animation-delay: 0.1s; }
    .show-animate:nth-child(3) { animation-delay: 0.2s; }
    
    @keyframes showIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-banner {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 100%);
        border-radius: 32px;
        padding: 48px;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 25px 50px -12px rgba(2, 44, 34, 0.4);
        margin-bottom: 32px;
    }

    .hero-banner::before {
        content: '';
        position: absolute; top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 70%);
        border-radius: 50%; pointer-events: none;
    }

    .info-tile {
        background: white;
        padding: 24px;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .info-tile:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.06);
        border-color: #fbbf24;
    }

    .icon-box {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }

    .apply-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2f7;
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
        position: sticky;
        top: 32px;
        overflow: hidden;
    }

    .apply-card-header {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: white;
        padding: 24px;
        text-align: center;
    }

    .custom-input {
        width: 100%; border: 2px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; 
        font-size: 14px; font-weight: 500; color: #0f172a; outline: none; background: #f8fafc; 
        transition: all 0.2s; font-family: inherit;
    }
    .custom-input:focus {
        border-color: #064e3b;
        background: white;
        box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.1);
    }

    .btn-apply {
        width: 100%; background: linear-gradient(135deg, #fbbf24, #f59e0b); 
        color: #022c22; border: none; padding: 16px; border-radius: 14px; 
        font-size: 16px; font-weight: 900; cursor: pointer; text-transform: uppercase; letter-spacing: 1px;
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3); transition: all 0.3s;
    }
    .btn-apply:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(245, 158, 11, 0.4);
    }

    .content-box {
        background: white; border-radius: 24px; padding: 40px; 
        border: 1px solid #eef2f7; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02);
    }
</style>

<div style="max-width: 1000px; margin: 0 auto; padding-bottom: 80px;">
    
    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 24px;">
        <a href="{{ route('home') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#94a3b8'">Home</a>
        <svg style="width: 14px; height: 14px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('jobs.index') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#94a3b8'">Job Listings</a>
        <svg style="width: 14px; height: 14px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span style="color: #0f172a; font-weight: 800;">{{ Str::limit($job->title, 25) }}</span>
    </div>

    <!-- Hero Banner -->
    <div class="show-animate hero-banner">
        <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 24px;">
            <div style="display: flex; gap: 24px; align-items: center;">
                @if($job->logo_path)
                <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: white; border: 3px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.2); flex-shrink: 0;">
                    <img src="{{ asset('storage/' . $job->logo_path) }}" alt="{{ $job->company }} Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                @else
                <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: white; border: 3px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.2); flex-shrink: 0;">
                    <img src="{{ asset('images/logo (2).png') }}" alt="Davao Central Services Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                @endif
                
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="background: rgba(251, 191, 36, 0.2); color: #fbbf24; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; border: 1px solid rgba(251, 191, 36, 0.3);">{{ $job->industry }}</span>
                        <span style="font-size: 13px; color: rgba(255,255,255,0.6); font-weight: 500;">Posted {{ $job->created_at->diffForHumans() }}</span>
                    </div>
                    <h1 style="font-size: 40px; font-weight: 900; margin-bottom: 8px; line-height: 1.1; letter-spacing: -1px;">{{ $job->title }}</h1>
                    <p style="font-size: 18px; color: #d1fae5; font-weight: 500; margin: 0;">{{ $job->company }} &mdash; 📍 {{ $job->location }}</p>
                </div>
            </div>

            @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isHR())
            <div style="display: flex; gap: 12px; align-items: center;">
                <a href="{{ route('jobs.applicants', $job) }}" style="background: #fbbf24; color: #022c22; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 800; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(251,191,36,0.3); transition: all 0.2s;" onmouseover="this.style.boxShadow='0 8px 20px rgba(251,191,36,0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 12px rgba(251,191,36,0.3)'; this.style.transform='translateY(0)'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manage Applicants ({{ $job->applications->count() }})
                </a>
                <a href="{{ route('jobs.edit', $job) }}" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </a>
            </div>
            @endif
            @endauth
        </div>
    </div>

    <!-- Quick Info Tiles -->
    <div class="show-animate" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px;">
        <!-- Compensation -->
        <div class="info-tile">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div class="icon-box" style="background: #ecfdf5; color: #059669;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Compensation</div>
                    <div style="font-size: 18px; font-weight: 900; color: #0f172a;">{{ $job->salary ?? 'Negotiable' }}</div>
                </div>
            </div>
        </div>

        <!-- Engagement -->
        <div class="info-tile">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div class="icon-box" style="background: #eff6ff; color: #2563eb;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Engagement</div>
                    <div style="font-size: 18px; font-weight: 900; color: #0f172a; text-transform: capitalize;">{{ $job->type }}</div>
                </div>
            </div>
        </div>

        <!-- Deadline -->
        <div class="info-tile" style="border-color: #ffedd5; background: #fff7ed;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div class="icon-box" style="background: #ffedd5; color: #ea580c;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 800; color: #c2410c; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Deadline</div>
                    <div style="font-size: 18px; font-weight: 900; color: #9a3412;">{{ $job->expires_at ? $job->expires_at->format('M d, Y') : 'Open Until Filled' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Split -->
    <div class="show-animate" style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 32px;">
        
        <!-- Left Column: Description -->
        <div class="content-box">
            <h2 style="font-size: 22px; font-weight: 900; color: #0f172a; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; border-bottom: 2px solid #f1f5f9; padding-bottom: 16px;">
                <div style="width: 32px; height: 32px; background: #064e3b; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fbbf24;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                About The Role
            </h2>
            <div style="color: #334155; white-space: pre-line; line-height: 1.8; font-size: 16px; font-weight: 400;">
                {{ $job->description }}
            </div>
        </div>

        <!-- Right Column: Apply Form -->
        <div>
            @auth
                @if(auth()->user()->isApplicant())
                    @if(isset($existingApplication) && $existingApplication)
                    {{-- Already Applied — Show Status Tracker --}}
                    <div class="apply-card">
                        <div class="apply-card-header" style="
                            {{ $existingApplication->status === 'approved' ? 'background: linear-gradient(135deg, #059669, #047857);' : '' }}
                            {{ $existingApplication->status === 'rejected' ? 'background: linear-gradient(135deg, #dc2626, #b91c1c);' : '' }}
                            {{ $existingApplication->status === 'for interview' ? 'background: linear-gradient(135deg, #2563eb, #1d4ed8);' : '' }}
                        ">
                            <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 4px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                                @if($existingApplication->status === 'pending')
                                    ⏳ Application Submitted
                                @elseif($existingApplication->status === 'for interview')
                                    📅 Interview Scheduled
                                @elseif($existingApplication->status === 'approved')
                                    🎉 You're Hired!
                                @elseif($existingApplication->status === 'rejected')
                                    Application Not Selected
                                @endif
                            </h3>
                            <p style="font-size: 13px; color: rgba(255,255,255,0.7); font-weight: 500;">Applied {{ $existingApplication->created_at->diffForHumans() }}</p>
                        </div>
                        <div style="padding: 32px;">
                            {{-- Status Timeline --}}
                            <div style="display: flex; flex-direction: column; gap: 0;">
                                {{-- Step 1: Applied --}}
                                <div style="display: flex; gap: 16px; align-items: flex-start;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #059669; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">✓</div>
                                        <div style="width: 2px; height: 32px; background: {{ in_array($existingApplication->status, ['for interview', 'approved']) ? '#059669' : '#e2e8f0' }};"></div>
                                    </div>
                                    <div style="padding-top: 4px;">
                                        <p style="font-size: 14px; font-weight: 800; color: #0f172a;">Application Submitted</p>
                                        <p style="font-size: 12px; color: #64748b; font-weight: 500;">{{ $existingApplication->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                                {{-- Step 2: Under Review --}}
                                <div style="display: flex; gap: 16px; align-items: flex-start;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; {{ $existingApplication->status === 'pending' ? 'background: #fbbf24; animation: pulse 2s infinite;' : (in_array($existingApplication->status, ['for interview', 'approved']) ? 'background: #059669;' : 'background: #ef4444;') }} display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                                            {{ $existingApplication->status === 'pending' ? '•' : ($existingApplication->status === 'rejected' ? '✕' : '✓') }}
                                        </div>
                                        <div style="width: 2px; height: 32px; background: {{ in_array($existingApplication->status, ['for interview', 'approved']) ? '#059669' : '#e2e8f0' }};"></div>
                                    </div>
                                    <div style="padding-top: 4px;">
                                        <p style="font-size: 14px; font-weight: 800; color: #0f172a;">Under Review</p>
                                        <p style="font-size: 12px; color: #64748b; font-weight: 500;">
                                            {{ $existingApplication->status === 'pending' ? 'Awaiting HR review...' : ($existingApplication->status === 'rejected' ? 'Application was not selected' : 'Review completed') }}
                                        </p>
                                    </div>
                                </div>
                                {{-- Step 3: Interview / Decision --}}
                                <div style="display: flex; gap: 16px; align-items: flex-start;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; {{ $existingApplication->status === 'for interview' ? 'background: #2563eb; animation: pulse 2s infinite;' : ($existingApplication->status === 'approved' ? 'background: #059669;' : 'background: #e2e8f0;') }} display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                                            {{ $existingApplication->status === 'approved' ? '✓' : ($existingApplication->status === 'for interview' ? '📅' : '•') }}
                                        </div>
                                        <div style="width: 2px; height: 32px; background: {{ $existingApplication->status === 'approved' ? '#059669' : '#e2e8f0' }};"></div>
                                    </div>
                                    <div style="padding-top: 4px;">
                                        <p style="font-size: 14px; font-weight: 800; color: {{ in_array($existingApplication->status, ['for interview', 'approved']) ? '#0f172a' : '#94a3b8' }};">Interview</p>
                                        <p style="font-size: 12px; color: #64748b; font-weight: 500;">
                                            @if($existingApplication->status === 'for interview' && $existingApplication->interview_at)
                                                Scheduled: {{ $existingApplication->interview_at->format('M d, Y g:i A') }}
                                            @elseif($existingApplication->status === 'approved')
                                                Interview completed
                                            @else
                                                Pending decision
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                {{-- Step 4: Final --}}
                                <div style="display: flex; gap: 16px; align-items: flex-start;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; {{ $existingApplication->status === 'approved' ? 'background: #059669;' : 'background: #e2e8f0;' }} display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;">
                                            {{ $existingApplication->status === 'approved' ? '🎉' : '•' }}
                                        </div>
                                    </div>
                                    <div style="padding-top: 4px;">
                                        <p style="font-size: 14px; font-weight: 800; color: {{ $existingApplication->status === 'approved' ? '#059669' : '#94a3b8' }};">
                                            {{ $existingApplication->status === 'approved' ? 'Hired!' : 'Final Decision' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Status-specific message --}}
                            <div style="margin-top: 24px; padding: 16px; border-radius: 16px;
                                {{ $existingApplication->status === 'pending' ? 'background: #fffbeb; border: 1px solid #fde68a;' : '' }}
                                {{ $existingApplication->status === 'approved' ? 'background: #ecfdf5; border: 1px solid #a7f3d0;' : '' }}
                                {{ $existingApplication->status === 'rejected' ? 'background: #fef2f2; border: 1px solid #fecaca;' : '' }}
                                {{ $existingApplication->status === 'for interview' ? 'background: #eff6ff; border: 1px solid #bfdbfe;' : '' }}
                            ">
                                <p style="font-size: 13px; font-weight: 600; line-height: 1.6;
                                    {{ $existingApplication->status === 'pending' ? 'color: #92400e;' : '' }}
                                    {{ $existingApplication->status === 'approved' ? 'color: #065f46;' : '' }}
                                    {{ $existingApplication->status === 'rejected' ? 'color: #991b1b;' : '' }}
                                    {{ $existingApplication->status === 'for interview' ? 'color: #1e40af;' : '' }}
                                ">
                                    @if($existingApplication->status === 'pending')
                                        Your application is currently being reviewed by our HR team. You will be notified once a decision has been made.
                                    @elseif($existingApplication->status === 'for interview')
                                        Congratulations! You have been shortlisted for an interview. Please check your details above for the schedule.
                                    @elseif($existingApplication->status === 'approved')
                                        🎉 Congratulations! You have been approved for this position. Welcome to the Davao Central Services family!
                                    @elseif($existingApplication->status === 'rejected')
                                        Thank you for your interest. Unfortunately, your application was not selected at this time. Keep exploring other opportunities!
                                    @endif
                                </p>
                            </div>

                            <a href="{{ route('applications.my') }}" style="display: block; text-align: center; margin-top: 20px; background: #f1f5f9; color: #0f172a; padding: 14px; border-radius: 12px; font-size: 14px; font-weight: 800; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                                View My Applications →
                            </a>
                        </div>
                    </div>
                    @else
                    {{-- No application yet — Show Apply Form --}}
                    <div class="apply-card">
                        <div class="apply-card-header">
                            <h3 style="font-size: 22px; font-weight: 900; margin-bottom: 4px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <svg style="width: 24px; height: 24px; color: #fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Apply Now
                            </h3>
                            <p style="font-size: 13px; color: #94a3b8; font-weight: 500;">Submit your application directly to HR</p>
                        </div>
                        <div style="padding: 32px;">
                            <form method="POST" action="{{ route('applications.store', $job) }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div style="margin-bottom: 24px;">
                                    <label style="display: block; font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Message (Optional)</label>
                                    <textarea name="cover_letter" rows="3" class="custom-input" placeholder="Why are you a good fit for this role?"></textarea>
                                </div>

                                <div style="margin-bottom: 32px;">
                                    <label style="display: block; font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Resume (PDF) <span style="color: #ef4444;">*</span></label>
                                    <div style="position: relative;">
                                        <input type="file" name="resume" accept=".pdf" required class="custom-input" style="padding: 10px; background: white; cursor: pointer;">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn-apply">
                                    Submit Application
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endif
            @else
                <!-- Guest View -->
                <div class="apply-card" style="text-align: center; padding: 48px 32px;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fefce8, #fef3c7); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.1);">
                        <svg style="width: 40px; height: 40px; color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 style="font-size: 24px; font-weight: 900; color: #0f172a; margin-bottom: 12px; letter-spacing: -0.5px;">Ready to apply?</h3>
                    <p style="color: #64748b; font-size: 15px; font-weight: 500; margin-bottom: 32px; line-height: 1.6;">Create an account or log in to submit your application and track your status.</p>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="{{ route('register') }}" style="background: linear-gradient(135deg, #022c22, #064e3b); color: #fbbf24; text-decoration: none; padding: 14px 28px; border-radius: 14px; font-weight: 900; font-size: 15px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 10px 25px rgba(2, 44, 34, 0.2); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">Create Account</a>
                        <a href="{{ route('login') }}" style="background: white; border: 2px solid #e2e8f0; color: #0f172a; text-decoration: none; padding: 14px 28px; border-radius: 14px; font-weight: 800; font-size: 15px; transition: all 0.3s;" onmouseover="this.style.borderColor='#0f172a'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'">Log In</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title', $job->title)
@section('content')

<div style="max-width: 900px; margin: 0 auto; padding-bottom: 60px;">
    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #94a3b8; margin-bottom: 24px;">
        <a href="{{ route('home') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#94a3b8'">Home</a>
        <svg style="width: 14px; height: 14px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('jobs.index') }}" style="color: #94a3b8; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#94a3b8'">Browse Jobs</a>
        <svg style="width: 14px; height: 14px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span style="color: #0f172a; font-weight: 700;">{{ Str::limit($job->title, 25) }}</span>
    </div>

    <!-- Job Header Card -->
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; padding: 40px; margin-bottom: 24px; position: relative; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02)">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: linear-gradient(135deg, rgba(99,102,241,0.06), rgba(168,85,247,0.06)); border-radius: 50%; pointer-events: none;"></div>
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 24px; position: relative; z-index: 1;">
            <div style="display: flex; gap: 24px; align-items: center;">
                @if($job->logo_path)
                <img src="{{ asset('storage/' . $job->logo_path) }}" alt="{{ $job->company }} Logo" style="width: 72px; height: 72px; border-radius: 20px; object-fit: contain; background: white; border: 1px solid #e2e8f0; padding: 4px; flex-shrink: 0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                @else
                <div style="width: 72px; height: 72px; border-radius: 20px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #0f172a; font-weight: 900; font-size: 32px; flex-shrink: 0;">
                    {{ strtoupper(substr($job->company, 0, 1)) }}
                </div>
                @endif
                <div>
                    <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; margin-bottom: 8px; line-height: 1.2; letter-spacing: -0.5px;">{{ $job->title }}</h1>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <span style="font-size: 16px; color: #475569; font-weight: 600;">{{ $job->company }}</span>
                        <span style="width: 4px; height: 4px; background: #cbd5e1; border-radius: 50%;"></span>
                        <span style="font-size: 14px; color: #94a3b8; font-weight: 500;">Posted {{ $job->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            
            @auth
            @if(auth()->user()->isAdmin() || auth()->id() === $job->user_id)
            <div style="display: flex; gap: 12px; align-items: center;">
                <a href="{{ route('jobs.applicants', $job) }}" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(99,102,241,0.25); transition: all 0.2s;" onmouseover="this.style.boxShadow='0 8px 20px rgba(99,102,241,0.3)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow='0 4px 12px rgba(99,102,241,0.25)'; this.style.transform='translateY(0)'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manage Applicants
                </a>
                <a href="{{ route('jobs.edit', $job) }}" title="Edit Job" style="background: white; border: 1px solid #e2e8f0; color: #64748b; text-decoration: none; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.borderColor='#ca8a04'; this.style.color='#ca8a04'; this.style.background='#fefce8'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'; this.style.background='white'">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </a>
                <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Archive this position?')" style="display: inline;">
                    @csrf @method('DELETE')
                    <button title="Archive Job" style="background: white; border: 1px solid #e2e8f0; color: #64748b; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#ef4444'; this.style.color='#ef4444'; this.style.background='#fef2f2'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'; this.style.background='white'">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
            @endif
            @endauth
        </div>

        <!-- Tags Row -->
        <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px;">
            <div style="background: #f8fafc; padding: 8px 16px; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                <svg style="width: 16px; height: 16px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span style="font-size: 14px; font-weight: 600; color: #334155;">{{ $job->location }}</span>
            </div>
            <div style="background: #f8fafc; padding: 8px 16px; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                <svg style="width: 16px; height: 16px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span style="font-size: 14px; font-weight: 600; color: #334155; text-transform: capitalize;">{{ $job->type }}</span>
            </div>
            @if($job->industry)
            <div style="background: #f8fafc; padding: 8px 16px; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                <svg style="width: 16px; height: 16px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span style="font-size: 14px; font-weight: 600; color: #334155;">{{ $job->industry }}</span>
            </div>
            @endif
            <div style="background: #f0fdf4; padding: 8px 16px; border-radius: 10px; display: flex; align-items: center; gap: 8px;">
                <svg style="width: 16px; height: 16px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span style="font-size: 14px; font-weight: 700; color: #059669;">{{ $job->salary ?? 'Competitive Salary' }}</span>
            </div>
        </div>

        @php
            $isOwner = auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $job->user_id);
        @endphp

        <!-- Applicants Stat -->
        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Applications Received</p>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="display: flex;">
                        @foreach(range(1, min(3, max(1, $job->applications->count()))) as $i)
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; border: 2px solid white; margin-left: {{ $loop->first ? '0' : '-12px' }}; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: #64748b;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        @endforeach
                    </div>
                    <span style="font-size: 20px; font-weight: 800; color: #0f172a;">{{ $job->applications->count() }}</span>
                </div>
            </div>
            
            @if($isOwner)
            <a href="{{ route('jobs.applicants', $job) }}" style="color: #6366f1; font-weight: 700; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 4px; transition: color 0.2s;" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#6366f1'">
                Review Applications
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>
    </div>

    <!-- Description Details -->
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; padding: 40px; margin-bottom: 32px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02)">
        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg style="width: 20px; height: 20px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            About The Role
        </h2>
        <div style="color: #475569; white-space: pre-line; line-height: 1.8; font-size: 15px; font-weight: 500;">
            {{ $job->description }}
        </div>
    </div>

    <!-- Apply Section -->
    @auth
    @if(auth()->user()->isApplicant())
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">
        <div style="background: #f8fafc; padding: 24px 40px; border-bottom: 1px solid #eef2f7;">
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <svg style="width: 20px; height: 20px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                Apply for this Position
            </h3>
        </div>
        <div style="padding: 40px;">
            <form method="POST" action="{{ route('applications.store', $job) }}" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #334155; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        Cover Letter <span style="color: #94a3b8; font-weight: 600; text-transform: none;">(optional)</span>
                    </label>
                    <textarea name="cover_letter" rows="5"
                              style="width: 100%; border: 2px solid #e2e8f0; border-radius: 16px; padding: 16px; font-size: 15px; font-weight: 500; color: #0f172a; outline: none; background: #fafbfc; resize: vertical; font-family: inherit; transition: all 0.2s;"
                              onfocus="this.style.borderColor='#6366f1'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(99,102,241,0.1)'"
                              onblur="this.style.borderColor='#e2e8f0'; this.style.background='#fafbfc'; this.style.boxShadow='none'"
                              placeholder="Tell the hiring manager why you're a great fit for this role..."></textarea>
                </div>

                <div style="margin-bottom: 32px;">
                    <label style="display: block; font-size: 13px; font-weight: 800; color: #334155; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        Resume (PDF, DOC) <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                           style="width: 100%; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 24px; font-size: 15px; font-weight: 600; color: #475569; outline: none; background: #f8fafc; transition: all 0.2s; cursor: pointer;">
                    @error('resume')<div style="color: #ef4444; font-size: 13px; font-weight: 600; margin-top: 8px;">{{ $message }}</div>@enderror
                </div>
                
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit"
                            style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; border: none; padding: 14px 32px; border-radius: 12px; font-size: 15px; font-weight: 800; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(99,102,241,0.3); transition: all 0.2s; display: flex; align-items: center; gap: 8px;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(99,102,241,0.4)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(99,102,241,0.3)'">
                        Submit Application
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @else
    <div style="background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(168,85,247,0.05)); border-radius: 24px; border: 1px dashed #cbd5e1; padding: 48px 40px; text-align: center;">
        <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <svg style="width: 32px; height: 32px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Ready to apply?</h3>
        <p style="color: #64748b; font-size: 15px; font-weight: 500; margin-bottom: 24px;">Create an account or log in as an applicant to submit your application.</p>
        <div style="display: flex; gap: 16px; justify-content: center;">
            <a href="{{ route('login') }}" style="background: #0f172a; color: white; text-decoration: none; padding: 12px 28px; border-radius: 12px; font-weight: 700; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.background='#1e293b'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#0f172a'; this.style.transform='translateY(0)'">Log In</a>
            <a href="{{ route('register') }}" style="background: white; border: 1px solid #e2e8f0; color: #0f172a; text-decoration: none; padding: 12px 28px; border-radius: 12px; font-weight: 700; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'">Create Account</a>
        </div>
    </div>
    @endauth
</div>
@endsection
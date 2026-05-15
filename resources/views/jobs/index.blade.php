@extends('layouts.app')
@section('title', 'Browse Job Vacancies')
@section('content')

<style>
    .hero-banner {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 100%);
        border-radius: 32px; padding: 64px; margin-bottom: 48px; color: white;
        box-shadow: 0 20px 40px rgba(2, 44, 34, 0.2);
        position: relative; overflow: hidden;
    }
    .hero-banner::after {
        content: ''; position: absolute; top: -50%; right: -10%; width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(251,191,36,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .job-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 32px; margin-bottom: 40px; }
    .job-card {
        background: white; border-radius: 28px; padding: 32px; border: 1px solid #f1f5f9;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex; flex-direction: column; height: 100%;
    }
    .job-card:hover { transform: translateY(-8px); box-shadow: 0 30px 60px rgba(0,0,0,0.06); border-color: #cbd5e1; }
    
    .btn-view {
        background: #022c22; color: white; padding: 12px 24px; border-radius: 12px;
        text-decoration: none; font-weight: 800; font-size: 13px; transition: all 0.2s;
        text-align: center;
    }
    .btn-view:hover { background: #064e3b; box-shadow: 0 8px 16px rgba(2, 44, 34, 0.2); }

    .custom-pagination { display: flex; justify-content: center; gap: 12px; margin-top: 40px; }
    .page-btn { 
        padding: 12px 24px; border-radius: 100px; background: white; border: 1.5px solid #e2e8f0; 
        color: #022c22; font-weight: 800; text-decoration: none; font-size: 14px; transition: all 0.2s;
    }
    .page-btn:hover:not(.disabled) { border-color: #022c22; transform: translateY(-2px); }
    .page-btn.disabled { color: #cbd5e1; cursor: not-allowed; }
    .page-btn.active { background: #022c22; color: white; border-color: #022c22; }
</style>

<div class="hero-banner">
    <div style="position: relative; z-index: 1;">
        <div style="background: rgba(255,255,255,0.1); display: inline-block; padding: 6px 16px; border-radius: 100px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px;">⚡ HIRING NOW</div>
        <h1 style="font-size: 52px; font-weight: 900; letter-spacing: -2px; margin-bottom: 16px; line-height: 1;">Find Your Next Role</h1>
        <p style="font-size: 18px; color: rgba(255,255,255,0.7); max-width: 500px;">Join the leading services company in Davao. Explore our open positions and start your career today.</p>
    </div>
    @auth
        @if(auth()->user()->isAdmin() || auth()->user()->isHR())
            <a href="{{ route('jobs.create') }}" style="position: absolute; right: 64px; bottom: 64px; background: #fbbf24; color: #022c22; padding: 16px 32px; border-radius: 16px; text-decoration: none; font-weight: 800; font-size: 15px; box-shadow: 0 10px 20px rgba(251,191,36,0.3); z-index: 2;">Post a Job</a>
        @endif
    @endauth
</div>

<div class="job-grid">
    @foreach($jobs as $job)
    <div class="job-card">
        <div style="display: flex; gap: 28px; align-items: center; margin-bottom: 28px;">
            @if($job->logo_path)
                <div style="width: 90px; height: 90px; border-radius: 50%; border: 3px solid #f1f5f9; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.08); flex-shrink: 0;">
                    <img src="{{ asset('storage/' . $job->logo_path) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @else
                <div style="width: 90px; height: 90px; border-radius: 50%; border: 3px solid #f1f5f9; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.08); flex-shrink: 0;">
                    <img src="{{ asset('images/logo%20(2).png') }}" alt="DCS Logo" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endif
            <div>
                <h3 style="font-size: 20px; font-weight: 900; color: #022c22;">{{ $job->title }}</h3>
                <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px;">{{ $job->industry }} • {{ ucfirst($job->type) }}</div>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 24px; border-radius: 20px; border: 1px solid #f1f5f9; margin-bottom: auto;">
            <div style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Monthly Salary</div>
            <div style="font-size: 26px; font-weight: 900; color: #022c22;">₱{{ number_format((float)$job->salary) }}</div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 28px;">
            <span style="font-size: 11px; font-weight: 700; color: #cbd5e1;">Posted {{ $job->created_at->diffForHumans() }}</span>
            <a href="{{ route('jobs.show', $job) }}" class="btn-view">Details</a>
        </div>
    </div>
    @endforeach
</div>

@if($jobs->hasPages())
<div class="custom-pagination">
    @if ($jobs->onFirstPage())
        <span class="page-btn disabled">Previous</span>
    @else
        <a href="{{ $jobs->previousPageUrl() }}" class="page-btn">Previous</a>
    @endif

    @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
        <a href="{{ $url }}" class="page-btn {{ $page == $jobs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
    @endforeach

    @if ($jobs->hasMorePages())
        <a href="{{ $jobs->nextPageUrl() }}" class="page-btn">Next</a>
    @else
        <span class="page-btn disabled">Next</span>
    @endif
</div>
@endif

@endsection
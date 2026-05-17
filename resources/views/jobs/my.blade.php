@extends('layouts.app')
@section('title', 'Manage Company Roles')
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
        <div style="background: rgba(255,255,255,0.1); display: inline-block; padding: 6px 16px; border-radius: 100px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px;">⚡ INTERNAL PANEL</div>
        <h1 style="font-size: 52px; font-weight: 900; letter-spacing: -2px; margin-bottom: 16px; line-height: 1;">Manage Company Roles</h1>
        <p style="font-size: 18px; color: rgba(255,255,255,0.7); max-width: 500px;">Davao Central Services Company — Track applicants, update details, and manage active vacancies.</p>
    </div>
    <a href="{{ route('jobs.create') }}" style="position: absolute; right: 64px; bottom: 64px; background: #fbbf24; color: #022c22; padding: 16px 32px; border-radius: 16px; text-decoration: none; font-weight: 800; font-size: 15px; box-shadow: 0 10px 20px rgba(251,191,36,0.3); z-index: 2;">Post a Job</a>
</div>

<!-- FILTER BAR -->
<div style="background: white; border-radius: 28px; padding: 24px 32px; border: 1px solid #f1f5f9; box-shadow: 0 20px 40px rgba(0,0,0,0.03); margin-bottom: 48px;">
    <form action="{{ route('jobs.my') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 24px; align-items: flex-end;">
        <div style="flex: 2; min-width: 250px;">
            <label style="display: block; font-size: 11px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; padding-left: 4px;">Search Location</label>
            <div style="position: relative;">
                <input type="text" name="location" value="{{ request('location') }}" placeholder="City, Region, or Remote..." style="width: 100%; padding: 16px 20px; border: 2px solid #f8fafc; border-radius: 16px; font-size: 14px; font-weight: 600; outline: none; background: #fcfdfe; transition: all 0.3s;" onfocus="this.style.borderColor='var(--primary)'; this.style.background='white';">
            </div>
        </div>
        
        <div style="flex: 1; min-width: 180px;">
            <label style="display: block; font-size: 11px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; padding-left: 4px;">Industry</label>
            <select name="industry" style="width: 100%; padding: 16px 20px; border: 2px solid #f8fafc; border-radius: 16px; font-size: 14px; font-weight: 600; outline: none; background: #fcfdfe; cursor: pointer; transition: all 0.3s;" onfocus="this.style.borderColor='var(--primary)';" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <option value="Technology" {{ request('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                <option value="Administration" {{ request('industry') == 'Administration' ? 'selected' : '' }}>Administration</option>
                <option value="Security" {{ request('industry') == 'Security' ? 'selected' : '' }}>Security</option>
                <option value="Maintenance" {{ request('industry') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 180px;">
            <label style="display: block; font-size: 11px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; padding-left: 4px;">Job Type</label>
            <select name="type" style="width: 100%; padding: 16px 20px; border: 2px solid #f8fafc; border-radius: 16px; font-size: 14px; font-weight: 600; outline: none; background: #fcfdfe; cursor: pointer; transition: all 0.3s;" onfocus="this.style.borderColor='var(--primary)';" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                <option value="remote" {{ request('type') == 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contractual</option>
            </select>
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <button type="submit" style="background: var(--primary); color: white; border: none; padding: 16px 32px; border-radius: 16px; font-weight: 800; font-size: 14px; cursor: pointer; transition: all 0.2s; box-shadow: 0 10px 20px rgba(2, 44, 34, 0.1);">Apply Filters</button>
            @if(request()->anyFilled(['location', 'industry', 'type']))
                <a href="{{ route('jobs.my') }}" style="color: #ef4444; text-decoration: none; font-size: 13px; font-weight: 800; white-space: nowrap;">Reset Clear</a>
            @endif
        </div>
    </form>
</div>

<div class="job-grid">
    @forelse($jobs as $job)
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

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #f8fafc; padding: 24px; border-radius: 20px; border: 1px solid #f1f5f9; margin-bottom: auto;">
            <div>
                <div style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Monthly Salary</div>
                <div style="font-size: 22px; font-weight: 900; color: #022c22;">₱{{ number_format((float)$job->salary) }}</div>
            </div>
            <div style="border-left: 1px solid #e2e8f0; padding-left: 16px;">
                <div style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Candidates</div>
                <div style="font-size: 22px; font-weight: 900; color: #ef4444;">{{ $job->applications_count }}</div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 28px; gap: 12px;">
            <span style="font-size: 11px; font-weight: 700; color: #cbd5e1; white-space: nowrap;">Posted {{ $job->created_at->diffForHumans() }}</span>
            <div style="display: flex; gap: 8px; align-items: center;">
                <a href="{{ route('jobs.show', $job) }}" title="View Public Page" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: white; border: 1.5px solid #e2e8f0; border-radius: 12px; color: #64748b; transition: all 0.2s;" onmouseover="this.style.color='#022c22'; this.style.borderColor='#022c22'; this.style.background='#f0fdf4'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.background='white'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                <a href="{{ route('jobs.edit', $job) }}" title="Edit Job" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: white; border: 1.5px solid #e2e8f0; border-radius: 12px; color: #64748b; transition: all 0.2s;" onmouseover="this.style.color='#ca8a04'; this.style.borderColor='#fde047'; this.style.background='#fefce8'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.background='white'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </a>
                <a href="{{ route('jobs.applicants', $job) }}" class="btn-view" style="padding: 10px 16px; font-size: 12px;">Applicants</a>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; background: white; border-radius: 28px; padding: 64px 32px; text-align: center; border: 1px solid #f1f5f9;">
        <div style="width: 60px; height: 60px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <svg style="width: 28px; height: 28px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        </div>
        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">No matching roles found</h3>
        <p style="font-size: 14px; color: #64748b; font-weight: 500; margin-bottom: 24px;">Start by posting a job or adjust your filters.</p>
        <a href="{{ route('jobs.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #fbbf24; color: #022c22; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 800;">
            Post a Job
        </a>
    </div>
    @endforelse
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

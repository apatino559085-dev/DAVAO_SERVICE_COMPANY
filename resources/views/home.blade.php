@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
    /* CHADA Premium Design System */
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
        --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        --gradient-primary: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --gradient-success: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        --gradient-dark: linear-gradient(135deg, #0f172a 0%, #334155 100%);
    }

    .chada-header {
        position: relative;
        padding: 40px;
        border-radius: 24px;
        background: var(--gradient-primary);
        color: white;
        margin-bottom: 40px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
    }
    
    .chada-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .chada-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chada-title {
        font-size: 36px;
        font-weight: 900;
        letter-spacing: -1px;
        margin-bottom: 8px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .chada-subtitle {
        font-size: 16px;
        font-weight: 500;
        opacity: 0.9;
    }

    .btn-chada {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 14px 28px;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .btn-chada:hover {
        background: white;
        color: #6366f1;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* Glassmorphic Stat Cards */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 48px;
    }

    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 32px;
        display: flex;
        align-items: center;
        gap: 24px;
        box-shadow: var(--glass-shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(31, 38, 135, 0.1);
        border-color: rgba(99, 102, 241, 0.3);
    }

    .stat-icon {
        width: 72px;
        height: 72px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        box-shadow: inset 0 2px 4px rgba(255,255,255,0.5);
    }

    .stat-icon.primary {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4f46e5;
    }

    .stat-icon.success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #059669;
    }

    .stat-value {
        font-size: 48px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-label {
        font-size: 14px;
        font-weight: 800;
        color: #64748b;
        letter-spacing: 1px;
    }

    /* Modern Lists */
    .section-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .view-all-link {
        color: #6366f1;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: gap 0.2s;
    }

    .view-all-link:hover {
        gap: 10px;
    }

    .list-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #eef2f7;
        margin-bottom: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .list-card:hover {
        border-color: #c7d2fe;
        box-shadow: 0 12px 24px rgba(99,102,241,0.08);
        transform: scale(1.01);
    }

    .applicant-item {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }
    
    .applicant-item:last-child { border-bottom: none; }
    .applicant-item:hover { background: #f8fafc; padding-left: 24px; }

    /* Job Grid (Applicant View) */
    .job-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }

    .job-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 32px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
    }

    .job-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 4px;
        background: var(--gradient-primary);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .job-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(99,102,241,0.12);
        border-color: white;
    }

    .job-card:hover::after { opacity: 1; }

    .company-logo-placeholder {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 900;
        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
    }

    .tag {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .tag i { color: #6366f1; }

    .btn-apply {
        background: #0f172a;
        color: white;
        border-radius: 12px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }

    .btn-apply:hover {
        background: var(--gradient-primary);
        box-shadow: 0 8px 20px rgba(99,102,241,0.3);
        transform: translateY(-2px);
    }
</style>

@if(auth()->user()->isHR())
    <!-- STAFF DASHBOARD -->
    <div class="chada-header">
        <div class="chada-header-content">
            <div>
                <h1 class="chada-title">Davao Central Services Company</h1>
                <p class="chada-subtitle">Manage open roles and review applicants for each position.</p>
            </div>
            <a href="{{ route('jobs.create') }}" class="btn-chada">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Role
            </a>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $myJobs->count() }}</div>
                <div class="stat-label">ACTIVE ROLES</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $totalAppCount }}</div>
                <div class="stat-label">TOTAL APPLICANTS</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 32px;">
        <!-- ACTIVE ROLES -->
        <div>
            <div class="section-title">
                Job Listings
                <a href="{{ route('jobs.index') }}" class="view-all-link">View All Listings <span>→</span></a>
            </div>
            
            <div style="display: flex; flex-direction: column;">
                @forelse($myJobs->take(3) as $job)
                <div class="list-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div>
                            <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">{{ $job->title }}</h3>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="tag">
                                    <svg width="14" height="14" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $job->location }}
                                </div>
                                <div class="tag">
                                    <svg width="14" height="14" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    {{ $job->type }}
                                </div>
                            </div>
                        </div>
                        <span style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe); color: #4f46e5; padding: 8px 16px; border-radius: 12px; font-size: 14px; font-weight: 800; box-shadow: 0 4px 10px rgba(79, 70, 229, 0.1);">
                            {{ $job->applications->count() }} Applicants
                        </span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                        <span style="font-size: 13px; font-weight: 600; color: #94a3b8;">Posted {{ $job->created_at->diffForHumans() }}</span>
                        <a href="{{ route('jobs.show', $job) }}" style="color: #4f46e5; font-size: 14px; font-weight: 800; text-decoration: none;">Manage Role →</a>
                    </div>
                </div>
                @empty
                <div style="background: rgba(255,255,255,0.5); border-radius: 20px; padding: 48px; border: 2px dashed #cbd5e1; text-align: center;">
                    <br><br><p style="font-size: 16px; color: #64748b; font-weight: 600;">No active roles yet. Time to add positions!</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- RECENT APPLICANTS -->
        <div>
            <div class="section-title">
                New Arrivals
                <a href="{{ route('applications.received') }}" class="view-all-link">See All <span>→</span></a>
            </div>
            
            <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                @forelse($recentApplications->take(4) as $app)
                <div class="applicant-item">
                    <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 16px;">
                        <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #f8fafc, #e2e8f0); color: #0f172a; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 900; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                            {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $app->applicant->name }}</div>
                            <div style="font-size: 12px; font-weight: 600; color: #94a3b8;">Applied {{ $app->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div style="background: #f8fafc; padding: 12px 16px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Role Idea</div>
                            <div style="font-size: 13px; font-weight: 700; color: #334155;">{{ $app->jobPost->title }}</div>
                        </div>
                        <a href="{{ route('applications.received') }}" style="background: white; color: #6366f1; border: 1px solid #e2e8f0; padding: 6px 16px; border-radius: 8px; font-size: 12px; font-weight: 800; text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">Review</a>
                    </div>
                </div>
                @empty
                <div style="padding: 48px; text-align: center;">
                    <div style="font-size: 14px; font-weight: 600; color: #64748b;">Inbox zero! Share your jobs to get applicants.</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

@else
    <!-- APPLICANT DASHBOARD -->
    <div class="chada-header" style="background: var(--gradient-dark);">
        <div class="chada-header-content" style="flex-direction: column; text-align: center; gap: 24px;">
            <div>
                <h1 style="font-size: 48px; font-weight: 900; letter-spacing: -2px; margin-bottom: 12px; text-shadow: 0 4px 10px rgba(0,0,0,0.3);">Davao Central Services Company</h1>
                <p style="font-size: 18px; font-weight: 500; color: #cbd5e1; max-width: 600px; margin: 0 auto;">Explore available roles within the company and apply for the position that fits your skills.</p>
            </div>
        </div>
    </div>

    <div class="section-title" style="justify-content: center; margin-bottom: 40px; font-size: 32px;">
        Open Roles
    </div>

    <div class="job-grid">
        @foreach($jobs->take(6) as $job)
        <div class="job-card">
            <div style="display: flex; gap: 20px; margin-bottom: 24px; align-items: flex-start;">
                @if($job->logo_path)
                <img src="{{ asset('storage/' . $job->logo_path) }}" alt="{{ $job->company }}" style="width: 64px; height: 64px; border-radius: 18px; object-fit: contain; background: white; border: 1px solid #e2e8f0; padding: 4px; box-shadow: 0 8px 16px rgba(0,0,0,0.05);">
                @else
                <div class="company-logo-placeholder">
                    {{ substr($job->company,0,1) }}
                </div>
                @endif
                <div>
                    <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin-bottom: 6px; line-height: 1.2;">{{ $job->title }}</h3>
                    <p style="font-size: 15px; color: #64748b; font-weight: 700;">Davao Central Services Company</p>
                </div>
            </div>
            
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 32px;">
                <div class="tag">
                    <svg width="16" height="16" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $job->location }}
                </div>
                <div class="tag" style="background: #eef2ff; color: #6366f1;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $job->type }}
                </div>
            </div>

            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <div style="font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px;">Salary range</div>
                    <div style="font-size: 18px; font-weight: 900; color: #0f172a;">{{ $job->salary }}</div>
                </div>
                <a href="{{ route('jobs.show', $job) }}" class="btn-apply">View Role</a>
            </div>
        </div>
        @endforeach
    </div>
    
    @if($jobs->count() > 6)
    <div style="text-align: center; margin-top: 56px;">
        <a href="{{ route('jobs.index') }}" style="display: inline-flex; align-items: center; gap: 12px; background: white; border: 2px solid #e2e8f0; color: #0f172a; font-size: 16px; font-weight: 800; padding: 16px 40px; border-radius: 16px; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor='#0f172a'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'">
        View All Listings
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4-4m4-4H3"/></svg>
        </a>
    </div>
    @endif
    <!-- CORE VALUES / ABOUT SECTION -->
    <div style="margin-top: 80px; padding-top: 40px; border-top: 1px solid #e2e8f0;">
        <div class="section-title" style="justify-content: center; margin-bottom: 40px; font-size: 28px;">
            Our Foundations
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
            <!-- Opportunities -->
            <button onclick="openChadaModal('opps')" style="background: white; border: 1px solid #eef2f7; padding: 32px; border-radius: 24px; text-align: center; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#6366f1'; this.style.boxShadow='0 12px 24px rgba(99,102,241,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#eef2f7'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.02)'">
                <div style="width: 56px; height: 56px; background: #eef2ff; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #6366f1;">
                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #1e293b;">Opportunities</h3>
            </button>

            <!-- The Company -->
            <button onclick="openChadaModal('company')" style="background: white; border: 1px solid #eef2f7; padding: 32px; border-radius: 24px; text-align: center; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#a855f7'; this.style.boxShadow='0 12px 24px rgba(168,85,247,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#eef2f7'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.02)'">
                <div style="width: 56px; height: 56px; background: #f5f3ff; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #a855f7;">
                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #1e293b;">The Company</h3>
            </button>

            <!-- Our Vision -->
            <button onclick="openChadaModal('vision')" style="background: white; border: 1px solid #eef2f7; padding: 32px; border-radius: 24px; text-align: center; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#10b981'; this.style.boxShadow='0 12px 24px rgba(16,185,129,0.08)'" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#eef2f7'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.02)'">
                <div style="width: 56px; height: 56px; background: #ecfdf5; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #10b981;">
                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #1e293b;">Our Vision</h3>
            </button>
        </div>
    </div>
@endif

<!-- MODAL CONTAINER -->
<div id="chadaModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; padding: 20px; animation: modalFadeIn 0.3s ease;">
    <div style="background: white; width: 100%; max-width: 500px; border-radius: 32px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
        <!-- Close button -->
        <button onclick="closeChadaModal()" style="position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; border-radius: 50%; background: #f8fafc; border: none; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b'">
            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div style="padding: 40px;">
            <div id="modalIcon" style="width: 64px; height: 64px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; font-size: 28px;">
            </div>
            <h2 id="modalTitle" style="font-size: 28px; font-weight: 900; color: #0f172a; margin-bottom: 16px; letter-spacing: -0.5px;"></h2>
            <div id="modalBody" style="font-size: 16px; color: #64748b; line-height: 1.7; font-weight: 500;">
            </div>
            
            <button onclick="closeChadaModal()" style="margin-top: 32px; width: 100%; background: #0f172a; color: white; padding: 16px; border-radius: 16px; font-size: 15px; font-weight: 800; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#1e293b'" onmouseout="this.style.background='#0f172a'">
                Got it, thanks!
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<script>
    const modalData = {
        opps: {
            title: 'Opportunities',
            icon: '⚡',
            color: '#eef2ff',
            textColor: '#6366f1',
            text: 'Discover a world of possibilities with Davao Central Services Company. Your next big career move starts here.'
        },
        company: {
            title: 'The Company',
            icon: '🏢',
            color: '#f5f3ff',
            textColor: '#a855f7',
            text: 'Davao Central Services Company is dedicated to excellence and building a professional work environment for all its staff.'
        },
        vision: {
            title: 'Our Vision',
            icon: '👁️',
            color: '#ecfdf5',
            textColor: '#10b981',
            text: 'To empower every Davaoeño with the tools to find meaningful work and help local businesses grow through the power of digital connection and community-driven technology.'
        }
    };

    function openChadaModal(key) {
        const data = modalData[key];
        const modal = document.getElementById('chadaModal');
        const iconDiv = document.getElementById('modalIcon');
        
        document.getElementById('modalTitle').innerText = data.title;
        document.getElementById('modalBody').innerText = data.text;
        iconDiv.innerText = data.icon;
        iconDiv.style.background = data.color;
        iconDiv.style.color = data.textColor;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeChadaModal() {
        document.getElementById('chadaModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('chadaModal');
        if (event.target == modal) {
            closeChadaModal();
        }
    }
</script>

@endsection
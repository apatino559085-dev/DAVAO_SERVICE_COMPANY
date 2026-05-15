@extends('layouts.app')
@section('title', 'My Applications')
@section('content')

<style>
    .my-app-card {
        animation: appCardIn 0.4s ease-out both;
    }
    @keyframes appCardIn {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .my-app-card:nth-child(1) { animation-delay: 0.05s; }
    .my-app-card:nth-child(2) { animation-delay: 0.1s; }
    .my-app-card:nth-child(3) { animation-delay: 0.15s; }
    .my-app-card:nth-child(4) { animation-delay: 0.2s; }
    .my-app-card:nth-child(5) { animation-delay: 0.25s; }

    .status-pill {
        padding: 7px 18px; border-radius: 100px; font-size: 11px;
        font-weight: 800; text-transform: uppercase; letter-spacing: 1px;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .status-pending { background: linear-gradient(135deg, #fefce8, #fef9c3); color: #a16207; border: 1px solid rgba(161,98,7,0.15); }
    .status-interview { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #2563eb; border: 1px solid rgba(37,99,235,0.15); }
    .status-approved { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669; border: 1px solid rgba(5,150,105,0.15); }
    .status-rejected { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #dc2626; border: 1px solid rgba(220,38,38,0.15); }

    .stat-card {
        background: white; border-radius: 20px; padding: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
    }

    .app-card-enhanced {
        background: white; border-radius: 20px; padding: 0;
        margin-bottom: 16px; border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    .app-card-enhanced:hover {
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
        transform: translateY(-3px);
        border-color: #cbd5e1;
    }

    .progress-bar-bg {
        height: 4px; background: #f1f5f9; border-radius: 100px; overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%; border-radius: 100px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<div style="max-width: 900px; margin: 0 auto;">

    <!-- Premium Header -->
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 28px; padding: 40px; margin-bottom: 32px; color: white; position: relative; overflow: hidden; box-shadow: 0 20px 40px -12px rgba(15, 23, 42, 0.3);">
        <div style="position: absolute; top: -50%; right: -15%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 60%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30%; left: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 60%); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 1;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 100px; font-size: 11px; font-weight: 900; color: #fbbf24; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Application Tracker
            </div>
            <h1 style="font-size: 32px; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px;">My Applications</h1>
            <p style="font-size: 15px; font-weight: 500; color: #94a3b8; max-width: 500px;">Track your career journey — every application, interview, and outcome in one place.</p>
        </div>
    </div>

    <!-- Application Cards -->
    @forelse($applications as $app)
    @php
        $progressPercent = match($app->status) {
            'pending' => 25,
            'for interview' => 60,
            'approved' => 100,
            'rejected' => 100,
            default => 0
        };
        $progressColor = match($app->status) {
            'pending' => '#f59e0b',
            'for interview' => '#3b82f6',
            'approved' => '#10b981',
            'rejected' => '#ef4444',
            default => '#e2e8f0'
        };
    @endphp
    <div class="my-app-card app-card-enhanced">
        <!-- Progress Bar at Top -->
        <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width: {{ $progressPercent }}%; background: {{ $progressColor }};"></div>
        </div>

        <div style="padding: 28px;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 18px; flex: 1;">
                    <!-- Company Logo -->
                    <div style="width: 52px; height: 52px; border-radius: 50%; overflow: hidden; background: white; border: 2px solid #f1f5f9; box-shadow: 0 4px 10px rgba(0,0,0,0.06); flex-shrink: 0;">
                        <img src="{{ asset('images/logo (2).png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                        <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                            <a href="{{ route('jobs.show', $app->jobPost) }}" style="color: inherit; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#059669'" onmouseout="this.style.color='#0f172a'">{{ $app->jobPost->title }}</a>
                        </h2>
                        <p style="font-size: 13px; color: #64748b; font-weight: 600;">Davao Central Services · 📍 {{ $app->jobPost->location }}</p>
                        <p style="font-size: 11px; color: #cbd5e1; font-weight: 600; margin-top: 4px;">Applied {{ $app->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 8px;">
                    <span class="status-pill {{ $app->status === 'pending' ? 'status-pending' : ($app->status === 'for interview' ? 'status-interview' : ($app->status === 'approved' ? 'status-approved' : 'status-rejected')) }}">
                        @if($app->status === 'pending') ⏳ @elseif($app->status === 'for interview') 📅 @elseif($app->status === 'approved') ✓ @else ✕ @endif
                        {{ $app->status === 'for interview' ? 'Interview' : ucfirst($app->status) }}
                    </span>
                    
                    @if($app->interview_at)
                    <div style="font-size: 11px; font-weight: 700; color: #2563eb; background: #eff6ff; padding: 5px 12px; border-radius: 8px; border: 1px solid #dbeafe;">
                        📅 {{ $app->interview_at->format('M d @ h:i A') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Interview Info Bar -->
            @if($app->status === 'for interview' && $app->interview_at)
            <div style="margin-top: 20px; padding: 16px 20px; background: linear-gradient(135deg, #eff6ff, #f0f9ff); border-radius: 14px; border: 1px solid #dbeafe; font-size: 13px; color: #1e40af; font-weight: 600;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 16px; height: 16px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Interview Location: <span style="font-weight: 800;">{{ $app->interview_location ?? 'TBA' }}</span>
                </div>
            </div>
            @endif

            <!-- Approval Celebration -->
            @if($app->status === 'approved')
            <div style="margin-top: 20px; padding: 16px 20px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-radius: 14px; border: 1px solid #a7f3d0; font-size: 13px; color: #065f46; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                🎉 Congratulations! You have been approved for this position. Welcome aboard!
            </div>
            @endif

            <!-- Rejection Note -->
            @if($app->status === 'rejected')
            <div style="margin-top: 20px; padding: 16px 20px; background: #fef2f2; border-radius: 14px; border: 1px solid #fecaca; font-size: 13px; color: #991b1b; font-weight: 600;">
                This application was not selected. Don't worry — <a href="{{ route('jobs.index') }}" style="color: #dc2626; font-weight: 800;">explore more opportunities →</a>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 80px 40px; background: white; border-radius: 24px; border: 2px dashed #e2e8f0;">
        <div style="font-size: 48px; margin-bottom: 16px;">📋</div>
        <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">No applications yet</h3>
        <p style="font-size: 15px; color: #94a3b8; font-weight: 500; margin-bottom: 20px;">Start browsing jobs and submit your first application.</p>
        <a href="{{ route('jobs.index') }}" style="background: linear-gradient(135deg, #064e3b, #10b981); color: white; text-decoration: none; padding: 14px 32px; border-radius: 14px; font-weight: 800; display: inline-block; box-shadow: 0 8px 20px rgba(6,78,59,0.2); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            Browse Jobs →
        </a>
    </div>
    @endforelse
</div>

@endsection
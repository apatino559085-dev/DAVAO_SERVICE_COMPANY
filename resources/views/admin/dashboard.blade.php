@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

<style>
    /* Super Premium Dashboard Design */
    :root {
        --dash-bg: #f3f4f6; /* soft modern gray */
    }
    body { background-color: var(--dash-bg) !important; }
    
    .bento-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(255,255,255,0.8);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .bento-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Subtle inner glow */
    .bento-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 24px;
        padding: 2px;
        background: linear-gradient(135deg, rgba(255,255,255,0.8), rgba(255,255,255,0));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }
    
    /* Premium Header */
    .premium-header {
        display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;
    }
    .header-title {
        font-size: 36px; font-weight: 900; letter-spacing: -1.5px;
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.1;
    }
    .header-subtitle {
        font-size: 15px; color: #64748b; font-weight: 500; margin-top: 8px;
    }
    
    /* Stat Value */
    .stat-number {
        font-size: 42px; font-weight: 900; letter-spacing: -2px; color: #0f172a; line-height: 1;
    }
    
    .sparkline {
        width: 100%; height: 40px; margin-top: 16px;
    }
    
    /* Custom Table */
    .modern-table { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
    .modern-table th { color: #94a3b8; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 0 20px 12px; border-bottom: 2px solid #f1f5f9; text-align: left;}
    .modern-table td { background: white; padding: 20px; transition: all 0.2s; }
    .modern-table tr td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .modern-table tr td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .modern-table tbody tr { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .modern-table tbody tr:hover td { background: #f8fafc; transform: scale(1.01); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }

</style>

<div class="premium-header">
    <div>
        <div class="header-title">System Overview</div>
        <div class="header-subtitle">Real-time metrics for Davao Central Services</div>
    </div>
    <div style="display: flex; gap: 16px; align-items: center;">
        <a href="{{ route('admin.report') }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #022c22, #064e3b); color: #fbbf24; padding: 10px 24px; border-radius: 100px; font-size: 14px; font-weight: 800; text-decoration: none; box-shadow: 0 4px 12px rgba(2,44,34,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Generate PDF Report
        </a>
        <div style="display: flex; gap: 12px; align-items: center; background: white; padding: 10px 20px; border-radius: 100px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.02);">
            <div style="width: 10px; height: 10px; background: #10b981; border-radius: 50%; box-shadow: 0 0 12px #10b981; animation: pulse 2s infinite;"></div>
            <span style="font-size: 14px; font-weight: 800; color: #334155;">System Online</span>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 24px;">
    <!-- Stat 1 -->
    <div class="bento-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="color: #64748b; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Total Users</div>
                <div class="stat-number">{{ $users->total() }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #eff6ff, #dbeafe); display: flex; align-items: center; justify-content: center; color: #2563eb; box-shadow: 0 4px 10px rgba(59,130,246,0.15);">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <svg class="sparkline" viewBox="0 0 100 20" preserveAspectRatio="none">
            <path d="M0 20 L 20 15 L 40 18 L 60 5 L 80 10 L 100 2" fill="none" stroke="#3b82f6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    
    <!-- Stat 2 -->
    <div class="bento-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="color: #64748b; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Active Jobs</div>
                <div class="stat-number">{{ $jobs->count() }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); display: flex; align-items: center; justify-content: center; color: #059669; box-shadow: 0 4px 10px rgba(16,185,129,0.15);">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
        <svg class="sparkline" viewBox="0 0 100 20" preserveAspectRatio="none">
            <path d="M0 10 L 20 12 L 40 5 L 60 15 L 80 8 L 100 4" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <!-- Stat 3 -->
    <div class="bento-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="color: #64748b; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Applications</div>
                <div class="stat-number">{{ $appCount }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #fffbeb, #fef3c7); display: flex; align-items: center; justify-content: center; color: #d97706; box-shadow: 0 4px 10px rgba(245,158,11,0.15);">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <svg class="sparkline" viewBox="0 0 100 20" preserveAspectRatio="none">
            <path d="M0 15 L 20 5 L 40 10 L 60 2 L 80 8 L 100 1" fill="none" stroke="#f59e0b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 24px;">
    <!-- Chart -->
    <div class="bento-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div style="font-size: 18px; font-weight: 900; color: #0f172a;">Application Status</div>
        </div>
        <div style="height: 250px; position: relative;">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <!-- Overview Bar -->
    <div class="bento-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div style="font-size: 18px; font-weight: 900; color: #0f172a;">Platform Activity</div>
        </div>
        <div style="height: 250px; position: relative;">
            <canvas id="overviewChart"></canvas>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 40px;">
    <!-- Jobs Table -->
    <div class="bento-card" style="padding: 32px; overflow-x: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <div style="font-size: 20px; font-weight: 900; color: #0f172a;">Active Job Listings</div>
                <div style="font-size: 14px; color: #64748b; font-weight: 500; margin-top: 4px;">Currently open positions on the platform</div>
            </div>
            <a href="{{ route('jobs.create') }}" style="background: linear-gradient(135deg, #0f172a, #334155); color: white; padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 800; text-decoration: none; box-shadow: 0 4px 12px rgba(15,23,42,0.2); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(15,23,42,0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(15,23,42,0.2)';">+ New Job Listing</a>
        </div>

        <table class="modern-table">
            <thead>
                <tr>
                    <th>Role Details</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #0f172a; border: 1px solid #e2e8f0;">
                                {{ substr($job->company, 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('jobs.show', $job) }}" style="font-size: 15px; font-weight: 800; color: #0f172a; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#0f172a'">{{ $job->title }}</a>
                                <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-top: 2px;">ID: #{{ str_pad($job->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 800; color: #334155; font-size: 14px;">{{ $job->company }}</div>
                        <div style="color: #94a3b8; font-size: 12px; font-weight: 600; margin-top: 2px;">Posted by {{ $job->employer->name }}</div>
                    </td>
                    <td>
                        <span style="padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
                            {{ $job->type === 'Full-time' ? 'background: #ecfdf5; color: #059669;' :
                               ($job->type === 'Part-time' ? 'background: #fffbeb; color: #d97706;' :
                               ($job->type === 'Remote' ? 'background: #eff6ff; color: #3b82f6;' : 'background: #f1f5f9; color: #475569;')) }}">
                            {{ $job->type }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" onsubmit="return confirm('Terminate this job posting?')">
                            @csrf @method('DELETE')
                            <button style="background: white; border: 1px solid #fecaca; color: #dc2626; font-size: 13px; font-weight: 800; cursor: pointer; padding: 10px 18px; border-radius: 10px; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);" onmouseover="this.style.background='#fef2f2'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='white'; this.style.transform='translateY(0)';">Terminate</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8; font-weight: 600;">No active job listings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Activity Logs -->
    <div class="bento-card" style="padding: 32px;">
        <div style="margin-bottom: 28px;">
            <div style="font-size: 20px; font-weight: 900; color: #0f172a;">Recent Activity</div>
            <div style="font-size: 14px; color: #64748b; font-weight: 500; margin-top: 4px;">System event timeline</div>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            @forelse($activities->take(6) as $activity)
            <div style="display: flex; gap: 16px; position: relative;">
                @if(!$loop->last)
                <div style="position: absolute; left: 19px; top: 40px; bottom: -24px; width: 2px; background: #f1f5f9; z-index: 0;"></div>
                @endif
                <div style="width: 40px; height: 40px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid #f8fafc; box-shadow: 0 2px 8px rgba(0,0,0,0.04); z-index: 1;">
                    @if(str_contains($activity->action, 'Job'))
                        <svg style="width: 20px; height: 20px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    @elseif(str_contains($activity->action, 'Status') || str_contains($activity->action, 'Interview'))
                        <svg style="width: 20px; height: 20px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg style="width: 20px; height: 20px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                </div>
                <div style="padding-top: 2px;">
                    <div style="font-size: 15px; font-weight: 800; color: #0f172a;">{{ $activity->action }}</div>
                    <div style="font-size: 13px; color: #64748b; line-height: 1.5; margin-top: 4px; font-weight: 500;">{{ $activity->description }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: #94a3b8; margin-top: 6px;">{{ $activity->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div style="font-size: 13px; color: #94a3b8; text-align: center; padding: 20px 0; font-weight: 600;">No recent activities logged yet.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = "#94a3b8";

        const statusCtx = document.getElementById('statusChart').getContext('2d');
        
        const gradPending = statusCtx.createLinearGradient(0, 0, 0, 400);
        gradPending.addColorStop(0, '#fcd34d');
        gradPending.addColorStop(1, '#f59e0b');

        const gradInterview = statusCtx.createLinearGradient(0, 0, 0, 400);
        gradInterview.addColorStop(0, '#93c5fd');
        gradInterview.addColorStop(1, '#3b82f6');

        const gradApproved = statusCtx.createLinearGradient(0, 0, 0, 400);
        gradApproved.addColorStop(0, '#6ee7b7');
        gradApproved.addColorStop(1, '#10b981');

        const gradRejected = statusCtx.createLinearGradient(0, 0, 0, 400);
        gradRejected.addColorStop(0, '#fca5a5');
        gradRejected.addColorStop(1, '#ef4444');

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Interview', 'Approved', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $stats['pending'] }}, 
                        {{ $stats['interview'] }}, 
                        {{ $stats['approved'] }}, 
                        {{ $stats['rejected'] }}
                    ],
                    backgroundColor: [gradPending, gradInterview, gradApproved, gradRejected],
                    borderWidth: 0,
                    hoverOffset: 10,
                    borderRadius: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { usePointStyle: true, boxWidth: 10, padding: 20, font: { weight: '800', size: 12 } }
                    }
                }
            }
        });

        const overviewCtx = document.getElementById('overviewChart').getContext('2d');
        
        const gradBar1 = overviewCtx.createLinearGradient(0, 0, 0, 400);
        gradBar1.addColorStop(0, '#60a5fa');
        gradBar1.addColorStop(1, '#3b82f6');

        const gradBar2 = overviewCtx.createLinearGradient(0, 0, 0, 400);
        gradBar2.addColorStop(0, '#34d399');
        gradBar2.addColorStop(1, '#10b981');

        new Chart(overviewCtx, {
            type: 'bar',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [
                    {
                        label: 'Jobs Posted',
                        data: [{{ max(0, $jobs->count() - 3) }}, {{ max(0, $jobs->count() - 1) }}, {{ $jobs->count() }}, {{ $jobs->count() + 2 }}],
                        backgroundColor: gradBar1,
                        borderRadius: 8,
                        barThickness: 24
                    },
                    {
                        label: 'Applications',
                        data: [{{ max(0, $appCount - 5) }}, {{ max(0, $appCount - 2) }}, {{ $appCount }}, {{ $appCount + 4 }}],
                        backgroundColor: gradBar2,
                        borderRadius: 8,
                        barThickness: 24
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 10, font: { weight: '800', size: 12 } } }
                },
                scales: {
                    y: { beginAtZero: true, border: { display: false }, grid: { color: '#f1f5f9' }, ticks: { font: { weight: '700' }, padding: 10 } },
                    x: { border: { display: false }, grid: { display: false }, ticks: { font: { weight: '700' } } }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });
    });
</script>
@endsection
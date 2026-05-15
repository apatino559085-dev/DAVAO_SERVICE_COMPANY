@extends('layouts.app')
@section('title', 'Archived Jobs')
@section('content')

<style>
    .archive-header {
        display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;
    }
    .archive-title {
        font-size: 36px; font-weight: 900; letter-spacing: -1.5px;
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.1;
    }
    .archive-subtitle {
        font-size: 15px; color: #64748b; font-weight: 500; margin-top: 8px;
    }
    .archive-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(255,255,255,0.8);
        overflow: hidden;
    }
    .archive-table { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
    .archive-table th { 
        color: #94a3b8; font-size: 12px; font-weight: 800; text-transform: uppercase; 
        letter-spacing: 1px; padding: 0 20px 12px; border-bottom: 2px solid #f1f5f9; text-align: left;
    }
    .archive-table td { background: white; padding: 20px; transition: all 0.2s; }
    .archive-table tr td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
    .archive-table tr td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }
    .archive-table tbody tr { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .archive-table tbody tr:hover td { background: #f8fafc; }

    .terminated-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.5px;
        background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;
    }
    .terminated-badge::before {
        content: ''; width: 8px; height: 8px; border-radius: 50%; background: #dc2626;
    }

    .stat-pill {
        display: inline-flex; align-items: center; gap: 12px;
        background: white; padding: 16px 24px; border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.02);
    }

    .empty-archive {
        text-align: center; padding: 80px 24px;
    }
    .empty-archive-icon {
        width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;
    }
</style>

<div class="archive-header">
    <div>
        <div style="background: rgba(15, 23, 42, 0.05); color: #64748b; display: inline-block; padding: 6px 14px; border-radius: 100px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px;">📁 Storage Vault</div>
        <div class="archive-title">Archive System</div>
        <div class="archive-subtitle">Terminated job listings that are no longer visible to applicants</div>
        
        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <a href="{{ route('applications.archived') }}" style="background: white; color: #64748b; padding: 12px 28px; border-radius: 12px; font-weight: 900; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 8px; border: 1.5px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.borderColor='#fbbf24'; this.style.color='#fbbf24';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b';">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                APPLICANTS
            </a>
            <a href="{{ route('admin.archived-jobs') }}" style="background: #0f172a; color: white; padding: 12px 28px; border-radius: 12px; font-weight: 900; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                JOBS
            </a>
        </div>
    </div>
    <div style="display: flex; gap: 16px; align-items: center;">
        <div class="stat-pill">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #fef2f2, #fecaca); display: flex; align-items: center; justify-content: center; color: #dc2626;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
            <div>
                <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Total Archived</div>
                <div style="font-size: 24px; font-weight: 900; color: #0f172a;">{{ $jobs->count() }}</div>
            </div>
        </div>
    </div>
</div>

<div class="archive-card">
    <table class="archive-table">
        <thead>
            <tr>
                <th>Role Details</th>
                <th>Company</th>
                <th>Applicants</th>
                <th>Status</th>
                <th>Terminated On</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #94a3b8; border: 1px solid #e2e8f0;">
                            {{ substr($job->company, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-size: 15px; font-weight: 800; color: #64748b; text-decoration: line-through;">{{ $job->title }}</div>
                            <div style="font-size: 13px; color: #94a3b8; font-weight: 600; margin-top: 2px;">ID: #{{ str_pad($job->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-weight: 800; color: #64748b; font-size: 14px;">{{ $job->company }}</div>
                    <div style="color: #94a3b8; font-size: 12px; font-weight: 600; margin-top: 2px;">Posted by {{ $job->employer->name }}</div>
                </td>
                <td>
                    <span style="display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; color: #64748b; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 13px; border: 1px solid #e2e8f0;">
                        {{ $job->applications_count }} Candidates
                    </span>
                </td>
                <td>
                    <span class="terminated-badge">Terminated</span>
                </td>
                <td>
                    <div style="font-size: 14px; font-weight: 700; color: #64748b;">
                        {{ $job->terminated_at ? $job->terminated_at->format('M d, Y') : 'N/A' }}
                    </div>
                    <div style="font-size: 12px; color: #94a3b8; font-weight: 600; margin-top: 2px;">
                        {{ $job->terminated_at ? $job->terminated_at->diffForHumans() : '' }}
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-archive">
                        <div class="empty-archive-icon">
                            <svg style="width: 36px; height: 36px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin-bottom: 8px;">No Archived Jobs</h3>
                        <p style="font-size: 15px; color: #94a3b8; font-weight: 500; max-width: 400px; margin: 0 auto;">Terminated job listings will appear here. All current positions are still active.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

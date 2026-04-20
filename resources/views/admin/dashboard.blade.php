@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

<style>
    /* CHADA Premium Admin Design System */
    :root {
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.6);
        --glass-shadow: 0 10px 40px 0 rgba(31, 38, 135, 0.05);
        --gradient-admin: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    }

    .admin-header {
        position: relative;
        padding: 40px;
        border-radius: 24px;
        background: var(--gradient-admin);
        color: white;
        margin-bottom: 40px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(220, 38, 38, 0.2);
    }

    .admin-header::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
        animation: rotate 25s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .admin-title {
        font-size: 36px;
        font-weight: 900;
        letter-spacing: -1px;
        margin-bottom: 8px;
        position: relative; z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .admin-subtitle {
        font-size: 16px;
        font-weight: 500;
        opacity: 0.9;
        position: relative; z-index: 1;
    }

    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 32px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--glass-shadow);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border-color: rgba(239, 68, 68, 0.3);
    }

    .stat-value {
        font-size: 40px; font-weight: 900; color: #0f172a; line-height: 1; margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 13px; font-weight: 800; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase;
    }

    .admin-table-container {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 32px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    }

    .table-header {
        padding: 24px 32px; border-bottom: 1px solid #eef2f7; display: flex; justify-content: space-between; align-items: center;
        background: rgba(255,255,255,0.4);
    }

    .table-title { font-size: 20px; font-weight: 800; color: #0f172a; }
    .table-subtitle { font-size: 14px; color: #64748b; font-weight: 500; margin-top: 2px; }

    table td { padding: 18px 32px; transition: background 0.2s; }
    table tr:hover td { background: #f8fafc; }

    .btn-action {
        font-size: 13px; font-weight: 700; cursor: pointer; padding: 8px 20px; border-radius: 12px; transition: all 0.2s;
    }
</style>

<div class="admin-header">
    <div class="admin-title">System Control Center</div>
    <div class="admin-subtitle">Monitor total platform activity, manage users, and enforce rules.</div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px;">
    <div class="stat-card">
        <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(99,102,241,0.1), transparent 70%); border-radius: 50%;"></div>
        <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(255,255,255,0.5);">
            <svg style="width: 30px; height: 30px; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $users->total() }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="stat-card">
        <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(34,197,94,0.1), transparent 70%); border-radius: 50%;"></div>
        <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(255,255,255,0.5);">
            <svg style="width: 30px; height: 30px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $jobs->count() }}</div>
            <div class="stat-label">Job Posts</div>
        </div>
    </div>
    <div class="stat-card">
        <div style="position: absolute; top: -20px; right: -20px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(168,85,247,0.1), transparent 70%); border-radius: 50%;"></div>
        <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #f3e8ff, #e9d5ff); border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(255,255,255,0.5);">
            <svg style="width: 30px; height: 30px; color: #9333ea;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $appCount }}</div>
            <div class="stat-label">Applications</div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="admin-table-container">
    <div class="table-header">
        <div>
            <div class="table-title">Registered Platform Users</div>
            <div class="table-subtitle">Comprehensive list of all accounts.</div>
        </div>
        <span style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 800; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">{{ $users->total() }} total</span>
    </div>
    <div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background: rgba(248,250,252,0.8);">
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Name</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Email</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Address</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Role</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Status</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td>
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 12px; background: {{ $user->role === 'admin' ? '#fef2f2' : ($user->role === 'employer' ? '#ecfdf5' : '#eef2ff') }}; border: 1px solid {{ $user->role === 'admin' ? '#fecaca' : ($user->role === 'employer' ? '#a7f3d0' : '#c7d2fe') }}; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 16px; color: {{ $user->role === 'admin' ? '#dc2626' : ($user->role === 'employer' ? '#059669' : '#6366f1') }}; {{ !$user->is_active ? 'opacity: 0.4;' : '' }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 800; color: #0f172a; font-size: 15px; {{ !$user->is_active ? 'opacity: 0.4;' : '' }}">{{ $user->name }}</div>
                            <div style="color: #94a3b8; font-size: 12px; font-weight: 600; margin-top: 2px;">Joined {{ $user->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </td>
                <td style="color: #64748b; font-weight: 600;">{{ $user->email }}</td>
                <td style="color: #64748b; font-weight: 500;">{{ $user->address ?? '—' }}</td>
                <td>
                    <span style="padding: 6px 16px; border-radius: 12px; font-size: 12px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;
                        {{ $user->role === 'admin' ? 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;' :
                           ($user->role === 'employer' ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' : 'background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe;') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 10px; height: 10px; border-radius: 50%; {{ $user->is_active ? 'background: #22c55e; box-shadow: 0 0 10px rgba(34,197,94,0.5);' : 'background: #cbd5e1;' }}"></div>
                        <span style="font-size: 14px; font-weight: 800; {{ $user->is_active ? 'color: #059669;' : 'color: #94a3b8;' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </td>
                <td>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                        @csrf @method('PATCH')
                        <button class="btn-action" style="background: {{ $user->is_active ? 'white' : '#1e293b' }}; border: 1px solid {{ $user->is_active ? '#e2e8f0' : '#1e293b' }}; color: {{ $user->is_active ? '#dc2626' : 'white' }}; box-shadow: {{ $user->is_active ? '0 2px 4px rgba(0,0,0,0.02)' : '0 4px 10px rgba(15,23,42,0.2)' }};" onmouseover="this.style.borderColor='{{ $user->is_active ? '#fca5a5' : '#0f172a' }}'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='{{ $user->is_active ? '#e2e8f0' : '#1e293b' }}'; this.style.transform='translateY(0)'">
                            {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    
    <!-- User Pagination -->
    @if($users->hasPages())
    <div style="padding: 24px 32px; background: rgba(248,250,252,0.8); border-top: 1px solid #eef2f7; display: flex; justify-content: space-between; align-items: center;">
        <div style="font-size: 14px; font-weight: 600; color: #64748b;">
            Showing <span style="color: #0f172a; font-weight: 800;">{{ $users->firstItem() }}</span> to <span style="color: #0f172a; font-weight: 800;">{{ $users->lastItem() }}</span>
        </div>
        <div style="display: flex; gap: 12px;">
            @if ($users->onFirstPage())
                <span style="opacity: 0.5; background: #e2e8f0; color: #64748b; padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: not-allowed;">« Previous</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" style="background: white; color: #0f172a; border: 1px solid #cbd5e1; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 800; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.transform='translateY(0)'">« Previous</a>
            @endif
            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" style="background: white; color: #0f172a; border: 1px solid #cbd5e1; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 800; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.2s;" onmouseover="this.style.borderColor='#94a3b8'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.transform='translateY(0)'">Next »</a>
            @else
                <span style="opacity: 0.5; background: #e2e8f0; color: #64748b; padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: not-allowed;">Next »</span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Jobs Table -->
<div class="admin-table-container">
    <div class="table-header">
        <div>
            <div class="table-title">Network Job Listings</div>
            <div class="table-subtitle">Oversee all employer job postings.</div>
        </div>
        <span style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0; color: #059669; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 800; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">{{ $jobs->count() }} active</span>
    </div>
    <div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background: rgba(248,250,252,0.8);">
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Role Details</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Company / Poster</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Contract Type</th>
                <th style="padding: 18px 32px; text-align: left; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef2f7;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div style="width: 46px; height: 46px; border-radius: 12px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 20px; color: #0f172a;">
                            {{ substr($job->company, 0, 1) }}
                        </div>
                        <div>
                            <a href="{{ route('jobs.show', $job) }}" style="font-size: 16px; font-weight: 800; color: #0f172a; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#6366f1'" onmouseout="this.style.color='#0f172a'">{{ $job->title }}</a>
                            <div style="font-size: 12px; color: #94a3b8; font-weight: 600; margin-top: 2px;">ID: #{{ $job->id }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-weight: 800; color: #334155; font-size: 15px;">{{ $job->company }}</div>
                    <div style="color: #64748b; font-size: 13px; font-weight: 500; margin-top: 2px;">Posted by: {{ $job->employer->name }}</div>
                </td>
                <td>
                    <span style="padding: 6px 16px; border-radius: 10px; font-size: 12px; font-weight: 800; letter-spacing: 0.5px;
                        {{ $job->type === 'Full-time' ? 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;' :
                           ($job->type === 'Part-time' ? 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;' :
                           ($job->type === 'Remote' ? 'background: #eef2ff; color: #6366f1; border: 1px solid #c7d2fe;' : 'background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;')) }}">
                        {{ $job->type }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" onsubmit="return confirm('Execute termination protocol for this job posting?')">
                        @csrf @method('DELETE')
                        <button class="btn-action" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;" onmouseover="this.style.background='#dc2626'; this.style.color='white'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#fef2f2'; this.style.color='#dc2626'; this.style.transform='translateY(0)'">Terminate Post</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
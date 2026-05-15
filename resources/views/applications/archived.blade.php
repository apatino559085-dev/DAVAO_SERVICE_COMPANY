@extends('layouts.app')
@section('title', 'Application Archive')
@section('content')

<style>
    .archive-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 32px; padding: 48px; margin-bottom: 40px; color: white;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.3);
    }
    
    .archive-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
    }

    .archive-card {
        background: white; border-radius: 28px; padding: 32px; border: 1px solid #f1f5f9;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex; flex-direction: column; height: 100%;
    }
    .archive-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); border-color: #cbd5e1; }
    
    .status-badge {
        display: inline-block; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .status-approved { background: #ecfdf5; color: #059669; }
    .status-rejected { background: #fef2f2; color: #dc2626; }

    .btn-undo {
        background: white; border: 1.5px solid #e2e8f0; padding: 10px 16px; border-radius: 12px;
        color: #64748b; font-size: 12px; font-weight: 800; cursor: pointer; transition: all 0.2s;
        text-align: center; width: 100%; margin-top: 12px;
    }
    .btn-undo:hover { border-color: #0f172a; color: #0f172a; background: #f8fafc; }

    .btn-resume {
        background: #022c22; color: white; padding: 12px 16px; border-radius: 12px; 
        font-size: 12px; font-weight: 800; text-decoration: none; text-align: center;
        width: 100%; box-shadow: 0 4px 12px rgba(2, 44, 34, 0.1); transition: all 0.2s;
    }
    .btn-resume:hover { background: #064e3b; transform: translateY(-2px); }

    /* Custom Pagination Styling */
    .pagination-container { display: flex; justify-content: center; margin-top: 40px; }
    .pagination-container nav { background: white; padding: 10px 20px; border-radius: 100px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; }
</style>

<div class="archive-header">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 32px;">
        <div>
            <div style="background: rgba(251, 191, 36, 0.1); color: #fbbf24; display: inline-block; padding: 6px 14px; border-radius: 100px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px;">📁 Storage Vault</div>
            <h1 style="font-size: 42px; font-weight: 900; letter-spacing: -1.5px;">Archive System</h1>
            <p style="color: #94a3b8; font-size: 16px; margin-top: 8px;">A history of all records and decisions made.</p>
            
            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <a href="{{ route('applications.archived') }}" style="background: #fbbf24; color: #022c22; padding: 12px 28px; border-radius: 12px; font-weight: 900; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 10px 20px rgba(251, 191, 36, 0.2);">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    APPLICANTS
                </a>
                <a href="{{ route('admin.archived-jobs') }}" style="background: rgba(255,255,255,0.05); color: #94a3b8; padding: 12px 28px; border-radius: 12px; font-weight: 900; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 8px; border: 1.5px solid rgba(255,255,255,0.1); transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white';" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.color='#94a3b8';">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    JOBS
                </a>
            </div>
        </div>
        <form action="{{ route('applications.archived') }}" method="GET" style="display: flex; gap: 12px; flex: 1; max-width: 450px;">
            @if(request('job_title')) <input type="hidden" name="job_title" value="{{ request('job_title') }}"> @endif
            <input type="text" name="search" placeholder="Search archived names..." value="{{ request('search') }}" 
                   style="flex: 1; padding: 14px 20px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: white; outline: none; font-size: 14px; font-weight: 600;">
            <button type="submit" style="background: #fbbf24; color: #022c22; border: none; padding: 0 24px; border-radius: 16px; font-weight: 800; cursor: pointer;">Search</button>
        </form>
    </div>
    
    <div style="margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 32px;">
        <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px;">Select Role / Department</div>
        <div style="max-width: 400px;">
            <select onchange="window.location.href=this.value" 
                style="width: 100%; padding: 14px 20px; border-radius: 16px; border: 1.5px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: white; font-size: 14px; font-weight: 700; outline: none; cursor: pointer; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23fbbf24%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 20px center; background-size: 18px;">
                <option value="{{ route('applications.archived') }}" style="background: #0f172a; color: white;" {{ !request('job_title') ? 'selected' : '' }}>
                    All Archive Records
                </option>
                @foreach($jobTitles as $title)
                    <option value="{{ route('applications.archived', ['job_title' => $title]) }}" style="background: #0f172a; color: white;" {{ request('job_title') == $title ? 'selected' : '' }}>
                        {{ $title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="archive-grid">
    @forelse($applications as $app)
    <div class="archive-card">
        <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 24px;">
            <div style="width: 56px; height: 56px; background: #f8fafc; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #cbd5e1; font-size: 20px; border: 1px solid #f1f5f9;">
                {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
            </div>
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <h3 style="font-size: 17px; font-weight: 900; color: #0f172a;">{{ $app->applicant->name }}</h3>
                    <div class="status-badge status-{{ $app->status }}">{{ $app->status }}</div>
                </div>
                <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-top: 2px;">{{ $app->applicant->email }}</div>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 16px; border-radius: 16px; border: 1px solid #f1f5f9; margin-bottom: auto;">
            <div style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Applied For</div>
            <div style="font-size: 14px; font-weight: 800; color: #059669;">{{ $app->jobPost->title }}</div>
            <div style="font-size: 11px; color: #94a3b8; margin-top: 8px;">Decision made {{ $app->updated_at->diffForHumans() }}</div>
        </div>

        <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 10px;">
            @if($app->resume_path)
                <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn-resume">View Resume</a>
            @endif
            <form action="{{ route('applications.undo', $app->id) }}" method="POST" onsubmit="return confirm('Revert this application to active list?')">
                @csrf
                <button type="submit" class="btn-undo">Undo Decision</button>
            </form>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 120px; background: white; border-radius: 40px; border: 2px dashed #e2e8f0; color: #94a3b8;">
        <div style="font-size: 48px; margin-bottom: 16px;">📁</div>
        <p style="font-size: 18px; font-weight: 700;">No archived records found.</p>
    </div>
    @endforelse
</div>

@if($applications->hasPages())
<div class="pagination-container">
    {{ $applications->appends(request()->query())->links() }}
</div>
@endif

@endsection

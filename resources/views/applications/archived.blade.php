@extends('layouts.app')
@section('title', 'Application Archive')
@section('content')

<div style="max-width: 1000px; margin: 0 auto;">
    <!-- Header and Filter -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <svg style="width: 24px; height: 24px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Application Archive</h1>
            </div>
            <p style="font-size: 15px; color: #64748b; font-weight: 500;">Processed records and stash.</p>
        </div>

        <form action="{{ route('applications.archived') }}" method="GET" id="archiveFilterForm" style="min-width: 200px;">
            <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Filter by Status</label>
            <select name="status" onchange="document.getElementById('archiveFilterForm').submit()" style="width: 100%; padding: 11px 14px; border: 2px solid #eef2f7; border-radius: 12px; font-size: 14px; font-weight: 600; color: #334155; background: white; outline: none; cursor: pointer; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 14px center; background-size: 16px;">
                <option value="">All Processed</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Approved Only</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected Only</option>
            </select>
        </form>
    </div>

    <!-- Applicant Cards -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @forelse($applications as $app)
        <div style="background: white; border-radius: 16px; padding: 28px; border: 1px solid #e2e8f0; opacity: 0.85;">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; flex-wrap: wrap;">
                <!-- Applicant & Job Info -->
                <div style="display: flex; gap: 20px; flex: 1; min-width: 300px;">
                    <div style="width: 56px; height: 56px; border-radius: 12px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: 900; font-size: 22px; flex-shrink: 0;">
                        {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
                            <h2 style="font-size: 18px; font-weight: 800; color: #334155;">{{ $app->applicant->name }}</h2>
                            <span style="font-size: 11px; font-weight: 700; color: #94a3b8;">Processed {{ $app->updated_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 14px; color: #64748b; font-weight: 600; margin-bottom: 8px;">{{ $app->applicant->email }}</p>
                        
                        <div style="display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; color: #64748b; border: 1px solid #f1f5f9;">
                            <span style="color: #cbd5e1;">Applied for:</span>
                            <span style="color: #64748b;">{{ $app->jobPost->title }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
                    <span style="padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
                        {{ $app->status === 'accepted' ? 'background: #ecfdf5; color: #059669; border: 1px solid #d1fae5;' : 
                           ($app->status === 'rejected' ? 'background: #fef2f2; color: #ef4444; border: 1px solid #fecaca;' : 'background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0;') }}">
                        {{ $app->status === 'pending' ? 'STASHED' : ucfirst($app->status) }}
                    </span>
                </div>
            </div>

            <!-- Resume Link -->
            @if($app->resume_path)
            <div style="margin-top: 24px;">
                <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" style="font-size: 13px; font-weight: 700; color: #6366f1; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2-2z"/></svg>
                    View Archived Resume
                </a>
            </div>
            @endif
        </div>
        @empty
        <div style="text-align: center; padding: 100px 40px; background: white; border-radius: 20px; border: 2px dashed #e2e8f0;">
            <div style="font-size: 56px; margin-bottom: 24px;">📁</div>
            <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 12px;">Archive is empty</h3>
            <p style="font-size: 16px; color: #94a3b8; font-weight: 500; max-width: 400px; margin: 0 auto;">
                Applications you approve, reject, or manually archive will appear here.
            </p>
        </div>
        @endforelse
    </div>
</div>

@endsection

@extends('layouts.app')
@section('title', 'Company Roles — Davao Central Services Company')
@section('content')

<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Company Roles</h1>
            <p style="font-size: 15px; color: #64748b; font-weight: 500; margin-top: 4px;">Davao Central Services Company — Track applicants for each role.</p>
        </div>
        <a href="{{ route('jobs.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #6366f1; color: white; text-decoration: none; padding: 12px 24px; border-radius: 14px; font-size: 14px; font-weight: 800; transition: background 0.2s;">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Role
        </a>
    </div>

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div style="background: white; padding: 24px; border-radius: 20px; border: 1px solid #eef2f7; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; background: #eef2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #6366f1;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Active Roles</div>
                    <div style="font-size: 24px; font-weight: 900; color: #0f172a;">{{ $jobs->count() }}</div>
                </div>
            </div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 20px; border: 1px solid #eef2f7; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; background: #f0fdf4; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Total Applicants</div>
                    <div style="font-size: 24px; font-weight: 900; color: #0f172a;">{{ $jobs->sum('applications_count') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Table -->
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; box-shadow: 0 4px 24px rgba(0,0,0,0.03); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #fafbfc; border-bottom: 1px solid #eef2f7;">
                    <th style="padding: 20px 24px; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px;">Role Title</th>
                    <th style="padding: 20px 24px; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px;">Applicants</th>
                    <th style="padding: 20px 24px; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px;">Status</th>
                    <th style="padding: 20px 24px; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px;">Posted</th>
                    <th style="padding: 20px 24px; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.15s;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 24px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            @if($job->logo_path)
                            <img src="{{ asset('storage/' . $job->logo_path) }}" alt="" style="width: 44px; height: 44px; border-radius: 10px; object-fit: contain; border: 1px solid #f1f5f9; padding: 4px;">
                            @else
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #f8fafc; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #64748b;">
                                {{ strtoupper(substr($job->title, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <div style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">{{ $job->title }}</div>
                                <div style="font-size: 13px; font-weight: 600; color: #64748b;">{{ $job->industry }} • {{ ucfirst($job->type) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 24px;">
                        <a href="{{ route('jobs.applicants', $job) }}" style="display: inline-flex; align-items: center; gap: 8px; background: #fef2f2; color: #ef4444; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 13px; text-decoration: none; border: 1px solid #fee2e2; transition: all 0.2s;"
                           onmouseover="this.style.background='#fee2e2'; this.style.transform='scale(1.05)'"
                           onmouseout="this.style.background='#fef2f2'; this.style.transform='scale(1)'">
                            {{ $job->applications_count }} Candidates
                        </a>
                    </td>
                    <td style="padding: 24px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #22c55e; font-size: 13px; font-weight: 700;">
                            <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                            Active
                        </div>
                    </td>
                    <td style="padding: 24px; font-size: 14px; font-weight: 600; color: #64748b;">
                        {{ $job->created_at->format('M d, Y') }}
                    </td>
                    <td style="padding: 24px; text-align: right;">
                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                            <a href="{{ route('jobs.show', $job) }}" title="View Public Page" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; border-radius: 12px; color: #64748b; transition: all 0.2s;" onmouseover="this.style.color='#6366f1'; this.style.borderColor='#c7d2fe'; this.style.background='#f5f7ff'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.background='white'">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('jobs.edit', $job) }}" title="Edit Job" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; border-radius: 12px; color: #64748b; transition: all 0.2s;" onmouseover="this.style.color='#ca8a04'; this.style.borderColor='#fde047'; this.style.background='#fefce8'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.background='white'">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Terminate this job listing? It will be moved to the archive.')" style="display: inline;">
                                @csrf @method('DELETE')
                                <button title="Terminate Job" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; border-radius: 12px; color: #64748b; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.color='#ef4444'; this.style.borderColor='#fecaca'; this.style.background='#fef2f2'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.background='white'">
                                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 64px 24px; text-align: center;">
                        <div style="width: 60px; height: 60px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <svg style="width: 28px; height: 28px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">No roles created yet</h3>
                        <p style="font-size: 14px; color: #64748b; font-weight: 500; margin-bottom: 24px;">Start reaching out to talent by adding your first role.</p>
                        <a href="{{ route('jobs.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #6366f1; color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-size: 13px; font-weight: 800;">
                            Add First Role
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

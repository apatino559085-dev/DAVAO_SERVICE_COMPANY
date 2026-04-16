@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')



<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px;">
    <div style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; border-radius: 20px; padding: 28px;">
        <p style="font-size: 36px; font-weight: 900;">{{ $users->total() }}</p>
        <p style="font-size: 14px; font-weight: 600; opacity: 0.8; margin-top: 4px;">Total Users</p>
    </div>
    <div style="background: linear-gradient(135deg, #059669, #047857); color: white; border-radius: 20px; padding: 28px;">
        <p style="font-size: 36px; font-weight: 900;">{{ $jobs->count() }}</p>
        <p style="font-size: 14px; font-weight: 600; opacity: 0.8; margin-top: 4px;">Job Posts</p>
    </div>
    <div style="background: linear-gradient(135deg, #a855f7, #7c3aed); color: white; border-radius: 20px; padding: 28px;">
        <p style="font-size: 36px; font-weight: 900;">{{ $appCount }}</p>
        <p style="font-size: 14px; font-weight: 600; opacity: 0.8; margin-top: 4px;">Applications</p>
    </div>
</div>

<!-- Users Table -->
<div style="background: white; border: 1px solid #eef2f7; border-radius: 20px; overflow: hidden; margin-bottom: 28px;">
    <div style="padding: 20px 24px; border-bottom: 1px solid #eef2f7;">
        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a;">Registered Users</h2>
    </div>
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background: #fafbfc;">
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Name</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Email</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Address</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Role</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Status</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Joined</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-top: 1px solid #f1f5f9; {{ !$user->is_active ? 'background: #f8fafc;' : '' }}">
                <td style="padding: 14px 24px; font-weight: 700; color: #0f172a; {{ !$user->is_active ? 'opacity: 0.5;' : '' }}">{{ $user->name }}</td>
                <td style="padding: 14px 24px; color: #64748b; font-weight: 500;">{{ $user->email }}</td>
                <td style="padding: 14px 24px; color: #64748b; font-weight: 500;">{{ $user->address ?? '—' }}</td>
                <td style="padding: 14px 24px;">
                    <span style="padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 800;
                        {{ $user->role === 'admin' ? 'background: #fef2f2; color: #dc2626;' :
                           ($user->role === 'staff' ? 'background: #ecfdf5; color: #059669;' : 'background: #eef2ff; color: #6366f1;') }}">
                        {{ $user->role === 'staff' ? 'Staff' : ucfirst($user->role) }}
                    </span>
                </td>
                <td style="padding: 14px 24px;">
                    <span style="padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 800;
                        {{ $user->is_active ? 'background: #ecfdf5; color: #059669;' : 'background: #f1f5f9; color: #64748b;' }}">
                        {{ $user->is_active ? 'Active' : 'Deactivated' }}
                    </span>
                </td>
                <td style="padding: 14px 24px; color: #94a3b8; font-size: 12px; font-weight: 600;">{{ $user->created_at->format('M d, Y') }}</td>
                <td style="padding: 14px 24px;">
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                        @csrf @method('PATCH')
                        <button style="background: none; border: none; color: {{ $user->is_active ? '#ef4444' : '#6366f1' }}; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit;">
                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- User Pagination -->
    @if($users->hasPages())
    <div style="padding: 18px 24px; border-top: 1px solid #f1f5f9; background: #fafbfc; display: flex; justify-content: space-between; align-items: center;">
        <div style="font-size: 13px; font-weight: 600; color: #94a3b8;">
            Showing <span style="color: #0f172a; font-weight: 800;">{{ $users->firstItem() }}</span> to <span style="color: #0f172a; font-weight: 800;">{{ $users->lastItem() }}</span>
        </div>
        <div style="display: flex; gap: 8px;">
            @if ($users->onFirstPage())
                <span style="opacity: 0.4; background: #f1f5f9; color: #64748b; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: not-allowed;">« Previous</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" style="background: #ffffff; color: #6366f1; border: 1px solid #e2e8f0; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; transition: all 0.2s;" onmouseover="this.style.background='#6366f1'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#6366f1'">« Previous</a>
            @endif

            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" style="background: #ffffff; color: #6366f1; border: 1px solid #e2e8f0; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; transition: all 0.2s;" onmouseover="this.style.background='#6366f1'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#6366f1'">Next »</a>
            @else
                <span style="opacity: 0.4; background: #f1f5f9; color: #64748b; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: not-allowed;">Next »</span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Jobs Table -->
<div style="background: white; border: 1px solid #eef2f7; border-radius: 20px; overflow: hidden;">
    <div style="padding: 20px 24px; border-bottom: 1px solid #eef2f7;">
        <h2 style="font-size: 18px; font-weight: 800; color: #0f172a;">All Job Posts</h2>
    </div>
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background: #fafbfc;">
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Title</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Company</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Posted by</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Type</th>
                <th style="padding: 12px 24px; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr style="border-top: 1px solid #f1f5f9;">
                <td style="padding: 14px 24px; font-weight: 700; color: #0f172a;">{{ $job->title }}</td>
                <td style="padding: 14px 24px; color: #64748b; font-weight: 500;">{{ $job->company }}</td>
                <td style="padding: 14px 24px; color: #64748b; font-weight: 500;">{{ $job->employer->name }}</td>
                <td style="padding: 14px 24px;">
                    <span style="padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 800; background: #eef2ff; color: #6366f1;">{{ $job->type }}</span>
                </td>
                <td style="padding: 14px 24px;">
                    <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" onsubmit="return confirm('Delete this job post?')">
                        @csrf @method('DELETE')
                        <button style="background: none; border: none; color: #ef4444; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
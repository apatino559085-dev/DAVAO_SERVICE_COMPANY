@extends('layouts.app')
@section('title', 'Browse Jobs')
@section('content')

<div>
    <!-- Header row -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Browse Jobs</h1>
        </div>
        @auth
            @if(auth()->user()->isStaff() || auth()->user()->isAdmin())
            <a href="{{ route('jobs.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #6366f1; color: white; text-decoration: none; padding: 12px 24px; border-radius: 14px; font-size: 14px; font-weight: 800; transition: background 0.2s;">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Post a Job
            </a>
            @endif
        @endauth
    </div>

    <!-- Horizontal Filter Bar -->
    <div style="background: white; border-radius: 20px; padding: 20px 24px; border: 1px solid #eef2f7; margin-bottom: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <form action="{{ route('jobs.index') }}" method="GET" style="display: flex; align-items: flex-end; gap: 20px; flex-wrap: wrap;">
            <!-- Job Type -->
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Job Type</label>
                <select name="type" style="width: 100%; padding: 11px 14px; border: 2px solid #eef2f7; border-radius: 12px; font-size: 14px; font-weight: 600; color: #334155; background: #fafbfc; outline: none; font-family: inherit; cursor: pointer;">
                    <option value="">All Types</option>
                    <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="remote" {{ request('type') == 'remote' ? 'selected' : '' }}>Remote</option>
                    <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                </select>
            </div>

            <!-- Location -->
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Location</label>
                <input type="text" name="location" value="{{ request('location') }}" placeholder="City name..."
                       style="width: 100%; padding: 11px 14px; border: 2px solid #eef2f7; border-radius: 12px; font-size: 14px; font-weight: 600; color: #334155; background: #fafbfc; outline: none; font-family: inherit;">
            </div>

            <!-- Salary -->
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Salary Range</label>
                <select name="salary" style="width: 100%; padding: 11px 14px; border: 2px solid #eef2f7; border-radius: 12px; font-size: 14px; font-weight: 600; color: #334155; background: #fafbfc; outline: none; font-family: inherit; cursor: pointer;">
                    <option value="">Any Salary</option>
                    <option value="10k" {{ request('salary') == '10k' ? 'selected' : '' }}>₱10k – ₱20k</option>
                    <option value="20k" {{ request('salary') == '20k' ? 'selected' : '' }}>₱20k – ₱50k</option>
                    <option value="50k" {{ request('salary') == '50k' ? 'selected' : '' }}>₱50k+</option>
                </select>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" style="padding: 12px 28px; background: #6366f1; color: white; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer; font-family: inherit; transition: background 0.2s;">
                    Filter
                </button>
                <a href="{{ route('jobs.index') }}" style="font-size: 13px; font-weight: 700; color: #94a3b8; text-decoration: none; padding: 12px;">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Job Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 32px;">
        @forelse($jobs as $job)
        <div style="background: white; border-radius: 16px; padding: 32px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; height: 100%; transition: all 0.3s ease; position: relative; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);"
             onmouseover="this.style.borderColor='#6366f1'; this.style.boxShadow='0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04)'; this.style.transform='translateY(-2px)'"
             onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
            
            <!-- Top Row: Badge & Date -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $job->created_at->diffForHumans() }}
                </span>
                <span style="font-size: 10px; font-weight: 800; padding: 6px 12px; border-radius: 6px; text-transform: uppercase; letter-spacing: 1px;
                    {{ $job->type === 'full-time' ? 'background: #f0fdf4; color: #166534;' :
                       ($job->type === 'part-time' ? 'background: #fffbeb; color: #92400e;' :
                       ($job->type === 'remote' ? 'background: #eef2ff; color: #3730a3;' : 'background: #f8fafc; color: #475569;')) }}">
                    {{ ucfirst($job->type) }}
                </span>
            </div>

            <!-- Identity -->
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 28px;">
                <div style="width: 60px; height: 60px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #6366f1; font-weight: 900; font-size: 24px; flex-shrink: 0; transition: all 0.2s;">
                    {{ strtoupper(substr($job->company, 0, 1)) }}
                </div>
                <div style="min-width: 0;">
                    <h2 style="font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 4px; line-height: 1.2; letter-spacing: -0.3px;">{{ $job->title }}</h2>
                    <span style="font-size: 14px; font-weight: 600; color: #64748b;">{{ $job->company }}</span>
                </div>
            </div>

            <!-- Meta Details -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 32px; padding: 20px; background: #f8fafc; border-radius: 12px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg style="width: 18px; height: 18px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span style="font-size: 13px; font-weight: 600; color: #475569;">{{ $job->location }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg style="width: 18px; height: 18px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="font-size: 13px; font-weight: 700; color: #0f172a;">{{ $job->salary ?? 'Competitive' }}</span>
                </div>
            </div>

            <!-- Footer Actions -->
            <div style="margin-top: auto; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; gap: 8px;">
                    @auth
                    @if(auth()->user()->isAdmin() || auth()->id() === $job->user_id)
                        <a href="{{ route('jobs.edit', $job) }}" title="Edit Position" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; transition: all 0.2s;" onmouseover="this.style.color='#ca8a04'; this.style.borderColor='#fde047'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Archive this position?')" style="display: inline;">
                            @csrf @method('DELETE')
                            <button title="Archive" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.color='#ef4444'; this.style.borderColor='#fecaca'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    @endif
                    @endauth
                </div>
                
                <a href="{{ route('jobs.show', $job) }}" style="background: #0f172a; color: white; text-decoration: none; padding: 12px 28px; border-radius: 10px; font-size: 14px; font-weight: 700; transition: all 0.2s; display: flex; align-items: center; gap: 10px;"
                   onmouseover="this.style.background='#4f46e5'; this.style.transform='scale(1.02)'"
                   onmouseout="this.style.background='#0f172a'; this.style.transform='scale(1)'">
                    Details
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 80px 40px; background: white; border-radius: 32px; border: 2px dashed #e2e8f0;">
            <div style="font-size: 48px; margin-bottom: 20px;">🔍</div>
            <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 12px;">No jobs found</h3>
            <p style="font-size: 16px; color: #94a3b8; font-weight: 500;">Try adjusting your filters or check back later.</p>
        </div>
        @endforelse
    </div>


        <!-- Pagination -->
        @if($jobs->hasPages())
        <div style="margin-top: 32px; padding: 18px 24px; background: white; border-radius: 20px; border: 1px solid #eef2f7; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 13px; font-weight: 600; color: #94a3b8;">
                Showing <span style="color: #0f172a; font-weight: 800;">{{ $jobs->firstItem() }}</span> to <span style="color: #0f172a; font-weight: 800;">{{ $jobs->lastItem() }}</span>
            </div>
            <div style="display: flex; gap: 8px;">
                @if ($jobs->onFirstPage())
                    <span style="opacity: 0.4; background: #f1f5f9; color: #64748b; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: not-allowed;">« Previous</span>
                @else
                    <a href="{{ $jobs->previousPageUrl() }}" style="background: #ffffff; color: #6366f1; border: 1px solid #e2e8f0; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; transition: all 0.2s;" onmouseover="this.style.background='#6366f1'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#6366f1'">« Previous</a>
                @endif

                @if ($jobs->hasMorePages())
                    <a href="{{ $jobs->nextPageUrl() }}" style="background: #ffffff; color: #6366f1; border: 1px solid #e2e8f0; text-decoration: none; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; transition: all 0.2s;" onmouseover="this.style.background='#6366f1'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#6366f1'">Next »</a>
                @else
                    <span style="opacity: 0.4; background: #f1f5f9; color: #64748b; padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: not-allowed;">Next »</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
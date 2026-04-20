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
            @if(auth()->user()->isHR() || auth()->user()->isAdmin())
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

            <!-- Industry -->
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">Industry</label>
                <select name="industry" style="width: 100%; padding: 11px 14px; border: 2px solid #eef2f7; border-radius: 12px; font-size: 14px; font-weight: 600; color: #334155; background: #fafbfc; outline: none; font-family: inherit; cursor: pointer;">
                    <option value="">All Industries</option>
                    @foreach(['Technology','Healthcare','Finance','Education','Retail','Manufacturing','Hospitality','Food & Beverage','Logistics'] as $ind)
                    <option value="{{ $ind }}" {{ request('industry') == $ind ? 'selected' : '' }}>{{ $ind }}</option>
                    @endforeach
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
                    Search
                </button>
                <a href="{{ route('jobs.index') }}" style="font-size: 13px; font-weight: 700; color: #94a3b8; text-decoration: none; padding: 12px;">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Job Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 24px;">
        @forelse($jobs as $job)
        <div style="background: white; border-radius: 20px; padding: 28px; border: 1px solid #eef2f7; display: flex; flex-direction: column; height: 100%; transition: all 0.2s ease; position: relative;"
             onmouseover="this.style.borderColor='#c7d2fe'; this.style.boxShadow='0 12px 32px rgba(99,102,241,0.08)'; this.style.transform='translateY(-4px)'"
             onmouseout="this.style.borderColor='#eef2f7'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
            
            <!-- Top Row: Badges & Date -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <span style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $job->created_at->diffForHumans() }}
                    </span>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: flex-end;">
                    @if($job->industry)
                    <span style="font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px; background: #eef2ff; color: #6366f1; border: 1px solid #e0e7ff;">
                        {{ $job->industry }}
                    </span>
                    @endif
                    <span style="font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;
                        {{ $job->type === 'full-time' ? 'background: #ecfdf5; color: #059669; border: 1px solid #d1fae5;' :
                           ($job->type === 'part-time' ? 'background: #fffbeb; color: #b45309; border: 1px solid #fef3c7;' :
                           ($job->type === 'remote' ? 'background: #fdf2f8; color: #be185d; border: 1px solid #fce7f3;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;')) }}">
                        {{ ucfirst($job->type) }}
                    </span>
                </div>
            </div>

            <!-- Identity -->
            <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 24px;">
                @if($job->logo_path)
                <img src="{{ asset('storage/' . $job->logo_path) }}" alt="{{ $job->company }}" style="width: 52px; height: 52px; border-radius: 12px; object-fit: contain; background: white; border: 1px solid #e2e8f0; padding: 4px; flex-shrink: 0;">
                @else
                <div style="width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #0f172a; font-weight: 900; font-size: 22px; flex-shrink: 0;">
                    {{ strtoupper(substr($job->company, 0, 1)) }}
                </div>
                @endif
                <div style="min-width: 0;">
                    <a href="{{ route('jobs.show', $job) }}" style="text-decoration: none;">
                        <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 2px; line-height: 1.3; transition: color 0.2s;" onmouseover="this.style.color='#6366f1'" onmouseout="this.style.color='#0f172a'">{{ $job->title }}</h2>
                    </a>
                    <div style="font-size: 13px; font-weight: 600; color: #64748b;">{{ $job->company }}</div>
                </div>
            </div>

            <!-- Meta Details -->
            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;">
                <div style="background: #f8fafc; padding: 8px 12px; border-radius: 8px; display: flex; align-items: center; gap: 6px; border: 1px solid #f1f5f9;">
                    <svg style="width: 14px; height: 14px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span style="font-size: 12px; font-weight: 600; color: #475569; white-space: nowrap;">{{ Str::limit($job->location, 20) }}</span>
                </div>
                <div style="background: #f8fafc; padding: 8px 12px; border-radius: 8px; display: flex; align-items: center; gap: 6px; border: 1px solid #f1f5f9;">
                    <svg style="width: 14px; height: 14px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="font-size: 12px; font-weight: 700; color: #0f172a; white-space: nowrap;">{{ $job->salary ?? 'Competitive' }}</span>
                </div>
            </div>

            <!-- Footer Actions -->
            <div style="margin-top: auto; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <div style="display: flex; gap: 8px;">
                    @auth
                    @if(auth()->user()->isAdmin() || auth()->id() === $job->user_id)
                        <a href="{{ route('jobs.edit', $job) }}" title="Edit Position" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; transition: all 0.2s;" onmouseover="this.style.color='#ca8a04'; this.style.borderColor='#fde047'; this.style.background='#fefce8'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.background='white'">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Archive this position?')" style="display: inline;">
                            @csrf @method('DELETE')
                            <button title="Archive" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.color='#ef4444'; this.style.borderColor='#fecaca'; this.style.background='#fef2f2'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'; this.style.background='white'">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    @endif
                    @endauth
                </div>
                
                <a href="{{ route('jobs.show', $job) }}" style="background: #0f172a; color: white; text-decoration: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; transition: all 0.2s; display: flex; align-items: center; gap: 8px;"
                   onmouseover="this.style.background='#1e293b'"
                   onmouseout="this.style.background='#0f172a'">
                    View Details
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 64px 40px; background: white; border-radius: 24px; border: 1px dashed #cbd5e1;">
            <div style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <svg style="width: 32px; height: 32px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">No jobs found</h3>
            <p style="font-size: 15px; color: #64748b; font-weight: 500; text-align: center;">Try adjusting your filters or search terms to find what you're looking for.</p>
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
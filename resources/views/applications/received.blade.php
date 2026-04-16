@extends('layouts.app')
@section('title', 'Manage Candidates')
@section('content')

<div style="max-width: 1000px; margin: 0 auto;">
    <!-- Header -->
    <div style="margin-bottom: 40px;">
        <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Manage Candidates</h1>
        <p style="font-size: 15px; color: #64748b; font-weight: 500; margin-top: 6px;">
            Overview of all individuals who have applied for your positions.
        </p>
    </div>

    <!-- Applicant Cards -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @forelse($applications as $app)
        <div style="background: white; border-radius: 16px; padding: 28px; border: 1px solid #e2e8f0; transition: all 0.3s ease;"
             onmouseover="this.style.boxShadow='0 12px 20px -5px rgba(0,0,0,0.05)'; this.style.borderColor='#cbd5e1'"
             onmouseout="this.style.boxShadow='none'; this.style.borderColor='#e2e8f0'">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; flex-wrap: wrap;">
                <!-- Applicant & Job Info -->
                <div style="display: flex; gap: 20px; flex: 1; min-width: 300px;">
                    <div style="width: 56px; height: 56px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #6366f1; font-weight: 900; font-size: 22px; flex-shrink: 0;">
                        {{ strtoupper(substr($app->applicant->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
                            <h2 style="font-size: 18px; font-weight: 800; color: #0f172a;">{{ $app->applicant->name }}</h2>
                            <span style="font-size: 11px; font-weight: 700; color: #94a3b8;">{{ $app->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 14px; color: #64748b; font-weight: 600; margin-bottom: 8px;">{{ $app->applicant->email }}</p>
                        
                        <!-- Applied For Tag -->
                        <div style="display: inline-flex; align-items: center; gap: 6px; background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; color: #475569;">
                            <span style="color: #94a3b8;">Applied for:</span>
                            <a href="{{ route('jobs.show', $app->jobPost) }}" style="color: #6366f1; text-decoration: none;">{{ $app->jobPost->title }}</a>
                        </div>
                    </div>
                </div>

                <!-- Status & Actions -->
                <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
                    @if($app->status === 'pending')
                    <div style="display: flex; gap: 8px;">
                        <form method="POST" action="{{ route('applications.updateStatus', $app) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button style="background: #059669; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit; transition: all 0.2s;" onmouseover="this.style.background='#047857'" onmouseout="this.style.background='#059669'">
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('applications.updateStatus', $app) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button style="background: white; border: 1px solid #e2e8f0; color: #ef4444; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'; this.style.borderColor='#fecaca'" onmouseout="this.style.background='white'; this.style.borderColor='#e2e8f0'">
                                Decline
                            </button>
                        </form>
                    </div>
                    @else
                    <span style="padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
                        {{ $app->status === 'accepted' ? 'background: #ecfdf5; color: #059669;' : 'background: #fef2f2; color: #ef4444;' }}">
                        {{ ucfirst($app->status) }}
                    </span>
                    @endif
                </div>
            </div>

            <!-- Cover Letter Preview -->
            @if($app->cover_letter)
            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #f1f5f9;">
                <p style="font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Candidate Message</p>
                <p style="font-size: 14px; color: #334155; line-height: 1.6; font-weight: 500;">
                    "{{ Str::limit($app->cover_letter, 200) }}"
                    @if(strlen($app->cover_letter) > 200)
                        <a href="{{ route('jobs.applicants', $app->jobPost) }}" style="color: #6366f1; text-decoration: none; font-weight: 700; margin-left: 4px;">Read more</a>
                    @endif
                </p>
            </div>
            @endif
        </div>
        @empty
        <div style="text-align: center; padding: 100px 40px; background: white; border-radius: 20px; border: 2px dashed #e2e8f0;">
            <div style="font-size: 56px; margin-bottom: 24px;">📬</div>
            <h3 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 12px;">No incoming applications</h3>
            <p style="font-size: 16px; color: #94a3b8; font-weight: 500; max-width: 400px; margin: 0 auto; margin-bottom: 20px;">
                Searching across {{ auth()->user()->isAdmin() ? 'the entire platform' : 'your ' . auth()->user()->jobPosts()->count() . ' active jobs' }}.
            </p>
            <p style="font-size: 14px; color: #cbd5e1; font-weight: 500;">
                Check back once candidates start applying for your jobs.
            </p>
        </div>
        @endforelse
    </div>
</div>

@endsection

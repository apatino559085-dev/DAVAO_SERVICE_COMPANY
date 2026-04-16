@extends('layouts.app')
@section('title', 'My Applications')
@section('content')

<div style="margin-bottom: 28px;">
    <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">My Applications</h1>
    <p style="font-size: 14px; color: #94a3b8; font-weight: 600; margin-top: 4px;">Track all your submitted job applications</p>
</div>

@forelse($applications as $app)
<div style="background: white; border-radius: 20px; padding: 24px 28px; margin-bottom: 14px; border: 1px solid #eef2f7; display: flex; align-items: center; justify-content: space-between; gap: 20px;"
     onmouseover="this.style.borderColor='#c7d2fe'; this.style.boxShadow='0 8px 30px rgba(99,102,241,0.08)'"
     onmouseout="this.style.borderColor='#eef2f7'; this.style.boxShadow='none'">

    <div style="display: flex; align-items: center; gap: 18px;">
        <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #6366f1, #a855f7); display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 18px; flex-shrink: 0;">
            {{ strtoupper(substr($app->jobPost->company, 0, 1)) }}
        </div>
        <div>
            <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $app->jobPost->title }}</h2>
            <p style="font-size: 13px; color: #64748b; font-weight: 600;">{{ $app->jobPost->company }} · 📍 {{ $app->jobPost->location }}</p>
            <p style="font-size: 11px; color: #cbd5e1; font-weight: 600; margin-top: 4px;">Applied {{ $app->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <span style="padding: 6px 16px; border-radius: 100px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
        {{ $app->status === 'pending' ? 'background: #fefce8; color: #ca8a04;' :
           ($app->status === 'accepted' ? 'background: #ecfdf5; color: #059669;' : 'background: #fef2f2; color: #ef4444;') }}">
        {{ ucfirst($app->status) }}
    </span>
</div>
@empty
<div style="text-align: center; padding: 80px 40px; background: white; border-radius: 24px; border: 2px dashed #e2e8f0;">
    <div style="font-size: 48px; margin-bottom: 16px;">📋</div>
    <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">No applications yet</h3>
    <p style="font-size: 15px; color: #94a3b8; font-weight: 500; margin-bottom: 20px;">Start browsing jobs and submit your first application.</p>
    <a href="{{ route('jobs.index') }}" style="background: #6366f1; color: white; text-decoration: none; padding: 12px 28px; border-radius: 14px; font-weight: 800; display: inline-block;">
        Browse Jobs →
    </a>
</div>
@endforelse

@endsection
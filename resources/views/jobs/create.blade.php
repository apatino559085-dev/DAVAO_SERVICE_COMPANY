@extends('layouts.app')
@section('title', 'Post a New Job')
@section('content')

<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 48px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(2, 44, 34, 0.05); padding: 8px 16px; border-radius: 100px; font-size: 11px; font-weight: 900; color: var(--primary); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px;">
            📝 Creation Suite
        </div>
        <h1 style="font-size: 48px; font-weight: 900; letter-spacing: -1.5px; color: var(--primary);">Post a New Position</h1>
        <p style="font-size: 16px; color: var(--text-muted); font-weight: 500;">Fill in the details below to publish a new job vacancy.</p>
    </div>

    <div style="background: white; border-radius: 40px; padding: 60px; border: 1px solid #f1f5f9; box-shadow: 0 40px 80px rgba(0,0,0,0.05);">
        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('jobs._form')
            
            <div style="margin-top: 48px; display: flex; gap: 16px;">
                <button type="submit" style="background: var(--primary); color: white; border: none; padding: 20px 40px; border-radius: 20px; font-weight: 900; font-size: 16px; cursor: pointer; flex: 1; box-shadow: 0 15px 35px rgba(2, 44, 34, 0.2);">Publish Position</button>
                <a href="{{ route('jobs.index') }}" style="background: #f8fafc; color: var(--text-muted); padding: 20px 40px; border-radius: 20px; text-decoration: none; font-weight: 800; font-size: 16px; border: 1px solid #e2e8f0;">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
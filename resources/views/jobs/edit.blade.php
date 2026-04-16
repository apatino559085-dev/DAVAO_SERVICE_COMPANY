@extends('layouts.app')
@section('title', 'Edit Job Post')
@section('content')
<div style="max-width: 700px; margin: 0 auto; background: white; border-radius: 24px; border: 1px solid #eef2f7; padding: 40px;">
    <h1 style="font-size: 24px; font-weight: 900; color: #0f172a; margin-bottom: 28px;">Edit Job Post</h1>
    <form method="POST" action="{{ route('jobs.update', $job) }}">
        @csrf @method('PUT')
        @include('jobs._form')
        <div style="margin-top: 28px; display: flex; gap: 14px; align-items: center;">
            <button type="submit"
                    style="background: #ca8a04; color: white; border: none; padding: 14px 32px; border-radius: 14px; font-size: 15px; font-weight: 800; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(202,138,4,0.3);">
                Save Changes
            </button>
            <a href="{{ route('jobs.index') }}" style="color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 600;">Cancel</a>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Edit Role')
@section('content')
<div style="max-width: 800px; margin: 40px auto; background: white; border-radius: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); padding: 50px; border: 1px solid #f1f5f9;">
    <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 32px; letter-spacing: -0.5px;">Edit Role</h1>
    <form method="POST" action="{{ route('jobs.update', $job) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('jobs._form')
        <div style="margin-top: 28px; display: flex; gap: 14px; align-items: center;">
            <button type="submit"
                    style="background: #0f172a; color: white; border: none; padding: 16px 40px; border-radius: 16px; font-size: 15px; font-weight: 800; cursor: pointer; transition: all 0.2s; box-shadow: 0 10px 20px rgba(15,23,42,0.15);">
                Save Changes
            </button>
            <a href="{{ route('jobs.index') }}" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 700; margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobBoard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f4f6fb; display: flex; min-height: 100vh; color: #1e293b; }

        @guest
        .sidebar { display: none !important; }
        .main { margin-left: 0 !important; }
        .content { max-width: 1400px; margin: 0 auto; width: 100%; padding: 48px 60px !important; }
        .topbar { padding: 24px 60px !important; }
        @endguest

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 250px; background: #ffffff; min-height: 100vh;
            padding: 28px 16px; display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0;
            border-right: 1px solid #eef2f7;
            z-index: 100;
        }
        .sidebar-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 0 12px; margin-bottom: 36px;
            text-decoration: none;
        }
        .sidebar-logo-icon {
            width: 34px; height: 34px;
            background: #6366f1; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 900; font-size: 16px;
        }
        .sidebar-logo-text {
            font-size: 22px; font-weight: 900; color: #0f172a;
            letter-spacing: -0.5px;
        }
        .sidebar-logo-dot { color: #6366f1; }
        .nav-label {
            font-size: 10px; font-weight: 800; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 2px;
            padding: 0 12px; margin-bottom: 10px; margin-top: 28px;
        }
        .nav-label:first-of-type { margin-top: 0; }
        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border-radius: 12px;
            text-decoration: none; font-size: 14px; font-weight: 600;
            color: #64748b; margin-bottom: 4px; transition: all 0.15s;
        }
        .nav-link:hover { background: #f8fafc; color: #334155; }
        .nav-link.active { background: #eef2ff; color: #6366f1; }
        .nav-link svg { width: 20px; height: 20px; flex-shrink: 0; }
        .logout-btn {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border-radius: 12px;
            font-size: 14px; font-weight: 600; color: #ef4444;
            background: transparent; border: none; cursor: pointer;
            width: 100%; font-family: inherit; transition: all 0.15s;
        }
        .logout-btn:hover { background: #fef2f2; }
        .logout-btn svg { width: 20px; height: 20px; }

        /* ===== MAIN ===== */
        .main { margin-left: 250px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

        /* ===== TOPBAR ===== */
        .topbar {
            background: #ffffff; padding: 18px 32px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #eef2f7;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 20px; font-weight: 800; color: #0f172a; }
        .topbar-date { font-size: 13px; color: #94a3b8; font-weight: 500; margin-top: 3px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .badge {
            font-size: 11px; font-weight: 800; padding: 5px 14px;
            border-radius: 100px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .badge-admin { background: #fef2f2; color: #dc2626; }
        .badge-staff { background: #ecfdf5; color: #059669; }
        .badge-applicant { background: #eef2ff; color: #6366f1; }
        .avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: #6366f1; display: flex; align-items: center;
            justify-content: center; color: white; font-weight: 800; font-size: 15px;
        }
        .btn-signin {
            background: #6366f1; color: white; text-decoration: none;
            padding: 9px 22px; border-radius: 10px; font-weight: 700; font-size: 13px;
            transition: background 0.2s;
        }
        .btn-signin:hover { background: #4f46e5; }

        /* ===== CONTENT ===== */
        .content { padding: 40px; flex: 1; }
        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;
            padding: 14px 18px; border-radius: 14px; margin-bottom: 24px;
            font-size: 14px; font-weight: 600;
        }
        .alert-error {
            background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b;
            padding: 14px 18px; border-radius: 14px; margin-bottom: 24px;
            font-size: 14px; font-weight: 600;
        }
    </style>
</head>
<body>

@auth
<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="sidebar-logo">
        <div class="sidebar-logo-icon">J</div>
        <span class="sidebar-logo-text">JobBoard<span class="sidebar-logo-dot">.</span></span>
    </a>
    <br>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Dashboard
        </a>
        @else
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Dashboard
        </a>
        @endif
    @endauth

    <br>





    @auth
        @if(auth()->user()->isStaff() || auth()->user()->isAdmin())
        <a href="{{ route('jobs.create') }}" class="nav-link {{ request()->routeIs('jobs.create') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Post a Job
        </a>
        <a href="{{ route('applications.received') }}" class="nav-link {{ request()->routeIs('applications.received') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Applicants
        </a>
        @endif

        @if(auth()->user()->isApplicant())
        <a href="{{ route('applications.my') }}" class="nav-link {{ request()->routeIs('applications.my') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            My Applications
        </a>
        @endif


    <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #f1f5f9;">
        @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Log out
            </button>
        </form>
        @endauth
    </div>
</div>
@endauth

<!-- ===== MAIN CONTENT ===== -->
<div class="main">
    <!-- TOP BAR -->
    <div class="topbar">
        <div style="display: flex; align-items: center; gap: 24px;">
            @guest
            <a href="/" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                <div style="width: 30px; height: 30px; background: #6366f1; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 14px;">J</div>
                <span style="font-size: 18px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">JobBoard</span>
            </a>
            @endguest
            
            <div>
                @auth
                <div class="topbar-title">Welcome, {{ auth()->user()->name }}!</div>
                <div class="topbar-date">{{ now()->format('l, F d Y') }}</div>
                @else
                <!-- Guest Title Removed -->
                @endauth
            </div>
        </div>
        <div class="topbar-right">
            @auth
            <span class="badge badge-{{ auth()->user()->role == 'staff' ? 'staff' : auth()->user()->role }}">{{ auth()->user()->role == 'staff' ? 'Staff' : ucfirst(auth()->user()->role) }}</span>
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            @else
            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="/" style="font-size: 13px; font-weight: 700; color: #64748b; text-decoration: none; padding: 9px 16px; border-radius: 10px; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='transparent'">Home</a>
                <a href="{{ route('login') }}" class="btn-signin">Sign In</a>
            </div>
            @endauth
        </div>
    </div>

    <!-- PAGE CONTENT -->
    <div class="content">
        @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert-error">✕ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>
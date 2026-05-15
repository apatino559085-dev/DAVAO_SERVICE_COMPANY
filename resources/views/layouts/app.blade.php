<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Davao Central Services Company')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #022c22;
            --primary-light: #064e3b;
            --accent: #fbbf24;
            --bg: #f8fafc;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); display: flex; min-height: 100vh; color: #0f172a; overflow-x: hidden; }

        /* PREMIUM SIDEBAR */
        .sidebar { 
            width: 280px; 
            background: linear-gradient(180deg, #022c22 0%, #064e3b 100%); 
            display: flex; flex-direction: column; padding: 40px 24px; 
            position: fixed; top: 0; bottom: 0; z-index: 100;
            box-shadow: 10px 0 50px rgba(0,0,0,0.1);
        }

        .sidebar-logo { 
            display: flex; align-items: center; gap: 16px; margin-bottom: 48px; text-decoration: none;
        }
        .sidebar-logo img { width: 64px; height: 64px; border-radius: 50%; box-shadow: 0 8px 25px rgba(0,0,0,0.3); object-fit: cover; background: white; display: block; border: 2px solid rgba(255,255,255,0.1); }
        .sidebar-logo span { 
            font-size: 14px; font-weight: 900; color: var(--accent); 
            text-transform: uppercase; letter-spacing: 1.5px; line-height: 1.2;
        }

        .nav-link { 
            display: flex; align-items: center; gap: 14px; padding: 14px 18px; border-radius: 16px; 
            text-decoration: none; color: rgba(255,255,255,0.6); font-weight: 700; font-size: 14px; 
            margin-bottom: 8px; transition: all 0.3s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: white; transform: translateX(5px); }
        .nav-link.active { background: var(--accent); color: var(--primary); box-shadow: 0 10px 20px rgba(251, 191, 36, 0.2); }
        .nav-link svg { width: 20px; height: 20px; }

        .logout-link-premium { 
            margin-top: auto; display: flex; align-items: center; gap: 12px; 
            padding: 14px 18px; border-radius: 16px; color: #fca5a5; font-weight: 800; font-size: 14px;
            text-decoration: none; border: 1px solid rgba(252, 165, 165, 0.1); background: rgba(252, 165, 165, 0.05);
            cursor: pointer; transition: all 0.2s;
        }
        .logout-link-premium:hover { background: rgba(252, 165, 165, 0.15); color: #f87171; }
        .logout-link-premium svg { width: 18px; height: 18px; }

        /* MAIN */
        .main { margin-left: 280px; flex: 1; display: flex; flex-direction: column; }
        .topbar { 
            padding: 24px 48px; background: white; border-bottom: 1px solid #f1f5f9;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 90;
        }
        .content { padding: 48px; flex: 1; }

        .user-pill {
            display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 6px 16px; border-radius: 100px; border: 1px solid #e2e8f0;
        }
        .avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; }

        /* PAGINATION FIX */
        .pagination { display: flex; list-style: none; gap: 8px; margin: 0; padding: 0; }
        .pagination li a, .pagination li span { 
            padding: 8px 16px; border-radius: 10px; background: white; border: 1px solid #e2e8f0;
            color: #64748b; text-decoration: none; font-weight: 700; font-size: 13px;
        }
        .pagination li.active span { background: var(--primary); color: white; border-color: var(--primary); }
        .pagination li.disabled span { color: #cbd5e1; }
        .pagination svg { width: 16px; height: 16px; }

        @keyframes pulse-red {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        @media (max-width: 1024px) {
            .sidebar { width: 90px; padding: 32px 16px; }
            .sidebar-logo span, .nav-link span, .logout-btn span { display: none; }
            .main { margin-left: 90px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="/" class="sidebar-logo">
            <img src="{{ asset('images/logo%20(2).png') }}" alt="DCS Logo">
            <span>DAVAO CENTRAL<br>SERVICES</span>
        </a>

        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
            @endif
        @endauth

        <a href="{{ route('jobs.index') }}" class="nav-link {{ request()->routeIs('jobs.index') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span>Job Listings</span>
        </a>

        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isHR() || auth()->user()->role === 'staff' || auth()->user()->role === 'employer')
            @php
                $pendingCount = \App\Models\Application::where('status', 'pending')->count();
            @endphp
            <a href="{{ route('applications.received') }}" class="nav-link {{ request()->routeIs('applications.received') ? 'active' : '' }}" style="position: relative;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Applicants</span>
                @if($pendingCount > 0)
                    <span style="position: absolute; right: 12px; background: #ef4444; color: white; font-size: 10px; font-weight: 900; padding: 2px 8px; border-radius: 100px; box-shadow: 0 4px 10px rgba(239,68,68,0.4); animation: pulse-red 2s infinite; border: 2px solid var(--primary);">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
            @endif

            @if(auth()->user()->isAdmin())
            <a href="{{ route('applications.archived') }}" class="nav-link {{ request()->routeIs('applications.archived') || request()->routeIs('admin.archived-jobs') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                <span>Archive</span>
            </a>
            @endif

            @if(auth()->user()->isApplicant())
            <a href="{{ route('applications.my') }}" class="nav-link {{ request()->routeIs('applications.my') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>My Applications</span>
            </a>
            @endif
        @endauth

        @auth
            <a href="{{ route('logout') }}" class="logout-link-premium" style="margin-top: auto; text-decoration: none;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </a>
        @endauth
    </div>

    <div class="main">
        <div class="topbar">
            <h1 style="font-size: 20px; font-weight: 900; color: var(--primary);">@yield('title')</h1>
            
            @auth
            <div class="user-pill">
                <div style="text-align: right; margin-right: 12px;">
                    <div style="font-size: 13px; font-weight: 800;">{{ auth()->user()->name }}</div>
                    <div style="font-size: 10px; font-weight: 900; color: #ef4444; text-transform: uppercase;">{{ auth()->user()->role }}</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            </div>
            @endauth
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>
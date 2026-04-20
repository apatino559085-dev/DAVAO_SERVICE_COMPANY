<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Davao Job Portal - Find Your Next Role</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* CHADA Landing Page Design System */
        :root {
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.5);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --gradient-dark: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f1f4f9;
            min-height: 100vh;
            color: #1e293b;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Background Effects */
        .bg-shapes {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: float 20s infinite ease-in-out alternate;
        }

        .shape-1 {
            width: 500px; height: 500px;
            background: rgba(99, 102, 241, 0.3);
            top: -10%; left: -10%;
        }

        .shape-2 {
            width: 400px; height: 400px;
            background: rgba(168, 85, 247, 0.3);
            bottom: -5%; right: -5%;
            animation-delay: -5s;
        }
        
        .shape-3 {
            width: 600px; height: 600px;
            background: rgba(56, 189, 248, 0.2);
            top: 40%; left: 50%; transform: translateX(-50%);
            animation-delay: -10s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(50px, 50px) rotate(180deg); }
        }

        /* Navigation */
        nav {
            padding: 24px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 4px;
            overflow: hidden;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .btn-glass {
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.8);
            color: #0f172a;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        .btn-glass:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(99, 102, 241, 0.35);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 24px;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .badge {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.8);
            color: #6366f1;
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            animation: slideDown 0.5s ease-out;
        }

        .title {
            font-size: 72px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.1;
            letter-spacing: -2px;
            max-width: 800px;
            margin-bottom: 24px;
            animation: slideUp 0.6s ease-out;
        }

        .title span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 20px;
            font-weight: 500;
            color: #64748b;
            max-width: 600px;
            margin-bottom: 48px;
            line-height: 1.6;
            animation: slideUp 0.7s ease-out;
        }

        .search-container {
            background: white;
            padding: 12px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.8);
            animation: slideUp 0.8s ease-out;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 500;
            color: #0f172a;
            background: transparent;
        }

        .search-input::placeholder { color: #94a3b8; }

        .search-btn {
            background: #0f172a;
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-btn:hover { background: #1e293b; transform: scale(1.02); }

        .stats-row {
            display: flex;
            gap: 48px;
            margin-top: 60px;
            animation: slideUp 0.9s ease-out;
        }

        .stat-item { text-align: left; }
        .stat-value { font-size: 32px; font-weight: 900; color: #0f172a; line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: 13px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

        /* Floating Cards */
        .floating-card {
            position: absolute;
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.8);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 16px;
            animation: float 8s ease-in-out infinite alternate;
        }

        .fc-1 { top: 20%; left: 10%; animation-delay: -2s; }
        .fc-2 { bottom: 25%; right: 15%; animation-delay: -4s; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .title { font-size: 48px; }
            .nav-links .btn-glass { display: none; }
            .floating-card { display: none; }
            .stats-row { flex-direction: column; gap: 24px; text-align: center; }
            .stat-item { text-align: center; }
            nav { padding: 20px; }
            .hero { padding: 40px 20px; }
        }
    </style>
</head>
<body>

    <!-- Background Shapes -->
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <!-- Navigation -->
    <nav>
        <a href="/" class="logo-container">
            <div class="logo-icon">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
            </div>
            <div class="logo-text">Davao Jobs Portal</div>
        </a>

        @if (Route::has('login'))
            <div class="nav-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-glass">Sign In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Create Account</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <!-- Floating UI Elements for aesthetic -->
    <div class="floating-card fc-1 hidden md:flex">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981, #3b82f6); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Senior Developer</div>
            <div style="font-size: 12px; font-weight: 600; color: #64748b;">₱80,000 - ₱120,000</div>
        </div>
    </div>

    <div class="floating-card fc-2 hidden md:flex">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b, #ef4444); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white;">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div>
            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">Marketing Head</div>
            <div style="font-size: 12px; font-weight: 600; color: #64748b;">Just posted!</div>
        </div>
    </div>

    <!-- Hero Section -->
    <main class="hero">
        <div class="badge">
            <span style="display: block; width: 8px; height: 8px; background: #6366f1; border-radius: 50%; box-shadow: 0 0 8px #6366f1;"></span>
            The #1 Job Portal in Davao
        </div>

        <h1 class="title">
            Discover Your <span>Dream Career</span> Today
        </h1>

        <p class="subtitle">
            Connect with top employers in Davao. Whether you're looking for your first job or the next big step in your career, your journey starts here.
        </p>

        <form action="{{ route('jobs.index') }}" method="GET" class="search-container">
            <svg style="margin-left: 12px; color: #94a3b8;" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" class="search-input" placeholder="Job title, keyword, or company...">
            <button type="submit" class="search-btn">
                Search Roles
            </button>
        </form>

        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-value">1,000+</div>
                <div class="stat-label">Active Jobs</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">500+</div>
                <div class="stat-label">Top Companies</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </main>

</body>
</html>

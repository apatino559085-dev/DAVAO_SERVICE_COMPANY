<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobBoard — Find Your Dream Career</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #ffffff;
            color: #1a1a2e;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 32px; height: 72px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .logo {
            font-size: 24px; font-weight: 900;
            color: #1a1a2e; text-decoration: none;
            letter-spacing: -0.5px;
        }
        .logo-dot { color: #6366f1; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-link {
            font-size: 14px; font-weight: 600;
            color: #64748b; text-decoration: none;
            transition: color 0.2s;
        }
        .nav-link:hover { color: #1a1a2e; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 700; text-decoration: none;
            border-radius: 12px; transition: all 0.25s ease;
            cursor: pointer; border: none;
        }
        .btn-sm { font-size: 14px; padding: 10px 24px; }
        .btn-lg { font-size: 16px; padding: 16px 40px; }
        .btn-primary {
            background: #6366f1; color: #fff;
            box-shadow: 0 4px 14px rgba(99,102,241,0.35);
        }
        .btn-primary:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99,102,241,0.4);
        }
        .btn-outline {
            background: #fff; color: #1a1a2e;
            border: 2px solid #e2e8f0;
        }
        .btn-outline:hover {
            border-color: #6366f1; color: #6366f1;
            transform: translateY(-2px);
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center;
            padding: 120px 32px 80px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #f8faff 0%, #ffffff 100%);
        }
        .hero::before {
            content: '';
            position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background:
                radial-gradient(circle at 30% 40%, rgba(99,102,241,0.06) 0%, transparent 50%),
                radial-gradient(circle at 70% 60%, rgba(168,85,247,0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 20%, rgba(236,72,153,0.03) 0%, transparent 50%);
            animation: slowdrift 30s ease-in-out infinite alternate;
        }
        @keyframes slowdrift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-2%, 2%) rotate(3deg); }
        }
        .hero-inner { position: relative; z-index: 2; max-width: 820px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: #eef2ff; color: #6366f1;
            font-size: 12px; font-weight: 800;
            padding: 8px 20px; border-radius: 100px;
            letter-spacing: 0.5px; margin-bottom: 32px;
            border: 1px solid rgba(99,102,241,0.15);
        }
        .hero-badge-dot {
            width: 6px; height: 6px;
            background: #6366f1; border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.5); }
        }
        .hero-title {
            font-size: clamp(40px, 7vw, 72px);
            font-weight: 900; line-height: 1.05;
            letter-spacing: -2px; margin-bottom: 28px;
            color: #0f172a;
        }
        .hero-title-accent {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-desc {
            font-size: 18px; color: #64748b;
            max-width: 560px; margin: 0 auto 48px;
            line-height: 1.7; font-weight: 500;
        }
        .hero-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }

        /* ===== STATS BAR ===== */
        .stats-bar {
            margin-top: 72px;
            display: flex; justify-content: center; gap: 48px;
            flex-wrap: wrap;
        }
        .stat { text-align: center; }
        .stat-number {
            font-size: 32px; font-weight: 900;
            color: #0f172a; letter-spacing: -1px;
        }
        .stat-label {
            font-size: 13px; font-weight: 600;
            color: #94a3b8; margin-top: 4px;
        }

        /* ===== LOGOS ===== */
        .logos-section {
            padding: 64px 32px;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
            background: #fafbfc;
        }
        .logos-label {
            text-align: center; font-size: 11px; font-weight: 800;
            color: #94a3b8; letter-spacing: 3px;
            text-transform: uppercase; margin-bottom: 36px;
        }
        .logos-grid {
            display: flex; flex-wrap: wrap;
            justify-content: center; align-items: center;
            gap: 48px; opacity: 0.35;
        }
        .logos-grid span {
            font-size: 18px; font-weight: 900;
            letter-spacing: 3px; text-transform: uppercase;
        }

        /* ===== FEATURES ===== */
        .features {
            max-width: 1200px; margin: 0 auto;
            padding: 120px 32px;
        }
        .features-header {
            text-align: center; margin-bottom: 72px;
        }
        .features-title {
            font-size: 40px; font-weight: 900;
            letter-spacing: -1px; margin-bottom: 16px;
            color: #0f172a;
        }
        .features-desc {
            font-size: 18px; color: #64748b;
            max-width: 500px; margin: 0 auto;
            font-weight: 500;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
        }
        .feature-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 28px;
            padding: 44px 36px;
            transition: all 0.35s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px -15px rgba(99,102,241,0.12);
            border-color: #e0e7ff;
        }
        .feature-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 28px;
        }
        .feature-icon-blue { background: #eef2ff; }
        .feature-icon-purple { background: #faf5ff; }
        .feature-icon-pink { background: #fdf2f8; }
        .feature-name {
            font-size: 20px; font-weight: 800;
            margin-bottom: 12px; color: #0f172a;
        }
        .feature-text {
            font-size: 15px; color: #64748b;
            line-height: 1.7; font-weight: 500;
        }

        /* ===== CTA ===== */
        .cta-section { padding: 40px 32px 120px; }
        .cta-box {
            max-width: 1000px; margin: 0 auto;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 40px;
            padding: 80px 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-box::before {
            content: '';
            position: absolute; top: -100px; right: -100px;
            width: 400px; height: 400px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        .cta-box::after {
            content: '';
            position: absolute; bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .cta-title {
            font-size: 42px; font-weight: 900;
            color: #fff; margin-bottom: 20px;
            letter-spacing: -1px;
            position: relative; z-index: 2;
        }
        .cta-desc {
            font-size: 18px; color: rgba(255,255,255,0.7);
            max-width: 460px; margin: 0 auto 40px;
            font-weight: 500;
            position: relative; z-index: 2;
        }
        .btn-white {
            display: inline-flex; align-items: center; justify-content: center;
            background: #fff; color: #4f46e5;
            font-size: 16px; font-weight: 800;
            padding: 18px 44px; border-radius: 16px;
            text-decoration: none;
            transition: all 0.25s ease;
            position: relative; z-index: 2;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .btn-white:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        /* ===== FOOTER ===== */
        .footer {
            padding: 48px 32px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            color: #94a3b8;
            font-size: 14px; font-weight: 600;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .nav-links a:not(.btn) { display: none; }
            .hero { padding: 100px 20px 60px; }
            .hero-title { letter-spacing: -1px; }
            .stats-bar { gap: 32px; }
            .features { padding: 80px 20px; }
            .cta-box { padding: 60px 28px; border-radius: 28px; }
            .cta-title { font-size: 32px; }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo">JobBoard<span class="logo-dot">.</span></a>
            <div class="nav-links">
                <a href="{{ route('jobs.index') }}" class="nav-link">Browse Jobs</a>
                @auth
                    <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Get Started Free</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                TRUSTED BY 10,000+ PROFESSIONALS
            </div>

            <h1 class="hero-title">
                Find Your Next<br>
                <span class="hero-title-accent">Dream Career.</span>
            </h1>

            <p class="hero-desc">
                We connect world-class talent with the most innovative companies.
                Your next opportunity is one click away.
            </p>

            <div class="hero-buttons">
                <a href="{{ route('jobs.index') }}" class="btn btn-lg btn-primary">Explore Vacancies</a>
                <a href="{{ route('register') }}" class="btn btn-lg btn-outline">Post a Job</a>
            </div>

            <div class="stats-bar">
                <div class="stat">
                    <div class="stat-number">{{ \App\Models\JobPost::count() }}+</div>
                    <div class="stat-label">Active Jobs</div>
                </div>
                <div class="stat">
                    <div class="stat-number">{{ \App\Models\User::count() }}+</div>
                    <div class="stat-label">Registered Users</div>
                </div>
                <div class="stat">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>



    <!-- ===== FEATURES ===== -->
    <section class="features">
        <div class="features-header">
            <h2 class="features-title">Everything you need.</h2>
            <p class="features-desc">Built for speed, simplicity, and results. Here is why seekers and staff love us.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon feature-icon-blue">⚡</div>
                <h3 class="feature-name">Instant Apply</h3>
                <p class="feature-text">Apply to premium roles with a single click. Save your profile and skip the repetitive forms forever.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon feature-icon-purple">🌍</div>
                <h3 class="feature-name">Global Reach</h3>
                <p class="feature-text">Access curated job listings from top companies across every industry and location around the globe.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon feature-icon-pink">🔒</div>
                <h3 class="feature-name">Verified Staff</h3>
                <p class="feature-text">We manually vet every company on our platform so you only engage with legitimate opportunities.</p>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta-section">
        <div class="cta-box">
            <h2 class="cta-title">Ready to get started?</h2>
            <p class="cta-desc">Create your free account today and start applying to top companies in minutes.</p>
            <a href="{{ route('register') }}" class="btn-white">Create Free Account →</a>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        © {{ date('Y') }} JobBoard. All rights reserved.
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Davao Central Services Company | Hiring Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #022c22;
            --primary-light: #064e3b;
            --accent: #fbbf24;
            --text-dark: #0f172a;
            --text-light: #64748b;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Background Glows */
        .ambient-glow-1 {
            position: absolute; top: -150px; left: -100px; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 60%);
            border-radius: 50%; z-index: -1;
        }
        .ambient-glow-2 {
            position: absolute; bottom: -200px; right: -100px; width: 800px; height: 800px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.08) 0%, transparent 60%);
            border-radius: 50%; z-index: -1;
        }

        /* Navigation */
        nav {
            padding: 24px 60px; display: flex; justify-content: space-between; align-items: center;
            max-width: 1400px; margin: 0 auto; width: 100%; position: relative; z-index: 10;
        }

        .logo-container {
            display: flex; align-items: center; gap: 12px; text-decoration: none;
        }

        .logo-icon {
            width: 48px; height: 48px; border-radius: 50%; overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 2px solid white;
        }
        .logo-icon img { width: 100%; height: 100%; object-fit: contain; }

        .logo-text { font-size: 16px; font-weight: 900; color: var(--primary-dark); letter-spacing: -0.5px; text-transform: uppercase;}

        .nav-links { display: flex; gap: 16px; align-items: center; }

        .btn-outline {
            background: white; border: 2px solid #e2e8f0; color: var(--text-dark);
            padding: 12px 28px; border-radius: 14px; font-size: 14px; font-weight: 800;
            text-decoration: none; transition: all 0.3s;
        }
        .btn-outline:hover { border-color: var(--primary-dark); color: var(--primary-dark); transform: translateY(-2px); }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            color: var(--accent); padding: 14px 32px; border-radius: 14px; font-size: 14px; font-weight: 900;
            text-decoration: none; transition: all 0.3s; box-shadow: 0 10px 25px rgba(2, 44, 34, 0.2);
            border: 1px solid rgba(251, 191, 36, 0.2);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(2, 44, 34, 0.3); }

        /* Main Hero Split */
        .hero {
            flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 60px;
            max-width: 1400px; margin: 0 auto; width: 100%; padding: 40px 60px;
            align-items: center; position: relative; z-index: 10;
        }

        /* Left Side: Copy */
        .hero-content {
            padding-right: 40px;
            animation: slideRight 0.8s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        .badge {
            background: #f1f5f9; border: 1px solid #e2e8f0; color: var(--primary-light);
            padding: 8px 16px; border-radius: 100px; font-size: 11px; font-weight: 900;
            text-transform: uppercase; letter-spacing: 2px; margin-bottom: 32px;
            display: inline-flex; align-items: center; gap: 8px;
        }

        .title {
            font-size: 64px; font-weight: 900; color: var(--primary-dark);
            line-height: 1.1; letter-spacing: -2px; margin-bottom: 24px;
        }
        .title span { color: #10b981; }

        .subtitle {
            font-size: 18px; font-weight: 500; color: var(--text-light);
            margin-bottom: 48px; line-height: 1.6; max-width: 500px;
        }

        .action-group { display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }

        /* Right Side: The Giant Logo */
        .hero-visual {
            display: flex; justify-content: center; align-items: center; position: relative;
            animation: fadeInScale 1s cubic-bezier(0.4, 0, 0.2, 1) both 0.2s;
        }

        .giant-logo-container {
            width: 600px; height: 600px; border-radius: 50%;
            background: white;
            box-shadow: 
                0 0 0 1px rgba(16, 185, 129, 0.1),
                0 40px 80px -20px rgba(2, 44, 34, 0.15),
                inset 0 0 60px rgba(0,0,0,0.02);
            display: flex; align-items: center; justify-content: center; padding: 40px;
            position: relative;
        }

        /* Decorative orbiting rings around the logo */
        .giant-logo-container::before {
            content: ''; position: absolute; inset: -40px; border-radius: 50%;
            border: 2px dashed rgba(16, 185, 129, 0.2);
            animation: spin 60s linear infinite;
        }
        .giant-logo-container::after {
            content: ''; position: absolute; inset: -80px; border-radius: 50%;
            border: 1px solid rgba(251, 191, 36, 0.3);
            animation: spin 90s linear infinite reverse;
        }

        .giant-logo-container img {
            width: 100%; height: 100%; object-fit: contain;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.1));
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .giant-logo-container:hover img {
            transform: scale(1.05);
        }

        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        @media (max-width: 1024px) {
            .hero { grid-template-columns: 1fr; text-align: center; gap: 40px; padding: 20px; }
            .hero-content { padding-right: 0; display: flex; flex-direction: column; align-items: center; }
            .title { font-size: 48px; }
            .giant-logo-container { width: 400px; height: 400px; }
            nav { padding: 20px; flex-direction: column; gap: 20px; }
        }
    </style>
</head>
<body>

    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <nav>
        <a href="/" class="logo-container">
            <div class="logo-icon">
                <img src="{{ asset('images/logo (2).png') }}" alt="Logo" onerror="this.style.display='none'">
            </div>
            <div class="logo-text">Davao Central Services</div>
        </a>

        @if (Route::has('login'))
            <div class="nav-links">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="btn-primary">
                        Enter System Workspace →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline">Sign In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Start Your Journey</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <main class="hero">
        <div class="hero-content">
            <div class="badge">
                <span style="width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
                Hiring Management System
            </div>

            <h1 class="title">
                Shaping Our<br>
                <span>Future Leaders.</span>
            </h1>

            <p class="subtitle">
                We connect dedicated professionals with the best opportunities in the service industry. Start building your future with the Davao Central Services Company today.
            </p>

            <div class="action-group">
                <a href="{{ route('jobs.index') }}" class="btn-primary" style="padding: 16px 36px; font-size: 16px;">
                    Browse Vacancies
                </a>
                @if(!auth()->check())
                <a href="{{ route('register') }}" class="btn-outline" style="padding: 16px 36px; font-size: 16px;">
                    Become a Partner
                </a>
                @endif
            </div>
        </div>

        <div class="hero-visual">
            <div class="giant-logo-container">
                <img src="{{ asset('images/logo (2).png') }}" alt="Davao Central Services Company Giant Logo">
            </div>
        </div>
    </main>

    <div style="text-align: center; padding: 24px; font-size: 12px; font-weight: 600; color: #94a3b8; position: relative; z-index: 10;">
        &copy; {{ date('Y') }} Davao Central Services Company Hiring Management System. All rights reserved.
    </div>

</body>
</html>

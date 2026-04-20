<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Davao Job Portal — Empowering Davao's Digital Future</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #a855f7;
            --bg: #f1f4f9;        /* Matches dashboard */
            --text-main: #0f172a; /* Dark text for light mode */
            --text-muted: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.5);
            --glass-shadow: 0 10px 40px 0 rgba(31, 38, 135, 0.05);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            overflow: hidden;
            position: relative;
            height: 100vh;
        }

        /* Background Effects */
        .ambient-blob {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            opacity: 0.4;
            pointer-events: none;
            animation: float-blob 20s infinite ease-in-out alternate;
        }
        .blob-1 { top: -10%; left: -10%; background: rgba(99, 102, 241, 0.3); }
        .blob-2 { bottom: -10%; right: -10%; background: rgba(168, 85, 247, 0.3); animation-delay: -5s; }
        
        @keyframes float-blob {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(50px, 50px) rotate(180deg); }
        }

        /* Navbar */
        .nav {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            padding: 24px 0; transition: all 0.3s ease;
        }
        .nav.scrolled {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        .nav.scrolled .logo-box {
            width: 50px; height: 50px;
            border-radius: 50%;
        }
        .nav-content {
            max-width: 1200px; margin: 0 auto; padding: 0 40px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .logo {
            text-decoration: none; display: flex; align-items: center; gap: 12px;
        }
        .logo-box {
            width: 64px; height: 64px; background: white;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden; padding: 4px; border: 1px solid var(--glass-border);
            transition: all 0.3s;
        }
        .logo-box img { width: 100%; height: 100%; object-fit: contain; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-link {
            color: var(--text-muted); text-decoration: none; font-weight: 700; font-size: 14px;
            transition: color 0.2s;
        }
        .nav-link:hover { color: var(--primary); }
        .btn {
            padding: 12px 28px; border-radius: 12px; font-weight: 700; font-size: 14px;
            text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex; align-items: center; gap: 8px; cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.5); }
        .btn-outline {
            background: var(--glass-bg); backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border); color: var(--text-main);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        .btn-outline:hover { background: white; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }

        /* Hero */
        .hero {
            position: relative; height: calc(100vh - 50px); display: flex; align-items: center;
            padding: 100px 40px 40px;
        }
        .hero-container {
            max-width: 1200px; margin: 0 auto; display: grid;
            grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: white; border: 1px solid rgba(99, 102, 241, 0.2);
            color: var(--primary); padding: 8px 16px; border-radius: 100px;
            font-size: 12px; font-weight: 800; margin-bottom: 24px;
            text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        .hero-title {
            font-size: clamp(40px, 5.5vw, 64px); color: var(--text-main); font-weight: 900;
            line-height: 1.1; margin-bottom: 24px; letter-spacing: -2px;
        }
        .text-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            font-size: 18px; color: var(--text-muted); margin-bottom: 40px;
            max-width: 500px; font-weight: 500; line-height: 1.6;
        }
        .hero-visual { position: relative; }
        .hero-image-card {
            background: white; border: 1px solid rgba(0,0,0,0.05);
            padding: 12px; border-radius: 32px; box-shadow: 0 30px 60px rgba(0,0,0,0.08);
            transform: rotate(2deg); transition: transform 0.5s;
        }
        .hero-image-card:hover { transform: rotate(0deg); }
        .hero-image-card img { width: 100%; border-radius: 20px; display: block; }

        /* Sections */
        .section { padding: 100px 40px; }
        .section-container { max-width: 1200px; margin: 0 auto; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        
        .card {
            background: var(--glass-bg); backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border); box-shadow: var(--glass-shadow);
            padding: 48px; border-radius: 32px; height: 100%; transition: all 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); background: white; }
        
        .tag {
            font-size: 12px; font-weight: 800; color: var(--primary);
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; display: inline-block;
            background: rgba(99,102,241,0.1); padding: 6px 14px; border-radius: 100px;
        }
        .h2 { font-size: 32px; font-weight: 900; color: var(--text-main); margin-bottom: 24px; letter-spacing: -1px; }
        .p { font-size: 16px; color: var(--text-muted); font-weight: 500; margin-bottom: 24px; line-height: 1.6;}

        /* Vision/Mission List */
        .list { list-style: none; margin-top: 24px; }
        .list-item { display: flex; gap: 16px; margin-bottom: 16px; align-items: center; }
        .list-icon {
            width: 32px; height: 32px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 10px; color: var(--primary); display: flex;
            align-items: center; justify-content: center; font-size: 14px; font-weight: 900; flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .list-text { font-weight: 700; color: var(--text-main); font-size: 15px; }

        /* Footer */
        .footer { padding: 16px 40px; text-align: center; border-top: 1px solid rgba(0,0,0,0.05); position: fixed; bottom: 0; left: 0; right: 0; z-index: 10; }
        .copy { color: var(--text-muted); font-size: 14px; font-weight: 600; }

        /* Landing Modals */
        .landing-modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15, 23, 42, 0.55); backdrop-filter: blur(10px);
            z-index: 9999; align-items: center; justify-content: center; padding: 24px;
        }
        .landing-modal-overlay.active { display: flex; }
        .landing-modal {
            background: white; width: 100%; max-width: 520px;
            border-radius: 28px; overflow: hidden;
            box-shadow: 0 25px 60px -12px rgba(0,0,0,0.25);
            transform: scale(0.95); opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .landing-modal-overlay.active .landing-modal {
            transform: scale(1); opacity: 1;
        }
        .landing-modal-header {
            padding: 32px 32px 0; display: flex; align-items: flex-start;
            justify-content: space-between;
        }
        .landing-modal-icon {
            width: 56px; height: 56px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
        }
        .landing-modal-close {
            width: 36px; height: 36px; border-radius: 50%; background: #f8fafc;
            border: none; color: #94a3b8; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s; flex-shrink: 0;
        }
        .landing-modal-close:hover { background: #f1f5f9; color: #0f172a; }
        .landing-modal-body { padding: 24px 32px 32px; }
        .landing-modal-body h2 {
            font-size: 24px; font-weight: 900; color: #0f172a;
            margin-bottom: 16px; letter-spacing: -0.5px;
        }
        .landing-modal-body p {
            font-size: 15px; color: #64748b; line-height: 1.7;
            font-weight: 500; margin-bottom: 12px;
        }
        .landing-modal-body ul {
            list-style: none; margin-top: 16px;
        }
        .landing-modal-body ul li {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 0; font-size: 14px; font-weight: 700;
            color: #334155;
        }
        .landing-modal-body ul li .li-icon {
            width: 28px; height: 28px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 900; flex-shrink: 0;
        }
        .landing-modal-footer {
            padding: 0 32px 32px;
        }
        .landing-modal-footer button {
            width: 100%; padding: 14px; border-radius: 14px;
            background: #0f172a; color: white; border: none;
            font-size: 14px; font-weight: 800; cursor: pointer;
            transition: background 0.2s; font-family: inherit;
        }
        .landing-modal-footer button:hover { background: #1e293b; }

        @media (max-width: 968px) {
            .hero-container, .grid-2 { grid-template-columns: 1fr; }
            .hero-visual { order: -1; }
            .hero { padding-top: 140px; text-align: center; }
            .hero-desc { margin-left: auto; margin-right: auto; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <!-- Navigation -->
    <nav class="nav" id="navbar">
        <div class="nav-content">
            <a href="/" class="logo">
                <div class="logo-box">
                    <img src="{{ asset('images/logo.png') }}" alt="Davao Job Portal Logo">
                </div>
                <div style="font-weight: 900; font-size: 20px; color: var(--text-main); letter-spacing: -0.5px;">Davao Job Portal</div>
            </a>
            <div class="nav-links">
                <a href="javascript:void(0)" onclick="openLandingModal('opportunities')" class="nav-link">Opportunities</a>
                <a href="javascript:void(0)" onclick="openLandingModal('company')" class="nav-link">The Company</a>
                <a href="javascript:void(0)" onclick="openLandingModal('vision')" class="nav-link">Our Vision</a>
                @auth
                    <a href="{{ route('home') }}" class="btn btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Start Your Journey</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-text">
                <div class="hero-badge">⚡ Join Davao's Tech Revolution</div>
                <h1 class="hero-title">
                    Empowering Davao's <br>
                    <span class="text-gradient">Digital Dreams.</span>
                </h1>
                <p class="hero-desc">
                    We connect Mindanao's most talented professionals with innovative digital solutions. Start building the future of Davao City with us.
                </p>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">Browse Vacancies</a>
                    <a href="{{ route('register') }}" class="btn btn-outline">Become a Partner</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image-card">
                    <img src="{{ asset('images/hero_pro.png') }}" alt="Davao Tech Office">
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer class="footer">
        <div class="copy">
            &copy; {{ date('Y') }} Davao Job Portal. All rights reserved.
        </div>
    </footer>

    <!-- MODALS -->
    <div class="landing-modal-overlay" id="landingModalOverlay" onclick="if(event.target===this)closeLandingModal()">
        <div class="landing-modal">
            <div class="landing-modal-header">
                <div class="landing-modal-icon" id="lmIcon"></div>
                <button class="landing-modal-close" onclick="closeLandingModal()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="landing-modal-body" id="lmBody"></div>
            <div class="landing-modal-footer">
                <button onclick="closeLandingModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        const landingModals = {
            opportunities: {
                iconBg: '#eef2ff',
                iconSvg: '<svg width="28" height="28" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                html: '<h2>Opportunities</h2>'
                    + '<p>Davao Job Portal connects you with the best career opportunities across Mindanao. Whether you\'re a fresh graduate or a seasoned professional, we have roles tailored to your ambitions.</p>'
                    + '<ul>'
                    + '<li><span class="li-icon" style="background:#eef2ff;color:#6366f1;">✦</span> Technology & Software Development</li>'
                    + '<li><span class="li-icon" style="background:#ecfdf5;color:#059669;">✦</span> Healthcare & Medical Services</li>'
                    + '<li><span class="li-icon" style="background:#fffbeb;color:#b45309;">✦</span> Finance, Retail & Hospitality</li>'
                    + '<li><span class="li-icon" style="background:#fdf2f8;color:#be185d;">✦</span> Education & Creative Industries</li>'
                    + '</ul>'
                    + '<p style="margin-top:16px;">Browse our full catalog and find the role that launches your next chapter.</p>'
            },
            company: {
                iconBg: '#f5f3ff',
                iconSvg: '<svg width="28" height="28" fill="none" stroke="#a855f7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
                html: '<h2>The Company</h2>'
                    + '<p><strong>Davao Digital Solutions Inc.</strong> is a startup technology company located in Davao City that provides digital services to local businesses.</p>'
                    + '<p>We focus on helping small and medium enterprises (SMEs) transition into the digital world by offering web development, job posting systems, and business management tools.</p>'
                    + '<p>Our company aims to support the growing business community in Davao by providing affordable, reliable, and user-friendly technology solutions that make a real difference.</p>'
            },
            vision: {
                iconBg: '#ecfdf5',
                iconSvg: '<svg width="28" height="28" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>',
                html: '<h2>Vision & Mission</h2>'
                    + '<p><strong>Our Vision:</strong> To become one of the leading IT solution providers in Mindanao by empowering local businesses through innovative digital platforms.</p>'
                    + '<p style="margin-bottom:4px;"><strong>Our Mission:</strong></p>'
                    + '<ul>'
                    + '<li><span class="li-icon" style="background:#ecfdf5;color:#059669;">✓</span> Deliver high-quality and affordable IT solutions</li>'
                    + '<li><span class="li-icon" style="background:#ecfdf5;color:#059669;">✓</span> Support local businesses in digital transformation</li>'
                    + '<li><span class="li-icon" style="background:#ecfdf5;color:#059669;">✓</span> Provide excellent customer service & technical support</li>'
                    + '</ul>'
            }
        };

        function openLandingModal(key) {
            const data = landingModals[key];
            const overlay = document.getElementById('landingModalOverlay');
            const icon = document.getElementById('lmIcon');
            const body = document.getElementById('lmBody');

            icon.style.background = data.iconBg;
            icon.innerHTML = data.iconSvg;
            body.innerHTML = data.html;

            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLandingModal() {
            document.getElementById('landingModalOverlay').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLandingModal();
        });
    </script>
</body>
</html>

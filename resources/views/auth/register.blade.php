<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Davao Central Services Company Hiring Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-light: #f8fafc;
            --primary-dark: #022c22;
            --primary-light: #064e3b;
            --accent: #10b981;
            --text-dark: #0f172a;
            --text-light: #64748b;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg-light);
            color: var(--text-dark);
            position: relative; overflow-x: hidden;
            padding: 40px 20px;
        }

        /* Ambient Glows & Grid */
        .ambient-glow-1 {
            position: fixed; top: -20%; left: -10%; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 60%);
            border-radius: 50%; z-index: -1; animation: float 12s ease-in-out infinite alternate;
        }
        .ambient-glow-2 {
            position: fixed; bottom: -20%; right: -10%; width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 60%);
            border-radius: 50%; z-index: -1; animation: float 10s ease-in-out infinite alternate-reverse;
        }
        .grid-overlay {
            position: fixed; inset: 0; z-index: -1; opacity: 0.3;
            background-image: linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at center, black 40%, transparent 90%);
            -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 90%);
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        /* Centered Card */
        .register-card {
            background: white;
            width: 100%; max-width: 500px;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05), 0 0 0 1px rgba(0,0,0,0.02);
            position: relative; z-index: 10;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-container {
            display: flex; justify-content: center; margin-bottom: 32px;
        }
        .logo-box {
            width: 80px; height: 80px; border-radius: 50%;
            background: white; border: 2px solid white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .logo-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

        .form-heading {
            text-align: center; font-size: 28px; font-weight: 900;
            color: var(--text-dark); letter-spacing: -0.5px; margin-bottom: 8px;
        }
        .form-sub {
            text-align: center; font-size: 15px; color: var(--text-light);
            font-weight: 500; margin-bottom: 36px;
        }

        .field { margin-bottom: 18px; }
        .field-label {
            display: block; font-size: 13px; font-weight: 700;
            color: #334155; margin-bottom: 8px;
        }
        .field-input {
            width: 100%; padding: 14px 16px;
            border: 2px solid #e2e8f0; border-radius: 12px;
            font-size: 15px; font-weight: 500; color: var(--text-dark);
            background: #f8fafc; outline: none; font-family: inherit;
            transition: all 0.2s;
        }
        .field-input:focus {
            background: white; border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
        .field-input::placeholder { color: #cbd5e1; font-weight: 400; }
        .field-error { font-size: 12px; font-weight: 600; color: #ef4444; margin-top: 6px; }

        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .submit-btn {
            width: 100%; padding: 16px; margin-top: 12px;
            background: var(--primary-dark); color: white;
            border: none; border-radius: 12px; font-size: 15px; font-weight: 800;
            cursor: pointer; transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(2, 44, 34, 0.15);
        }
        .submit-btn:hover {
            background: var(--primary-light); transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(2, 44, 34, 0.2);
        }

        .divider {
            display: flex; align-items: center; gap: 16px; margin: 32px 0;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
        .divider-text { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

        .bottom-text { text-align: center; font-size: 14px; font-weight: 600; color: #64748b; }
        .bottom-link { color: var(--primary-dark); text-decoration: none; font-weight: 800; }
        .bottom-link:hover { text-decoration: underline; }

        .back-home {
            position: fixed; top: 32px; left: 32px;
            display: flex; align-items: center; gap: 8px;
            font-size: 14px; font-weight: 700; color: var(--text-light); text-decoration: none;
            transition: color 0.2s; z-index: 20;
        }
        .back-home:hover { color: var(--text-dark); }
        .back-home svg { width: 20px; height: 20px; }

        @media (max-width: 600px) {
            .field-row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>

    <div class="grid-overlay"></div>
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <a href="/" class="back-home">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Home
    </a>

    <div class="register-card">
        <div class="logo-container">
            <div class="logo-box">
                <img src="{{ asset('images/logo (2).png') }}" alt="Logo">
            </div>
        </div>

        <h1 class="form-heading">Create your account</h1>
        <p class="form-sub">Start your career with us today</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field-row">
                <div class="field">
                    <label class="field-label" for="name">Full Name</label>
                    <input id="name" class="field-input" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Juan Dela Cruz">
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label class="field-label" for="email">Email</label>
                    <input id="email" class="field-input" type="email" name="email" value="{{ old('email') }}" required placeholder="you@email.com">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="field">
                <label class="field-label" for="address">Address</label>
                <input id="address" class="field-input" type="text" name="address" value="{{ old('address') }}" required placeholder="Your Complete Address">
                @error('address') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <!-- Default Role Hidden -->
            <input type="hidden" name="role" value="applicant">

            <div class="field-row">
                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <input id="password" class="field-input" type="password" name="password" required placeholder="••••••••">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="field-input" type="password" name="password_confirmation" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="submit-btn">Create Account</button>
        </form>

        <div class="divider">
            <span class="divider-text">Already a member?</span>
        </div>

        <p class="bottom-text">
            <a href="{{ route('login') }}" class="bottom-link">← Sign in instead</a>
        </p>
    </div>

</body>
</html>
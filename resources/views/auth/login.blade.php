<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Davao Job Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #f1f4f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
            color: #0f172a;
        }

        /* Ambient background */
        body::before {
            content: '';
            position: fixed; top: -10%; left: -10%;
            width: 500px; height: 500px;
            background: rgba(99, 102, 241, 0.3); border-radius: 50%;
            filter: blur(120px); opacity: 0.6;
        }
        body::after {
            content: '';
            position: fixed; bottom: -10%; right: -10%;
            width: 400px; height: 400px;
            background: rgba(168, 85, 247, 0.3); border-radius: 50%;
            filter: blur(120px); opacity: 0.6;
        }

        .login-card {
            width: 100%; max-width: 440px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px 0 rgba(31, 38, 135, 0.05);
            border-radius: 32px;
            padding: 48px 40px;
            position: relative;
            z-index: 1;
        }

        /* Logo */
        .logo-wrap {
            text-align: center;
            margin-bottom: 36px;
            text-decoration: none;
            display: block;
        }
        .logo-img {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: white;
            padding: 8px;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            display: block;
            object-fit: contain;
            border: 1px solid rgba(255,255,255,0.8);
        }
        .logo-title {
            font-size: 13px; font-weight: 800;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Heading */
        .form-heading {
            font-size: 28px; font-weight: 900;
            color: #0f172a; text-align: center;
            margin-bottom: 6px; letter-spacing: -0.5px;
        }
        .form-sub {
            font-size: 14px; color: #64748b;
            text-align: center; font-weight: 500;
            margin-bottom: 36px;
        }

        /* Status */
        .status-msg {
            background: #ecfdf5; border: 1px solid #a7f3d0;
            color: #059669; padding: 12px 16px; border-radius: 14px;
            font-size: 13px; font-weight: 700; margin-bottom: 24px; text-align: center;
        }

        /* Fields */
        .field { margin-bottom: 20px; }
        .field-label {
            display: block; font-size: 12px; font-weight: 800;
            color: #475569; margin-bottom: 8px;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .field-input {
            width: 100%; padding: 14px 18px;
            border: 1px solid #cbd5e1;
            border-radius: 14px; font-size: 15px; font-weight: 500;
            color: #0f172a; background: white;
            outline: none; font-family: inherit;
            transition: all 0.2s;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        .field-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }
        .field-input::placeholder { color: #94a3b8; }
        .field-error {
            font-size: 12px; font-weight: 700;
            color: #ef4444; margin-top: 6px;
        }

        /* Password header */
        .field-header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 8px;
        }
        .field-header .field-label { margin-bottom: 0; }
        .forgot-link {
            font-size: 12px; font-weight: 700;
            color: #6366f1; text-decoration: none;
        }
        .forgot-link:hover { color: #4f46e5; text-decoration: underline; }

        /* Submit */
        .submit-btn {
            width: 100%; padding: 16px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white; border: none; border-radius: 14px;
            font-size: 15px; font-weight: 800;
            font-family: inherit; cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 8px 24px rgba(99,102,241,0.25);
            margin-top: 12px;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(99,102,241,0.35);
        }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 16px;
            margin: 28px 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px;
            background: #e2e8f0;
        }
        .divider-text {
            font-size: 12px; font-weight: 700;
            color: #64748b; text-transform: uppercase; letter-spacing: 1px;
        }

        /* Bottom */
        .bottom-text { text-align: center; font-size: 14px; font-weight: 600; color: #64748b; }
        .bottom-link { color: #6366f1; text-decoration: none; font-weight: 800; }
        .bottom-link:hover { color: #4f46e5; text-decoration: underline; }

        @media (max-width: 500px) {
            .login-card { padding: 36px 24px; border-radius: 24px; }
            .form-heading { font-size: 24px; }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logo -->
        <a href="/" class="logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="Davao Jobs Portal" class="logo-img">
            <div class="logo-title">Connecting Careers</div>
        </a>

        <h1 class="form-heading">Welcome back</h1>
        <p class="form-sub">Sign in to your account to continue</p>

        @if(session('status'))
            <div class="status-msg">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label class="field-label" for="email">Email</label>
                <input id="email" class="field-input" type="email" name="email"
                       value="{{ old('email') }}" required autofocus
                       placeholder="you@example.com">
                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <div class="field-header">
                    <label class="field-label" for="password">Password</label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot?</a>
                    @endif
                </div>
                <input id="password" class="field-input" type="password" name="password"
                       required placeholder="••••••••">
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-btn">Sign In</button>
        </form>

        <div class="divider">
            <span class="divider-text">New here?</span>
        </div>

        <p class="bottom-text">
            <a href="{{ route('register') }}" class="bottom-link">Create a free account →</a>
        </p>
    </div>

</body>
</html>
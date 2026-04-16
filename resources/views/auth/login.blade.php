<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — JobBoard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0f2f7;
        }

        /* ===== LEFT PANEL (Branding) ===== */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #a855f7 100%);
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute; top: -120px; right: -120px;
            width: 400px; height: 400px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute; bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .left-logo {
            font-size: 32px; font-weight: 900;
            color: white; margin-bottom: 48px;
            letter-spacing: -1px;
            position: relative; z-index: 2;
        }
        .left-heading {
            font-size: 44px; font-weight: 900;
            color: white; line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
            position: relative; z-index: 2;
        }
        .left-desc {
            font-size: 16px; color: rgba(255,255,255,0.7);
            max-width: 380px; line-height: 1.7;
            font-weight: 500;
            position: relative; z-index: 2;
        }
        .left-stats {
            display: flex; gap: 40px;
            margin-top: 56px;
            position: relative; z-index: 2;
        }
        .left-stat-number {
            font-size: 28px; font-weight: 900; color: white;
        }
        .left-stat-label {
            font-size: 12px; font-weight: 600;
            color: rgba(255,255,255,0.6);
            margin-top: 4px; text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ===== RIGHT PANEL (Form) ===== */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 60px 48px;
            background: #ffffff;
        }
        .form-container {
            width: 100%; max-width: 420px;
        }
        .form-header {
            margin-bottom: 40px;
        }
        .form-title {
            font-size: 28px; font-weight: 900;
            color: #0f172a; margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .form-subtitle {
            font-size: 15px; color: #94a3b8; font-weight: 500;
        }

        /* Status message */
        .status-msg {
            background: #ecfdf5; color: #065f46;
            padding: 12px 16px; border-radius: 12px;
            font-size: 13px; font-weight: 600;
            margin-bottom: 24px;
            border: 1px solid #a7f3d0;
        }

        /* Form fields */
        .field { margin-bottom: 24px; }
        .field-label {
            display: block;
            font-size: 13px; font-weight: 700;
            color: #334155; margin-bottom: 8px;
        }
        .field-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 15px; font-weight: 500;
            color: #0f172a;
            background: #fafbfc;
            outline: none;
            font-family: inherit;
            transition: all 0.2s;
        }
        .field-input:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }
        .field-input::placeholder { color: #cbd5e1; }
        .field-error {
            font-size: 12px; font-weight: 700;
            color: #ef4444; margin-top: 6px;
        }

        /* Password header row */
        .field-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 8px;
        }
        .field-header .field-label { margin-bottom: 0; }
        .forgot-link {
            font-size: 13px; font-weight: 700;
            color: #6366f1; text-decoration: none;
        }
        .forgot-link:hover { color: #4f46e5; text-decoration: underline; }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #6366f1;
            color: white;
            border: none; border-radius: 14px;
            font-size: 15px; font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(99,102,241,0.3);
            margin-top: 8px;
        }
        .submit-btn:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99,102,241,0.4);
        }
        .submit-btn:active { transform: translateY(0); }

        /* Bottom link */
        .bottom-text {
            text-align: center;
            margin-top: 32px;
            font-size: 14px; font-weight: 600;
            color: #94a3b8;
        }
        .bottom-link {
            color: #6366f1; text-decoration: none;
            font-weight: 700;
        }
        .bottom-link:hover { text-decoration: underline; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            body { flex-direction: column; }
            .left-panel {
                padding: 48px 32px;
                min-height: auto;
            }
            .left-heading { font-size: 32px; }
            .left-stats { gap: 28px; }
            .right-panel { padding: 48px 28px; }
        }
    </style>
</head>
<body>

    <!-- ===== LEFT PANEL ===== -->
    <div class="left-panel">
        <div style="max-width: 440px;">
            <div class="left-logo">JobBoard<span style="color: rgba(255,255,255,0.6);">.</span></div>
            <h1 class="left-heading">Welcome back to the future of hiring.</h1>
            <p class="left-desc">
                Log in to access your personalized dashboard, track applications, and discover new career opportunities.
            </p>
            <div class="left-stats">
                <div>
                    <div class="left-stat-number">10k+</div>
                    <div class="left-stat-label">Users</div>
                </div>
                <div>
                    <div class="left-stat-number">5k+</div>
                    <div class="left-stat-label">Jobs</div>
                </div>
                <div>
                    <div class="left-stat-number">98%</div>
                    <div class="left-stat-label">Happy</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT PANEL ===== -->
    <div class="right-panel">
        <div class="form-container">
            <div class="form-header">
                <h2 class="form-title">Sign in to your account</h2>
                <p class="form-subtitle">Enter your credentials to continue</p>
            </div>

            @if(session('status'))
                <div class="status-msg">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="field">
                    <label class="field-label" for="email">Email Address</label>
                    <input id="email" class="field-input" type="email" name="email"
                           value="{{ old('email') }}" required autofocus
                           placeholder="you@example.com">
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field">
                    <div class="field-header">
                        <label class="field-label" for="password">Password</label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>
                    <input id="password" class="field-input" type="password" name="password"
                           required placeholder="••••••••">
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn">Sign In</button>
            </form>

            <p class="bottom-text">
                Don't have an account?
                <a href="{{ route('register') }}" class="bottom-link">Create one free</a>
            </p>
        </div>
    </div>

</body>
</html>
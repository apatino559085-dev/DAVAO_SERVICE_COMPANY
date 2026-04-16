<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — JobBoard</title>
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

        /* ===== LEFT PANEL ===== */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 50%, #2563eb 100%);
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 60px;
            position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute; top: -120px; left: -120px;
            width: 400px; height: 400px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute; bottom: -100px; right: -100px;
            width: 350px; height: 350px;
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
        .left-features {
            margin-top: 56px;
            display: flex; flex-direction: column; gap: 20px;
            position: relative; z-index: 2;
        }
        .left-feature {
            display: flex; align-items: center; gap: 14px;
        }
        .left-feature-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .left-feature-text {
            font-size: 14px; font-weight: 600;
            color: rgba(255,255,255,0.85);
        }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 60px 48px;
            background: #ffffff;
            overflow-y: auto;
        }
        .form-container { width: 100%; max-width: 480px; }
        .form-header { margin-bottom: 36px; }
        .form-title {
            font-size: 28px; font-weight: 900;
            color: #0f172a; margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .form-subtitle {
            font-size: 15px; color: #94a3b8; font-weight: 500;
        }

        /* Form fields */
        .field { margin-bottom: 20px; }
        .field-label {
            display: block;
            font-size: 13px; font-weight: 700;
            color: #334155; margin-bottom: 8px;
        }
        .field-input, .field-select {
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
            -webkit-appearance: none;
        }
        .field-input:focus, .field-select:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }
        .field-input::placeholder { color: #cbd5e1; }
        .field-error {
            font-size: 12px; font-weight: 700;
            color: #ef4444; margin-top: 6px;
        }

        /* Two column row */
        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Role selector */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .role-option {
            position: relative; cursor: pointer;
        }
        .role-option input { position: absolute; opacity: 0; pointer-events: none; }
        .role-card {
            padding: 20px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            text-align: center;
            background: #fafbfc;
            transition: all 0.2s;
        }
        .role-option input:checked + .role-card {
            border-color: #6366f1;
            background: #eef2ff;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }
        .role-card:hover { border-color: #c7d2fe; background: #f8faff; }
        .role-emoji { font-size: 28px; margin-bottom: 8px; }
        .role-label {
            font-size: 14px; font-weight: 800;
            color: #0f172a;
        }

        /* Submit */
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

        .bottom-text {
            text-align: center;
            margin-top: 28px;
            font-size: 14px; font-weight: 600;
            color: #94a3b8;
        }
        .bottom-link {
            color: #6366f1; text-decoration: none; font-weight: 700;
        }
        .bottom-link:hover { text-decoration: underline; }

        /* Responsive */
        @media (max-width: 900px) {
            body { flex-direction: column; }
            .left-panel { padding: 48px 32px; min-height: auto; }
            .left-heading { font-size: 32px; }
            .right-panel { padding: 48px 28px; }
            .field-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- ===== LEFT PANEL ===== -->
    <div class="left-panel">
        <div style="max-width: 440px;">
            <div class="left-logo">JobBoard<span style="color: rgba(255,255,255,0.5);">.</span></div>
            <h1 class="left-heading">Start your journey with us.</h1>
            <p class="left-desc">
                Create an account to access thousands of curated job opportunities or post your own vacancies.
            </p>
            <div class="left-features">
                <div class="left-feature">
                    <div class="left-feature-icon">⚡</div>
                    <span class="left-feature-text">Apply to jobs in one click</span>
                </div>
                <div class="left-feature">
                    <div class="left-feature-icon">📊</div>
                    <span class="left-feature-text">Track all your applications</span>
                </div>
                <div class="left-feature">
                    <div class="left-feature-icon">🔒</div>
                    <span class="left-feature-text">Your data stays private & secure</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT PANEL ===== -->
    <div class="right-panel">
        <div class="form-container">
            <div class="form-header">
                <h2 class="form-title">Create your account</h2>
                <p class="form-subtitle">Fill in the details below to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name & Email Row -->
                <div class="field-row">
                    <div class="field">
                        <label class="field-label" for="name">Full Name</label>
                        <input id="name" class="field-input" type="text" name="name"
                               value="{{ old('name') }}" required autofocus
                               placeholder="John Doe">
                        @error('name') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="email">Email Address</label>
                        <input id="email" class="field-input" type="email" name="email"
                               value="{{ old('email') }}" required
                               placeholder="you@example.com">
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="field">
                    <label class="field-label" for="address">Address</label>
                    <input id="address" class="field-input" type="text" name="address"
                           value="{{ old('address') }}" required
                           placeholder="City, Province">
                    @error('address') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <!-- Default Role Hidden -->
                <input type="hidden" name="role" value="applicant">

                <!-- Password Row -->
                <div class="field-row">
                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <input id="password" class="field-input" type="password" name="password"
                               required placeholder="••••••••">
                        @error('password') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" class="field-input" type="password"
                               name="password_confirmation" required placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn">Create Account</button>
            </form>

            <p class="bottom-text">
                Already have an account?
                <a href="{{ route('login') }}" class="bottom-link">Sign in</a>
            </p>
        </div>
    </div>

</body>
</html>
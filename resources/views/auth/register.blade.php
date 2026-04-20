<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Davao Job Portal</title>
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
            overflow-x: hidden;
            color: #0f172a;
        }

        /* Ambient blobs */
        body::before {
            content: '';
            position: fixed; top: -10%; right: -10%;
            width: 500px; height: 500px;
            background: rgba(168, 85, 247, 0.3); border-radius: 50%;
            filter: blur(120px); opacity: 0.6;
        }
        body::after {
            content: '';
            position: fixed; bottom: -10%; left: -10%;
            width: 500px; height: 500px;
            background: rgba(34, 197, 94, 0.2); border-radius: 50%;
            filter: blur(120px); opacity: 0.6;
        }

        .register-card {
            width: 100%; max-width: 520px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px 0 rgba(31, 38, 135, 0.05);
            border-radius: 32px;
            padding: 44px 40px;
            position: relative; z-index: 1;
        }

        /* Logo */
        .logo-wrap {
            text-align: center;
            margin-bottom: 32px;
            text-decoration: none;
            display: block;
        }
        .logo-img {
            width: 80px; height: 80px;
            border-radius: 50%; background: white;
            padding: 8px; margin: 0 auto 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            display: block; object-fit: contain;
            border: 1px solid rgba(255,255,255,0.8);
        }
        .logo-title {
            font-size: 13px; font-weight: 800;
            color: #6366f1;
            text-transform: uppercase; letter-spacing: 2px;
        }

        /* Heading */
        .form-heading {
            font-size: 26px; font-weight: 900;
            color: #0f172a; text-align: center;
            margin-bottom: 4px; letter-spacing: -0.5px;
        }
        .form-sub {
            font-size: 14px; color: #64748b;
            text-align: center; font-weight: 500;
            margin-bottom: 32px;
        }

        /* Fields */
        .field { margin-bottom: 18px; }
        .field-label {
            display: block; font-size: 12px; font-weight: 800;
            color: #475569; margin-bottom: 6px;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .field-input {
            width: 100%; padding: 13px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 12px; font-size: 14px; font-weight: 500;
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
            font-size: 11px; font-weight: 700;
            color: #ef4444; margin-top: 4px;
        }

        /* Two column */
        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Submit */
        .submit-btn {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white; border: none; border-radius: 14px;
            font-size: 15px; font-weight: 800;
            font-family: inherit; cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 8px 24px rgba(99,102,241,0.25);
            margin-top: 8px;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(99,102,241,0.35);
        }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 16px;
            margin: 24px 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px;
            background: #e2e8f0;
        }
        .divider-text {
            font-size: 12px; font-weight: 700;
            color: #64748b; text-transform: uppercase;
            letter-spacing: 1px;
        }

        .bottom-text {
            text-align: center; font-size: 14px;
            font-weight: 600; color: #64748b;
        }
        .bottom-link {
            color: #6366f1; text-decoration: none; font-weight: 800;
        }
        .bottom-link:hover { color: #4f46e5; text-decoration: underline; }

        @media (max-width: 560px) {
            .register-card { padding: 32px 20px; border-radius: 24px; }
            .field-row { grid-template-columns: 1fr; }
            .form-heading { font-size: 22px; }
        }
    </style>
</head>
<body>

    <div class="register-card">
        <!-- Logo -->
        <a href="/" class="logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="Davao Jobs Portal" class="logo-img">
            <div class="logo-title">Building Davao</div>
        </a>

        <h1 class="form-heading">Create your account</h1>
        <p class="form-sub">Join Davao's growing digital workforce</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field-row">
                <div class="field">
                    <label class="field-label" for="name">Full Name</label>
                    <input id="name" class="field-input" type="text" name="name"
                           value="{{ old('name') }}" required autofocus
                           placeholder="Juan Dela Cruz">
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label class="field-label" for="email">Email</label>
                    <input id="email" class="field-input" type="email" name="email"
                           value="{{ old('email') }}" required
                           placeholder="you@email.com">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="field">
                <label class="field-label" for="address">Address</label>
                <input id="address" class="field-input" type="text" name="address"
                       value="{{ old('address') }}" required
                       placeholder="Davao City, Davao del Sur">
                @error('address') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <!-- Default Role Hidden -->
            <input type="hidden" name="role" value="applicant">

            <div class="field-row">
                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <input id="password" class="field-input" type="password" name="password"
                           required placeholder="••••••••">
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label class="field-label" for="password_confirmation">Confirm</label>
                    <input id="password_confirmation" class="field-input" type="password"
                           name="password_confirmation" required placeholder="••••••••">
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
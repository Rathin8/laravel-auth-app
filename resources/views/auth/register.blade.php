<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Create Your Account - {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.85);
            --card-border: rgba(255, 255, 255, 0.08);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-glow: rgba(99, 102, 241, 0.35);
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
            --error-color: #f43f5e;
            --error-bg: rgba(244, 63, 94, 0.12);
            --error-border: rgba(244, 63, 94, 0.3);
            --success-color: #10b981;
            --radius-card: 24px;
            --radius-input: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
            line-height: 1.5;
        }

        /* Ambient Glow & Floating Gradients */
        .ambient-glow-1 {
            position: fixed;
            top: -120px;
            left: 20%;
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, rgba(168, 85, 247, 0.12) 50%, transparent 70%);
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
            animation: pulse-slow 8s ease-in-out infinite alternate;
        }

        .ambient-glow-2 {
            position: fixed;
            bottom: -120px;
            right: 15%;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.18) 0%, rgba(99, 102, 241, 0.1) 50%, transparent 70%);
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            animation: pulse-slow 10s ease-in-out infinite alternate-reverse;
        }

        @keyframes pulse-slow {
            0% { transform: scale(1) translate(0, 0); opacity: 0.8; }
            100% { transform: scale(1.1) translate(15px, -15px); opacity: 1; }
        }

        /* Subtle Dot Pattern */
        .dot-overlay {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
            z-index: 1;
        }

        /* Card Container */
        .form-container {
            width: 100%;
            max-width: 520px;
            position: relative;
            z-index: 10;
            margin: auto;
        }

        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-card);
            padding: 40px 36px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.04) inset;
        }

        /* Header Section */
        .card-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: var(--primary-gradient);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
            margin-bottom: 16px;
        }

        .badge-free {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(99, 102, 241, 0.12);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.25);
            margin-bottom: 12px;
        }

        .badge-pulse {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #818cf8;
            box-shadow: 0 0 8px #818cf8;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .form-heading {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .form-subheading {
            font-size: 0.9rem;
            color: var(--text-secondary);
            max-width: 380px;
            margin: 0 auto;
        }

        /* Global Error Banner */
        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            border-radius: var(--radius-input);
            color: #fda4af;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }

        .alert-error ul {
            margin-top: 4px;
            padding-left: 18px;
        }

        /* Form Controls */
        .form-stack {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .form-label {
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #cbd5e1;
        }

        .required-star {
            color: var(--error-color);
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-lead-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            background: rgba(30, 41, 59, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-input);
            color: #ffffff;
            font-family: inherit;
            font-size: 0.92rem;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input.has-toggle {
            padding-right: 44px;
        }

        .form-input:focus {
            border-color: var(--primary);
            background: rgba(30, 41, 59, 0.9);
            box-shadow: 0 0 0 4px var(--primary-glow);
        }

        .form-input.is-invalid {
            border-color: var(--error-color);
            box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.2);
        }

        .form-input::placeholder {
            color: #64748b;
        }

        .input-trail-btn {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s ease;
        }

        .input-trail-btn:hover {
            color: #ffffff;
        }

        .field-error {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            font-size: 0.78rem;
            color: #fb7185;
            font-weight: 500;
        }

        /* Password Strength Bar */
        .strength-indicator {
            margin-top: 8px;
        }

        .strength-meter-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
            height: 4px;
            width: 100%;
        }

        .strength-bar {
            height: 100%;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.1);
            transition: background-color 0.3s ease;
        }

        .strength-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Terms Checkbox */
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 4px;
            cursor: pointer;
        }

        .checkbox-input {
            width: 17px;
            height: 17px;
            border-radius: 5px;
            accent-color: var(--primary);
            cursor: pointer;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .checkbox-label {
            font-size: 0.82rem;
            color: var(--text-secondary);
            line-height: 1.45;
            user-select: none;
        }

        .checkbox-label a {
            color: #818cf8;
            text-decoration: underline;
            text-underline-offset: 3px;
            transition: color 0.2s ease;
        }

        .checkbox-label a:hover {
            color: #a5b4fc;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 13px 24px;
            background: var(--primary-gradient);
            background-size: 200% 200%;
            border: none;
            border-radius: var(--radius-input);
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
            margin-top: 8px;
        }

        .btn-submit:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.5);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Social Divider */
        .social-divider {
            position: relative;
            text-align: center;
            margin: 24px 0 20px;
        }

        .social-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
        }

        .social-divider span {
            position: relative;
            background: #111827;
            padding: 0 14px;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }

        /* Social Grid */
        .social-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-input);
            color: #cbd5e1;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-social:hover {
            background: rgba(51, 65, 85, 0.8);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        /* Footer */
        .card-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .card-footer a {
            color: #818cf8;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
            margin-left: 4px;
        }

        .card-footer a:hover {
            color: #a5b4fc;
        }

        /* Security Bar */
        .security-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        .back-link-box {
            text-align: center;
            margin-top: 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #e2e8f0;
        }

        @media (max-width: 540px) {
            .glass-card {
                padding: 30px 22px;
            }

            .form-heading {
                font-size: 1.5rem;
            }

            .social-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glows -->
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>
    <div class="dot-overlay"></div>

    <div class="form-container">

        <!-- Form Card -->
        <div class="glass-card">

            <!-- Card Header -->
            <div class="card-header">
                <div class="brand-icon-wrap">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="19" y1="8" x2="19" y2="14"></line>
                        <line x1="22" y1="11" x2="16" y2="11"></line>
                    </svg>
                </div>

                <div>
                    <span class="badge-free">
                        <span class="badge-pulse"></span>
                        Get started for free
                    </span>
                </div>

                <h1 class="form-heading">Create your account</h1>
                <p class="form-subheading">Fill in your information to start using your workspace instantly.</p>
            </div>

            <!-- Global Error Alert -->
            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"></line>
                    </svg>
                    <div>
                        <strong>Please check the following errors:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register.store') }}" id="registrationForm" novalidate class="form-stack">
                @csrf

                <!-- Name Input -->
                <div class="form-group">
                    <div class="label-row">
                        <label for="name" class="form-label">
                            Full Name <span class="required-star">*</span>
                        </label>
                    </div>
                    <div class="input-box">
                        <div class="input-lead-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus
                            placeholder="John Doe"
                            class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        />
                    </div>
                    @error('name')
                        <div class="field-error">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="form-group">
                    <div class="label-row">
                        <label for="email" class="form-label">
                            Email Address <span class="required-star">*</span>
                        </label>
                    </div>
                    <div class="input-box">
                        <div class="input-lead-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        />
                    </div>
                    @error('email')
                        <div class="field-error">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <div class="label-row">
                        <label for="password" class="form-label">
                            Password <span class="required-star">*</span>
                        </label>
                        <span id="strengthText" class="strength-label">Min. 8 characters</span>
                    </div>
                    <div class="input-box">
                        <div class="input-lead-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="form-input has-toggle {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        />
                        <button type="button" id="togglePassword" class="input-trail-btn" aria-label="Toggle password visibility">
                            <svg id="eyeIcon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <!-- Strength Meter -->
                    <div class="strength-indicator">
                        <div class="strength-meter-grid">
                            <div id="strBar1" class="strength-bar"></div>
                            <div id="strBar2" class="strength-bar"></div>
                            <div id="strBar3" class="strength-bar"></div>
                            <div id="strBar4" class="strength-bar"></div>
                        </div>
                    </div>

                    @error('password')
                        <div class="field-error">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="form-group">
                    <div class="label-row">
                        <label for="password_confirmation" class="form-label">
                            Confirm Password <span class="required-star">*</span>
                        </label>
                        <span id="matchStatus" class="strength-label" style="display: none;"></span>
                    </div>
                    <div class="input-box">
                        <div class="input-lead-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="form-input has-toggle"
                        />
                        <button type="button" id="togglePasswordConfirmation" class="input-trail-btn" aria-label="Toggle confirm password visibility">
                            <svg id="eyeIconConfirm" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIconConfirm" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="form-group">
                    <label class="checkbox-container">
                        <input
                            type="checkbox"
                            name="terms"
                            id="terms"
                            value="1"
                            {{ old('terms') ? 'checked' : '' }}
                            required
                            class="checkbox-input"
                        />
                        <span class="checkbox-label">
                            I accept the
                            <a href="#" onclick="event.preventDefault()">Terms of Service</a>
                            and
                            <a href="#" onclick="event.preventDefault()">Privacy Policy</a>.
                        </span>
                    </label>
                    @error('terms')
                        <div class="field-error">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn" class="btn-submit">
                    <span id="btnText">Create Account</span>
                    <svg id="btnArrow" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <!-- Social Divider -->
            <div class="social-divider">
                <span>or sign up with</span>
            </div>

            <!-- Social Buttons -->
            <div class="social-grid">
                <button type="button" class="btn-social">
                    <svg width="16" height="16" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.7 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z"/>
                        <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/>
                        <path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.8s.2-2.1.4-2.8L1.9 6.3C.7 8.7 0 10.8 0 12s.7 3.3 1.9 5.7l3.7-2.9z"/>
                        <path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2-6.4-4.8L1.9 16.4C3.7 20.4 7.5 23 12 23z"/>
                    </svg>
                    Google
                </button>

                <button type="button" class="btn-social">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                    GitHub
                </button>
            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                Already registered?
                <a href="{{ route('home') }}">Sign in to your account</a>
            </div>

        </div>

        <!-- Back to Website -->
        <div class="back-link-box">
            <a href="{{ route('home') }}" class="back-link">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Return to home</span>
            </a>
        </div>

    </div>

    <!-- Client-side Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const toggleConfirmBtn = document.getElementById('togglePasswordConfirmation');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');
            const eyeOffIconConfirm = document.getElementById('eyeOffIconConfirm');
            const strengthText = document.getElementById('strengthText');
            const strBars = [
                document.getElementById('strBar1'),
                document.getElementById('strBar2'),
                document.getElementById('strBar3'),
                document.getElementById('strBar4'),
            ];
            const matchStatus = document.getElementById('matchStatus');
            const form = document.getElementById('registrationForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnArrow = document.getElementById('btnArrow');

            // Password Toggle Handlers
            togglePasswordBtn.addEventListener('click', () => {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.style.display = isPassword ? 'none' : 'block';
                eyeOffIcon.style.display = isPassword ? 'block' : 'none';
            });

            toggleConfirmBtn.addEventListener('click', () => {
                const isPassword = confirmInput.getAttribute('type') === 'password';
                confirmInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIconConfirm.style.display = isPassword ? 'none' : 'block';
                eyeOffIconConfirm.style.display = isPassword ? 'block' : 'none';
            });

            // Password Strength Calculator
            function calculatePasswordStrength(pass) {
                if (!pass) return { score: 0, text: 'Min. 8 characters', color: '#64748b', bg: 'rgba(255,255,255,0.1)' };

                let score = 0;
                if (pass.length >= 8) score++;
                if (pass.length >= 12) score++;
                if (/[A-Z]/.test(pass) && /[a-z]/.test(pass)) score++;
                if (/[0-9]/.test(pass)) score++;
                if (/[^A-Za-z0-9]/.test(pass)) score++;

                let level = 1;
                if (score >= 4) level = 4;
                else if (score >= 3) level = 3;
                else if (score >= 2) level = 2;

                const levels = {
                    1: { score: 1, text: 'Weak', color: '#f43f5e', bg: '#f43f5e' },
                    2: { score: 2, text: 'Fair', color: '#f59e0b', bg: '#f59e0b' },
                    3: { score: 3, text: 'Good', color: '#0ea5e9', bg: '#0ea5e9' },
                    4: { score: 4, text: 'Strong', color: '#10b981', bg: '#10b981' },
                };

                return levels[level];
            }

            passwordInput.addEventListener('input', () => {
                const val = passwordInput.value;
                const result = calculatePasswordStrength(val);

                strengthText.textContent = result.text;
                strengthText.style.color = result.color;

                strBars.forEach((bar, idx) => {
                    if (val && idx < result.score) {
                        bar.style.backgroundColor = result.bg;
                    } else {
                        bar.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
                    }
                });

                checkMatch();
            });

            // Match Check
            function checkMatch() {
                const p = passwordInput.value;
                const c = confirmInput.value;

                if (!c) {
                    matchStatus.style.display = 'none';
                    return;
                }

                matchStatus.style.display = 'inline';
                if (p === c) {
                    matchStatus.textContent = '✓ Passwords match';
                    matchStatus.style.color = '#34d399';
                } else {
                    matchStatus.textContent = '✕ Does not match';
                    matchStatus.style.color = '#fb7185';
                }
            }

            confirmInput.addEventListener('input', checkMatch);

            // Submit Loading State
            form.addEventListener('submit', () => {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.75';
                submitBtn.style.cursor = 'not-allowed';
                btnText.textContent = 'Creating account...';
                btnArrow.style.display = 'none';
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In - {{ config('app.name', 'Laravel') }}</title>

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
            --success-bg: rgba(16, 185, 129, 0.12);
            --success-border: rgba(16, 185, 129, 0.25);
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
            max-width: 480px;
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

        .badge-auth {
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
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
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
            max-width: 360px;
            margin: 0 auto;
        }

        /* Status & Error Alerts */
        .alert-box {
            display: none;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius-input);
            margin-bottom: 24px;
            font-size: 0.85rem;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-box.error {
            display: flex;
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: #fda4af;
        }

        .alert-box.success {
            display: flex;
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: #6ee7b7;
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
            display: none;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            font-size: 0.78rem;
            color: #fb7185;
            font-weight: 500;
        }

        .field-error.visible {
            display: flex;
        }

        /* Checkbox & Options */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: -2px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .checkbox-label {
            font-size: 0.82rem;
            color: var(--text-secondary);
            user-select: none;
        }

        .forgot-link {
            font-size: 0.82rem;
            color: #818cf8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #a5b4fc;
            text-decoration: underline;
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
            margin-top: 6px;
        }

        .btn-submit:hover:not(:disabled) {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.5);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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

        /* ========================================================
           RESPONSIVE TIERS: DESKTOP, TABLET, AND MOBILE ONLY
           ======================================================== */

        /* 1. Desktop Tier: 1025px and up */
        @media (min-width: 1025px) {
            body {
                padding: 28px 16px;
            }

            .form-container {
                max-width: 480px;
            }

            .glass-card {
                padding: 40px 36px;
                border-radius: var(--radius-card);
            }

            .card-header {
                margin-bottom: 28px;
            }

            .brand-icon-wrap {
                width: 54px;
                height: 54px;
                border-radius: 16px;
                margin-bottom: 16px;
            }

            .form-heading {
                font-size: 1.75rem;
            }

            .form-subheading {
                font-size: 0.9rem;
            }

            .social-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
        }

        /* 2. Tablet Tier: 641px to 1024px */
        @media (min-width: 641px) and (max-width: 1024px) {
            body {
                padding: 24px 20px;
            }

            .form-container {
                max-width: 460px;
            }

            .glass-card {
                padding: 36px 32px;
                border-radius: 22px;
            }

            .card-header {
                margin-bottom: 24px;
            }

            .brand-icon-wrap {
                width: 50px;
                height: 50px;
                border-radius: 15px;
                margin-bottom: 14px;
            }

            .form-heading {
                font-size: 1.65rem;
            }

            .form-subheading {
                font-size: 0.88rem;
            }

            .social-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
        }

        /* 3. Mobile Tier: up to 640px */
        @media (max-width: 640px) {
            body {
                padding: 16px 12px;
            }

            .ambient-glow-1,
            .ambient-glow-2 {
                width: 280px;
                height: 280px;
                filter: blur(60px);
            }

            .form-container {
                max-width: 100%;
                width: 100%;
            }

            .glass-card {
                padding: 24px 18px;
                border-radius: 18px;
            }

            .card-header {
                margin-bottom: 20px;
            }

            .brand-icon-wrap {
                width: 46px;
                height: 46px;
                border-radius: 14px;
                margin-bottom: 12px;
            }

            .badge-auth {
                font-size: 0.72rem;
                padding: 3px 10px;
                margin-bottom: 10px;
            }

            .form-heading {
                font-size: 1.45rem;
                letter-spacing: -0.02em;
            }

            .form-subheading {
                font-size: 0.84rem;
            }

            .alert-box {
                padding: 12px 14px;
                font-size: 0.82rem;
                margin-bottom: 18px;
            }

            .form-stack {
                gap: 16px;
            }

            .form-label {
                font-size: 0.74rem;
            }

            .form-input {
                padding: 11px 12px 11px 38px;
                font-size: 0.9rem;
                border-radius: 10px;
            }

            .input-lead-icon {
                left: 12px;
            }

            .input-trail-btn {
                right: 10px;
            }

            .options-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
                flex-wrap: wrap;
                margin-top: 0;
            }

            .checkbox-label {
                font-size: 0.78rem;
            }

            .forgot-link {
                font-size: 0.78rem;
            }

            .btn-submit {
                padding: 12px 20px;
                font-size: 0.92rem;
                border-radius: 10px;
            }

            .social-divider {
                margin: 20px 0 16px;
            }

            .social-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .btn-social {
                padding: 11px 16px;
                font-size: 0.84rem;
                border-radius: 10px;
                width: 100%;
            }

            .card-footer {
                margin-top: 20px;
                font-size: 0.8rem;
            }

            .security-bar {
                margin-top: 16px;
                padding-top: 14px;
                font-size: 0.7rem;
            }

            .back-link-box {
                margin-top: 16px;
            }

            .back-link {
                font-size: 0.78rem;
            }
        }

        /* Micro-Mobile Refinement: 380px and below */
        @media (max-width: 380px) {
            .glass-card {
                padding: 20px 14px;
                border-radius: 16px;
            }

            .options-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
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
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                </div>

                <div>
                    <span class="badge-auth">
                        <span class="badge-pulse"></span>
                        Secure Authentication
                    </span>
                </div>

                <h1 class="form-heading">Welcome back</h1>
                <p class="form-subheading">Enter your email and password to access your account.</p>
            </div>

            <!-- Global Alert Box (Error or Success) -->
            @if ($errors->has('social'))
                <div class="alert-box error" role="alert" style="margin-bottom: 20px;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 1px;">
                        <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                        <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"></line>
                    </svg>
                    <div>{{ $errors->first('social') }}</div>
                </div>
            @endif

            <div id="alertBox" class="alert-box" role="alert">
                <svg id="alertIconError" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 1px;">
                    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                    <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"></line>
                </svg>
                <svg id="alertIconSuccess" width="18" height="18" fill="none" stroke="#10b981" viewBox="0 0 24 24" style="display: none; flex-shrink: 0; margin-top: 1px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div id="alertMessage"></div>
            </div>

            <!-- Login Form (Connected to POST /api/login) -->
            <form id="loginForm" novalidate class="form-stack">
                @csrf

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
                            required
                            autocomplete="email"
                            autofocus
                            placeholder="you@example.com"
                            class="form-input"
                        />
                    </div>
                    <div class="field-error" id="emailError">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span id="emailErrorText"></span>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <div class="label-row">
                        <label for="password" class="form-label">
                            Password <span class="required-star">*</span>
                        </label>
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
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="form-input has-toggle"
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
                    <div class="field-error" id="passwordError">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span id="passwordErrorText"></span>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="options-row">
                    <label class="checkbox-container">
                        <input
                            type="checkbox"
                            id="remember"
                            class="checkbox-input"
                        />
                        <span class="checkbox-label">Remember me</span>
                    </label>

                    <a href="#" class="forgot-link" onclick="event.preventDefault(); alert('Please contact system administrator to reset password.');">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn" class="btn-submit">
                    <span id="btnText">Sign In</span>
                    <svg id="btnArrow" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                    <!-- Spinner for loading state -->
                    <svg id="btnSpinner" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="display: none; animation: spin 0.8s linear infinite;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-opacity="0.25"></circle>
                        <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor"></path>
                    </svg>
                </button>
            </form>

            <!-- Social Divider -->
            <div class="social-divider">
                <span>or continue with</span>
            </div>

            <!-- Social Buttons -->
            <div class="social-grid">
                <a href="{{ route('social.redirect', 'google') }}" class="btn-social">
                    <svg width="16" height="16" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.7 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z"/>
                        <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/>
                        <path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.8s.2-2.1.4-2.8L1.9 6.3C.7 8.7 0 10.8 0 12s.7 3.3 1.9 5.7l3.7-2.9z"/>
                        <path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2-6.4-4.8L1.9 16.4C3.7 20.4 7.5 23 12 23z"/>
                    </svg>
                    Google
                </a>

                <a href="{{ route('social.redirect', 'github') }}" class="btn-social">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                    GitHub
                </a>
            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Create an account</a>
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

    <!-- Client-side API Connection Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnArrow = document.getElementById('btnArrow');
            const btnSpinner = document.getElementById('btnSpinner');
            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');
            const alertIconError = document.getElementById('alertIconError');
            const alertIconSuccess = document.getElementById('alertIconSuccess');
            const emailError = document.getElementById('emailError');
            const emailErrorText = document.getElementById('emailErrorText');
            const passwordError = document.getElementById('passwordError');
            const passwordErrorText = document.getElementById('passwordErrorText');

            // Password Toggle
            togglePasswordBtn.addEventListener('click', () => {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.style.display = isPassword ? 'none' : 'block';
                eyeOffIcon.style.display = isPassword ? 'block' : 'none';
            });

            // Clear Errors Helper
            function clearErrors() {
                alertBox.className = 'alert-box';
                alertBox.style.display = 'none';
                alertMessage.textContent = '';
                emailInput.classList.remove('is-invalid');
                passwordInput.classList.remove('is-invalid');
                emailError.classList.remove('visible');
                passwordError.classList.remove('visible');
                emailErrorText.textContent = '';
                passwordErrorText.textContent = '';
            }

            // Set Loading Helper
            function setLoading(loading) {
                submitBtn.disabled = loading;
                if (loading) {
                    btnText.textContent = 'Signing in...';
                    btnArrow.style.display = 'none';
                    btnSpinner.style.display = 'block';
                } else {
                    btnText.textContent = 'Sign In';
                    btnArrow.style.display = 'block';
                    btnSpinner.style.display = 'none';
                }
            }

            // Show Alert Helper
            function showAlert(message, type = 'error', isHtml = false) {
                alertBox.className = `alert-box ${type}`;
                alertBox.style.display = 'flex';
                if (isHtml) {
                    alertMessage.innerHTML = message;
                } else {
                    alertMessage.textContent = message;
                }
                alertIconError.style.display = type === 'error' ? 'block' : 'none';
                alertIconSuccess.style.display = type === 'success' ? 'block' : 'none';
            }

            // Clear any legacy persistent storage so sessions don't survive browser close
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');

            // Detect existing token session in current browser session
            const existingToken = sessionStorage.getItem('auth_token');
            const existingUserStr = sessionStorage.getItem('user');
            if (existingToken && existingUserStr) {
                try {
                    const parsedUser = JSON.parse(existingUserStr);
                    const userData = parsedUser.data || parsedUser;
                    if (userData && userData.name) {
                        showAlert(`You are currently logged in as <strong>${userData.name}</strong>. <a href="{{ route('home') }}" style="color: #6ee7b7; text-decoration: underline; font-weight: 600; margin-left: 4px;">Return to Home &rarr;</a>`, 'success', true);
                    }
                } catch (e) {}
            }

            // Form Submit Listener (Connecting to POST /api/login)
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                clearErrors();
                setLoading(true);

                const payload = {
                    email: emailInput.value.trim(),
                    password: passwordInput.value,
                    device_name: 'browser_web'
                };

                try {
                    const response = await fetch('/api/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Store token and user data in sessionStorage (cleared automatically when browser/app is closed)
                        if (data.token) {
                            sessionStorage.setItem('auth_token', data.token);
                            sessionStorage.setItem('user', JSON.stringify(data.user || {}));
                        }

                        showAlert('Login successful! Redirecting to home...', 'success');
                        btnText.textContent = 'Redirecting...';

                        setTimeout(() => {
                            window.location.replace('{{ route("home") }}');
                        }, 750);
                    } else if (response.status === 422) {
                        // Validation or credentials error
                        if (data.errors) {
                            if (data.errors.email) {
                                emailInput.classList.add('is-invalid');
                                emailError.classList.add('visible');
                                emailErrorText.textContent = data.errors.email[0];
                            }
                            if (data.errors.password) {
                                passwordInput.classList.add('is-invalid');
                                passwordError.classList.add('visible');
                                passwordErrorText.textContent = data.errors.password[0];
                            }
                        }
                        showAlert(data.message || 'Please check the errors below.');
                        setLoading(false);
                    } else {
                        // Other HTTP error
                        showAlert(data.message || 'Unable to sign in. Please try again.');
                        setLoading(false);
                    }
                } catch (error) {
                    showAlert('Network error: Unable to connect to the authentication server.');
                    setLoading(false);
                }
            });

            // Invalidate bfcache and force reload if navigating back/forward
            window.addEventListener('pageshow', (event) => {
                if (event.persisted || (window.performance && window.performance.getEntriesByType && window.performance.getEntriesByType('navigation')[0]?.type === 'back_forward')) {
                    window.location.reload();
                }
            });
        });
    </script>
</body>
</html>

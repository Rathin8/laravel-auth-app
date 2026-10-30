<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home - {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.78);
            --card-border: rgba(255, 255, 255, 0.08);
            --card-border-hover: rgba(99, 102, 241, 0.3);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
            --emerald: #10b981;
            --emerald-bg: rgba(16, 185, 129, 0.12);
            --emerald-border: rgba(16, 185, 129, 0.25);
            --radius-lg: 20px;
            --radius-md: 12px;
            --radius-sm: 8px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
            position: relative;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Ambient Animated Mesh Background */
        .ambient-glow-top {
            position: fixed;
            top: -160px;
            left: 50%;
            transform: translateX(-50%);
            width: 750px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, rgba(139, 92, 246, 0.12) 40%, transparent 70%);
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-bottom {
            position: fixed;
            bottom: -150px;
            right: 5%;
            width: 600px;
            height: 450px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.14) 0%, rgba(99, 102, 241, 0.08) 50%, transparent 70%);
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
        }

        /* Subtle Grid Pattern */
        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 1;
        }

        /* Layout Container */
        .app-container {
            position: relative;
            z-index: 10;
            max-width: 1060px;
            margin: 0 auto;
            padding: 24px 20px 48px;
            width: 100%;
        }

        /* Top Navbar */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            background: rgba(17, 24, 39, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: 9999px;
            margin-bottom: 36px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
            cursor: default;
            user-select: none;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }

        .brand-name {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 10px;
            list-style: none;
        }

        .nav-link {
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 8px 16px;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-cta {
            background: var(--primary-gradient);
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
        }

        .nav-cta:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(99, 102, 241, 0.45);
        }

        /* Success Alert Banner */
        .alert-success {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px 20px;
            background: var(--emerald-bg);
            border: 1px solid var(--emerald-border);
            border-radius: var(--radius-md);
            color: #34d399;
            margin-bottom: 28px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-icon {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            margin-top: 1px;
        }

        .alert-text {
            font-size: 0.92rem;
            font-weight: 500;
            color: #d1fae5;
            line-height: 1.5;
        }

        /* Hero Card */
        .hero-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.04) inset;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(99, 102, 241, 0.12);
            border: 1px solid rgba(99, 102, 241, 0.28);
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #a5b4fc;
            margin-bottom: 18px;
        }

        .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .hero-title {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.2;
            color: #ffffff;
            margin-bottom: 14px;
        }

        .hero-subtitle {
            font-size: 1.05rem;
            color: var(--text-secondary);
            max-width: 640px;
            margin-bottom: 28px;
        }

        /* User Auth Card */
        .auth-profile-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 20px 24px;
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: var(--radius-md);
            margin-bottom: 28px;
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.15rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .profile-details h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
        }

        .profile-details p {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .verified-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 9999px;
            color: #34d399;
            font-size: 0.78rem;
            font-weight: 600;
        }

        /* Action Buttons */
        .hero-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(99, 102, 241, 0.5);
        }

        .btn-secondary {
            background: rgba(30, 41, 59, 0.6);
            color: var(--text-primary);
            border: 1px solid var(--card-border);
        }

        .btn-secondary:hover {
            background: rgba(51, 65, 85, 0.8);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* Grid Feature Cards */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .feature-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            padding: 28px;
            transition: all 0.25s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .feature-card:hover {
            border-color: var(--card-border-hover);
            transform: translateY(-4px);
            box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.5);
        }

        .feature-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }

        .icon-indigo {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        .icon-cyan {
            background: rgba(6, 182, 212, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        .icon-emerald {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .feature-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .feature-link-text {
            font-size: 0.84rem;
            font-weight: 600;
            color: #818cf8;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Footer */
        .app-footer {
            text-align: center;
            padding: 24px 20px;
            color: var(--text-muted);
            font-size: 0.82rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            z-index: 10;
        }

        .footer-badges {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .footer-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .user-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 14px 4px 6px;
            background: rgba(30, 41, 59, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
        }

        .user-pill-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.35);
        }

        .user-pill-name {
            max-width: 130px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-nav-logout {
            background: rgba(244, 63, 94, 0.12);
            border: 1px solid rgba(244, 63, 94, 0.28);
            color: #fda4af !important;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-nav-logout:hover {
            background: rgba(244, 63, 94, 0.24);
            border-color: rgba(244, 63, 94, 0.45);
            color: #ffffff !important;
        }

        .btn-logout {
            background: rgba(244, 63, 94, 0.12);
            border: 1px solid rgba(244, 63, 94, 0.28);
            color: #fda4af;
        }

        .btn-logout:hover {
            background: rgba(244, 63, 94, 0.24);
            border-color: rgba(244, 63, 94, 0.45);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 7px 14px;
            font-size: 0.82rem;
        }

        /* Minimal Dashboard Styles */
        .dashboard-container {
            display: flex;
            flex-direction: column;
            gap: 22px;
            margin-bottom: 32px;
        }

        .dashboard-header-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            padding: 34px 38px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.04) inset;
        }

        .dashboard-welcome-wrap {
            flex: 1;
            min-width: 260px;
        }

        .dashboard-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px;
            background: rgba(99, 102, 241, 0.12);
            border: 1px solid rgba(99, 102, 241, 0.28);
            border-radius: 9999px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #a5b4fc;
            margin-bottom: 14px;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .dashboard-subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary);
            max-width: 560px;
        }

        .dashboard-user-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
        }

        .dashboard-user-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.15rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }

        .dashboard-user-meta {
            display: flex;
            flex-direction: column;
        }

        .dashboard-user-name {
            font-size: 0.98rem;
            font-weight: 700;
            color: #ffffff;
        }

        .dashboard-user-role {
            font-size: 0.76rem;
            color: #34d399;
            font-weight: 600;
        }

        .dashboard-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;
        }

        .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            border-color: var(--card-border-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -6px rgba(0, 0, 0, 0.4);
        }

        .stat-info {
            flex: 1;
        }

        .stat-label {
            font-size: 0.78rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .stat-value-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 4px;
        }

        .stat-value {
            font-size: 1.15rem;
            font-weight: 800;
            color: #ffffff;
        }

        .stat-pill {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
        }

        .stat-pill-emerald {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .stat-pill-indigo {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        .stat-pill-cyan {
            background: rgba(6, 182, 212, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        .dashboard-actions-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-md);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .dashboard-actions-title {
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .dashboard-actions-desc {
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .dashboard-quick-buttons {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) {
            .app-container {
                padding: 16px 14px 36px;
            }

            .hero-card {
                padding: 26px 20px;
            }

            .hero-title {
                font-size: 1.7rem;
            }

            .navbar {
                padding: 12px 18px;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glow Backgrounds -->
    <div class="ambient-glow-top"></div>
    <div class="ambient-glow-bottom"></div>
    <div class="grid-overlay"></div>

    <div class="app-container">

        <!-- Top Navigation -->
        <header class="navbar">
            <div class="brand-link">
                <div class="brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                </div>
                <span class="brand-name">Workspace</span>
            </div>

            @php
                $firstName = Auth::check() ? explode(' ', trim(Auth::user()->name))[0] : '';
                $safeServerUser = Auth::check() ? [
                    'id' => Auth::id(),
                    'name' => $firstName,
                ] : null;
            @endphp
            <nav>
                <ul class="nav-links" id="navLinks">
                    @auth
                        <li class="user-pill">
                            <div class="user-pill-avatar">{{ strtoupper(substr($firstName, 0, 1)) }}</div>
                            <span class="user-pill-name" id="navUserName">{{ $firstName }}</span>
                        </li>
                        <li>
                            <button type="button" class="nav-link btn-nav-logout logout-trigger">Sign Out</button>
                        </li>
                    @else
                        <li><a href="{{ route('home') }}" class="nav-link" style="color: #ffffff; background: rgba(255,255,255,0.06);">Home</a></li>
                        <li id="navSignInItem"><a href="{{ route('login') }}" class="nav-link">Sign In</a></li>
                        <li id="navRegisterItem"><a href="{{ route('register') }}" class="nav-link nav-cta">Register</a></li>
                    @endauth
                </ul>
            </nav>
        </header>

        <!-- Flash Message Notification -->
        @if (session('status'))
            <div class="alert-success" role="alert">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="alert-text">
                    <strong>Notice:</strong> {{ session('status') }}
                </div>
            </div>
        @endif

        <!-- Main View (Displayed based on whether user is logged in or not) -->
        <div id="viewContainer">
            @auth
                <!-- Minimal Dashboard View (Displayed when user is logged in) -->
                <main id="dashboardView" class="dashboard-container">
                    <!-- Dashboard Header -->
                    <div class="dashboard-header-card">
                        <div class="dashboard-welcome-wrap">
                            <div class="dashboard-badge">
                                <span class="badge-dot"></span>
                                <span id="dashBadgeText">Active Dashboard</span>
                            </div>
                            <h1 class="dashboard-title">
                                Welcome back, <span class="gradient-text" id="dashGreetingName">{{ $firstName }}</span> 👋
                            </h1>
                            <p class="dashboard-subtitle">
                                Here is your workspace dashboard. Everything is active and running securely.
                            </p>
                        </div>
                    </div>
                </main>
            @else
                <!-- Guest Home View (Displayed when user is NOT logged in) -->
                <main id="guestHomeView" class="hero-card">
                    <h1 class="hero-title" id="heroGreeting">
                        Welcome to your application workspace 👋
                    </h1>

                    <p class="hero-subtitle" id="heroSubtitle">
                        Access your account, manage your secure profile, and experience a seamless dashboard. Sign in or register below to get started.
                    </p>

                    <!-- User Auth Status Box -->
                    <div class="auth-profile-box" id="authProfileBox">
                        <div class="profile-info">
                            <div class="profile-avatar" id="profileAvatar" style="background: rgba(71, 85, 105, 0.6); color: #cbd5e1;">
                                ?
                            </div>
                            <div class="profile-details">
                                <h3 id="profileName">Guest Session</h3>
                                <p id="profileEmail">You are not currently logged in. Create an account or sign in to test the auth flow.</p>
                            </div>
                        </div>
                        <div id="profileActionArea" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm" id="profileLoginBtn">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm" id="profileRegisterBtn">
                                Sign Up Now &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="hero-actions" id="heroActions">
                        <a href="{{ route('login') }}" class="btn btn-primary" id="heroActionLogin">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Sign In to Account</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-secondary" id="heroActionRegister">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span>Open Registration Form</span>
                        </a>
                    </div>
                </main>
            @endauth
        </div>
    </div>

    <!-- Hidden Web Logout Form -->
    <form id="webLogoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>

    <!-- Dynamic Client-Side Auth Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const serverUser = @json($safeServerUser);

            // Clear any lingering persistent storage so sessions don't survive browser restart
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');

            const authToken = sessionStorage.getItem('auth_token');
            let localUser = null;

            try {
                const stored = sessionStorage.getItem('user');
                if (stored) {
                    const parsed = JSON.parse(stored);
                    localUser = (parsed && parsed.data) ? parsed.data : parsed;
                }
            } catch (e) {
                console.error('Could not parse user from sessionStorage', e);
            }

            const viewContainer = document.getElementById('viewContainer');
            const initialGuestHtml = viewContainer && !serverUser ? viewContainer.innerHTML : '';
            const navLinks = document.getElementById('navLinks');

            function escapeHtml(str) {
                if (!str) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function getFirstName(fullName) {
                if (!fullName) return 'User';
                return fullName.trim().split(/\s+/)[0];
            }

            function getDashboardHtml(firstName, initial, authSource) {
                const escapedFirstName = escapeHtml(firstName);
                const authMethod = (authSource === 'Session') ? 'Web Session' : 'Token 256-bit';

                return `
                    <main id="dashboardView" class="dashboard-container">
                        <div class="dashboard-header-card">
                            <div class="dashboard-welcome-wrap">
                                <div class="dashboard-badge">
                                    <span class="badge-dot"></span>
                                    <span id="dashBadgeText">Active Dashboard</span>
                                </div>
                                <h1 class="dashboard-title">
                                    Welcome back, <span class="gradient-text" id="dashGreetingName">${escapedFirstName}</span> 👋
                                </h1>
                                <p class="dashboard-subtitle">
                                    Here is your workspace dashboard. Everything is active and running securely.
                                </p>
                            </div>
                        </div>
                    </main>
                `;
            }

            function renderAuthenticatedDashboard(user, authSource = 'Token') {
                const fullName = user.name || 'User';
                const firstName = getFirstName(fullName);
                const initial = firstName.charAt(0).toUpperCase();
                const escapedFirstName = escapeHtml(firstName);

                const existingDashboard = document.getElementById('dashboardView');
                if (!existingDashboard && viewContainer) {
                    viewContainer.innerHTML = getDashboardHtml(firstName, initial, authSource);
                } else {
                    const dashGreetingName = document.getElementById('dashGreetingName');
                    if (dashGreetingName) dashGreetingName.textContent = escapedFirstName;
                }

                // Update Navbar with First Name ONLY and Sign Out button
                if (navLinks) {
                    navLinks.innerHTML = `
                        <li class="user-pill">
                            <div class="user-pill-avatar">${initial}</div>
                            <span class="user-pill-name">${escapedFirstName}</span>
                        </li>
                        <li>
                            <button type="button" class="nav-link btn-nav-logout logout-trigger">Sign Out</button>
                        </li>
                    `;
                }

                // Re-bind click event to all logout triggers
                bindLogoutTriggers();
            }

            function renderGuestView() {
                if (viewContainer && initialGuestHtml) {
                    viewContainer.innerHTML = initialGuestHtml;
                }

                if (navLinks) {
                    navLinks.innerHTML = `
                        <li><a href="{{ route('home') }}" class="nav-link" style="color: #ffffff; background: rgba(255,255,255,0.06);">Home</a></li>
                        <li id="navSignInItem"><a href="{{ route('login') }}" class="nav-link">Sign In</a></li>
                        <li id="navRegisterItem"><a href="{{ route('register') }}" class="nav-link nav-cta">Register</a></li>
                    `;
                }
            }

            async function performLogout() {
                const token = sessionStorage.getItem('auth_token');

                if (token) {
                    try {
                        await fetch('/api/logout', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${token}`,
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            }
                        });
                    } catch (e) {
                        console.warn('API logout failed', e);
                    }
                }

                sessionStorage.removeItem('auth_token');
                sessionStorage.removeItem('user');
                localStorage.removeItem('auth_token');
                localStorage.removeItem('user');

                const webLogoutForm = document.getElementById('webLogoutForm');
                if (webLogoutForm && serverUser) {
                    webLogoutForm.submit();
                    return;
                }

                renderGuestView();
                window.location.replace('{{ route("login") }}');
            }

            function bindLogoutTriggers() {
                document.querySelectorAll('.logout-trigger').forEach(btn => {
                    btn.onclick = (e) => {
                        e.preventDefault();
                        performLogout();
                    };
                });
            }

            // Invalidate bfcache and force reload if navigating back/forward
            window.addEventListener('pageshow', (event) => {
                if (event.persisted || (window.performance && window.performance.getEntriesByType && window.performance.getEntriesByType('navigation')[0]?.type === 'back_forward')) {
                    window.location.reload();
                }
            });

            // Initial binding for server-rendered logout triggers
            bindLogoutTriggers();

            // Check authentication state
            if (serverUser) {
                // Server-authenticated session
                if (!sessionStorage.getItem('user')) {
                    sessionStorage.setItem('user', JSON.stringify(serverUser));
                }
                renderAuthenticatedDashboard(serverUser, 'Session');
            } else if (authToken && localUser && localUser.name) {
                // Token-authenticated session
                renderAuthenticatedDashboard(localUser, 'API Token');

                // Verify token validity and sync user data with /api/profile
                fetch('/api/profile', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    }
                })
                .then(res => {
                    if (res.status === 401) {
                        sessionStorage.removeItem('auth_token');
                        sessionStorage.removeItem('user');
                        renderGuestView();
                    } else if (res.ok) {
                        return res.json();
                    }
                })
                .then(json => {
                    if (json && json.data) {
                        sessionStorage.setItem('user', JSON.stringify(json.data));
                        if (json.data.name !== localUser.name) {
                            renderAuthenticatedDashboard(json.data, 'API Token');
                        }
                    }
                })
                .catch(() => {});
            } else {
                // Guest state
                renderGuestView();
            }
        });
    </script>
</body>
</html>
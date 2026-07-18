<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SchoolMS - School Management System')</title>
    <meta name="description" content="@yield('meta_description', 'Complete school management system built with Laravel.')">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0A2342;
            --primary-light: #1a3a6a;
            --primary-dark: #06152b;
            --secondary: #D97706;
            --secondary-light: #f59e0b;
            --secondary-dark: #b45309;
            --text-light: #f8f9fa;
            --text-muted: #6c757d;
            --bg-light: #f8fafc;
            --bg-gray: #f1f5f9;
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-family);
            color: #1e293b;
            overflow-x: hidden;
            background: #fff;
        }

        /* Navigation */
        .navbar-frontend {
            background: var(--primary) !important;
            padding: 0.875rem 0;
            transition: all 0.3s ease;
        }

        .navbar-frontend .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #fff !important;
            letter-spacing: -0.5px;
        }

        .navbar-frontend .navbar-brand i {
            color: var(--secondary);
            margin-right: 0.5rem;
        }

        .navbar-frontend .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 1rem !important;
            transition: color 0.2s ease;
        }

        .navbar-frontend .nav-link:hover,
        .navbar-frontend .nav-link.active {
            color: var(--secondary) !important;
        }

        /* Buttons */
        .btn-orange {
            background: var(--secondary);
            color: #fff;
            border: 2px solid var(--secondary);
            font-weight: 600;
            padding: 0.625rem 1.75rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-orange:hover,
        .btn-orange:focus {
            background: var(--secondary-dark);
            border-color: var(--secondary-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(217,119,6,0.35);
        }

        .btn-outline-white {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255,255,255,0.7);
            font-weight: 600;
            padding: 0.625rem 1.75rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-outline-white:hover {
            background: rgba(255,255,255,0.1);
            border-color: #fff;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-dark-blue {
            background: var(--primary);
            color: #fff;
            border: 2px solid var(--primary);
            font-weight: 600;
            padding: 0.625rem 1.75rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-dark-blue:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(10,35,66,0.3);
        }

        .btn-outline-dark-blue {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            font-weight: 600;
            padding: 0.625rem 1.75rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-outline-dark-blue:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
        }

        /* Section Titles */
        .section-title {
            font-weight: 800;
            font-size: 2.25rem;
            color: var(--primary);
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.7;
        }

        /* Feature Card */
        .feature-card {
            background: #fff;
            border-radius: 1rem;
            padding: 2.25rem 1.75rem;
            transition: all 0.4s ease;
            border: 1px solid rgba(0,0,0,0.04);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--secondary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(10,35,66,0.10);
            border-color: transparent;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card .icon-box {
            width: 60px;
            height: 60px;
            background: rgba(217,119,6,0.1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--secondary);
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .icon-box {
            background: var(--secondary);
            color: #fff;
        }

        .feature-card h5 {
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .feature-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-card ul li {
            font-size: 0.875rem;
            color: #475569;
            padding: 0.25rem 0;
            position: relative;
            padding-left: 1.25rem;
        }

        .feature-card ul li::before {
            content: '•';
            color: var(--secondary);
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        /* Stat Item */
        .stat-item {
            text-align: center;
            padding: 1.5rem 1rem;
            transition: all 0.3s ease;
        }

        .stat-item .stat-icon {
            font-size: 2rem;
            color: var(--secondary);
            margin-bottom: 0.75rem;
        }

        .stat-item .stat-number {
            font-size: 2.25rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .stat-item .stat-label {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
            font-weight: 400;
            margin-top: 0.25rem;
        }

        /* Benefit Card */
        .benefit-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            background: #fff;
            border: 1px solid rgba(0,0,0,0.04);
        }

        .benefit-card:hover {
            transform: translateX(6px);
            box-shadow: 0 8px 30px rgba(10,35,66,0.08);
        }

        .benefit-card .benefit-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            background: rgba(217,119,6,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            font-size: 1rem;
        }

        .benefit-card h6 {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .benefit-card p {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        /* Screenshot Card */
        .screenshot-card {
            background: #fff;
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.4s ease;
        }

        .screenshot-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(10,35,66,0.12);
        }

        .screenshot-card .screenshot-img {
            height: 180px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.2);
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }

        .screenshot-card .screenshot-img::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(217,119,6,0.15), transparent);
        }

        .screenshot-card .screenshot-img i {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.85);
            font-size: 3rem;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));
        }

        .screenshot-card .screenshot-label {
            padding: 0.75rem 1rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary);
            background: #fff;
        }

        /* Testimonial Card */
        .testimonial-card {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.4s ease;
            height: 100%;
        }

        .testimonial-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(10,35,66,0.08);
        }

        .testimonial-card .stars {
            color: #f59e0b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            letter-spacing: 2px;
        }

        .testimonial-card .quote {
            font-size: 0.95rem;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .testimonial-card .author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .testimonial-card .author-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .testimonial-card .author-info h6 {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--primary);
            margin: 0;
        }

        .testimonial-card .author-info span {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Pricing Card */
        .pricing-card {
            background: #fff;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
        }

        .pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px rgba(10,35,66,0.12);
        }

        .pricing-card.featured {
            transform: scale(1.05);
            border-color: var(--secondary);
            box-shadow: 0 16px 48px rgba(217,119,6,0.15);
        }

        .pricing-card.featured:hover {
            transform: scale(1.05) translateY(-8px);
        }

        .pricing-card .pricing-header {
            padding: 2rem 1.5rem 1.5rem;
            text-align: center;
            background: var(--primary);
            color: #fff;
        }

        .pricing-card.featured .pricing-header {
            background: var(--primary-dark);
        }

        .pricing-card.featured .pricing-header::before {
            content: 'Most Popular';
            position: absolute;
            top: 0.75rem;
            right: -2rem;
            background: var(--secondary);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 2.5rem;
            transform: rotate(45deg);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .pricing-card .pricing-header h5 {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .pricing-card .pricing-header .price {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .pricing-card .pricing-header .price span {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.7;
        }

        .pricing-card .pricing-header .description {
            font-size: 0.85rem;
            opacity: 0.7;
            margin-top: 0.25rem;
        }

        .pricing-card .pricing-body {
            padding: 1.5rem;
        }

        .pricing-card .pricing-body ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pricing-card .pricing-body ul li {
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pricing-card .pricing-body ul li i {
            color: #10b981;
            font-size: 0.8rem;
        }

        .pricing-card .pricing-body ul li i.fa-xmark {
            color: #ef4444;
        }

        .pricing-card .pricing-footer {
            padding: 0 1.5rem 2rem;
            text-align: center;
        }

        /* Fade In Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .fade-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .fade-in-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .fade-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--secondary);
            color: #fff;
            border: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 4px 16px rgba(217,119,6,0.3);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: var(--secondary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(217,119,6,0.4);
        }

        /* Footer */
        .footer {
            background: var(--primary-dark);
            color: rgba(255,255,255,0.7);
            padding: 3rem 0 1.5rem;
        }

        .footer h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1.25rem;
        }

        .footer a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.2s ease;
            font-size: 0.875rem;
        }

        .footer a:hover {
            color: var(--secondary);
        }

        .footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer ul li {
            margin-bottom: 0.5rem;
        }

        .footer .copyright {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 1.5rem;
            margin-top: 2rem;
            font-size: 0.85rem;
            text-align: center;
        }

        /* Dashboard Mockup */
        .dashboard-mockup {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .dashboard-mockup .mockup-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .dashboard-mockup .mockup-header .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dashboard-mockup .mockup-header .dot.red { background: #ef4444; }
        .dashboard-mockup .mockup-header .dot.yellow { background: #f59e0b; }
        .dashboard-mockup .mockup-header .dot.green { background: #10b981; }

        .mockup-stat-card {
            background: rgba(255,255,255,0.08);
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .mockup-stat-card:hover {
            background: rgba(255,255,255,0.14);
            transform: translateY(-2px);
        }

        .mockup-stat-card .mockup-stat-icon {
            font-size: 1.25rem;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        .mockup-stat-card .mockup-stat-number {
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .mockup-stat-card .mockup-stat-label {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Utilities */
        .bg-primary-dark { background: var(--primary) !important; }
        .bg-primary-darker { background: var(--primary-dark) !important; }
        .bg-gradient-primary { background: linear-gradient(135deg, var(--primary), var(--primary-light)) !important; }
        .bg-gradient-orange { background: linear-gradient(135deg, var(--secondary), var(--secondary-dark)) !important; }
        .text-orange { color: var(--secondary) !important; }

        .section-padding {
            padding: 5rem 0;
        }

        .section-bg-light {
            background: var(--bg-light);
        }

        .section-bg-gray {
            background: var(--bg-gray);
        }

        .section-bg-dark {
            background: var(--primary);
        }

        @media (max-width: 991.98px) {
            .section-title { font-size: 1.75rem; }
            .pricing-card.featured { transform: none; }
            .pricing-card.featured:hover { transform: translateY(-8px); }
            .hero-headline { font-size: 2.25rem !important; }
        }

        @media (max-width: 767.98px) {
            .section-padding { padding: 3rem 0; }
            .stat-item .stat-number { font-size: 1.75rem; }
            .dashboard-mockup { margin-top: 2rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-frontend sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap"></i>
                School<span style="color: var(--secondary);">MS</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-orange btn-sm px-4" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a class="navbar-brand fs-4 fw-bolder text-white text-decoration-none d-inline-block mb-3" href="{{ url('/') }}">
                        <i class="fas fa-graduation-cap text-orange"></i>
                        School<span style="color: var(--secondary);">MS</span>
                    </a>
                    <p class="mb-3" style="font-size: 0.9rem; line-height: 1.7;">
                        A complete school management system built with Laravel 12. Simplifying education management for schools worldwide.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white opacity-75 hover-opacity-100" style="font-size: 1.1rem;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white opacity-75 hover-opacity-100" style="font-size: 1.1rem;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white opacity-75 hover-opacity-100" style="font-size: 1.1rem;"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white opacity-75 hover-opacity-100" style="font-size: 1.1rem;"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Modules</h5>
                    <ul>
                        <li><a href="{{ route('login') }}">Students</a></li>
                        <li><a href="{{ route('login') }}">Teachers</a></li>
                        <li><a href="{{ route('login') }}">Attendance</a></li>
                        <li><a href="{{ route('login') }}">Examination</a></li>
                        <li><a href="{{ route('login') }}">Fees</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Contact Us</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-map-marker-alt me-2"></i>123 Education St, Learning City</a></li>
                        <li><a href="#"><i class="fas fa-phone me-2"></i>+1 (555) 123-4567</a></li>
                        <li><a href="#"><i class="fas fa-envelope me-2"></i>info@schoolms.com</a></li>
                        <li><a href="#"><i class="fas fa-clock me-2"></i>Mon-Fri: 9:00 AM - 6:00 PM</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                &copy; {{ date('Y') }} SchoolMS. All rights reserved. Built with <i class="fas fa-heart" style="color: var(--secondary);"></i> and Laravel 12.
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i></button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Back to top
            const backToTop = document.getElementById('backToTop');
            if (backToTop) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 300) { backToTop.classList.add('show'); }
                    else { backToTop.classList.remove('show'); }
                });
                backToTop.addEventListener('click', () => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // IntersectionObserver for fade-in animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>

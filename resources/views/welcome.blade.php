<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SchoolMS') }} - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #0A2342; --amber: #D97706; --navy-light: #1a3a5c; }
        body { font-family: 'Inter', sans-serif; color: #1a1a1a; }
        .hero-bg { background: linear-gradient(135deg, #0A2342 0%, #1a3a5c 50%, #0A2342 100%); }
        .hero-bg::after { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='1.5'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); pointer-events: none; }
        .hero-section { min-height: 90vh; position: relative; overflow: hidden; }
        .hero-section::before { content: ''; position: absolute; top: -200px; right: -200px; width: 600px; height: 600px; background: rgba(217,119,6,0.1); border-radius: 50%; filter: blur(80px); }
        .btn-amber { background: #D97706; color: #fff; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; transition: all 0.3s; }
        .btn-amber:hover { background: #b45309; color: #fff; transform: translateY(-2px); box-shadow: 0 10px 30px rgba(217,119,6,0.3); }
        .btn-outline-amber { color: #D97706; border: 2px solid #D97706; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; background: transparent; transition: all 0.3s; }
        .btn-outline-amber:hover { background: #D97706; color: #fff; }
        .feature-card { border: 1px solid #e5e7eb; border-radius: 16px; padding: 2rem; transition: all 0.3s; background: #fff; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-color: #D97706; }
        .feature-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .stat-card { text-align: center; padding: 2rem; border-radius: 16px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); }
        .stat-card .stat-number { font-size: 2.5rem; font-weight: 800; color: #D97706; }
        .footer { background: #0A2342; color: rgba(255,255,255,0.7); }
        .footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s; }
        .footer a:hover { color: #D97706; }
        .navbar-custom { background: rgba(10,35,66,0.95); backdrop-filter: blur(10px); padding: 0.75rem 0; }
        .navbar-custom .nav-link { color: rgba(255,255,255,0.8) !important; font-weight: 500; transition: color 0.3s; }
        .navbar-custom .nav-link:hover { color: #D97706 !important; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div style="width:36px;height:36px;background:linear-gradient(135deg,#D97706,#b45309);border-radius:8px;display:flex;align-items:center;justify-content:center;margin-right:10px;">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
                <span class="text-white fw-bold">School<span style="color:#D97706">MS</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                <div class="d-flex gap-2 ms-lg-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-amber btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-amber btn-sm">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-amber btn-sm">Get Started</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-bg hero-section d-flex align-items-center">
        <div class="container position-relative" style="z-index:2;">
            <div class="row align-items-center">
                <div class="col-lg-7 text-white">
                    <div class="mb-3">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">
                            <i class="fas fa-star me-1"></i> Trusted by 500+ Schools
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-4" style="line-height:1.2;">
                        Complete <span style="color:#D97706">School Management</span> Solution
                    </h1>
                    <p class="lead mb-4" style="color:rgba(255,255,255,0.8);font-size:1.15rem;">
                        Streamline administration, track student performance, manage fees, and simplify attendance — all in one powerful platform built for modern schools.
                    </p>
                    <div class="d-flex gap-3 mb-5">
                        <a href="{{ route('register') }}" class="btn btn-amber btn-lg px-4">
                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                        </a>
                        <a href="#features" class="btn btn-outline-amber btn-lg px-4">
                            Learn More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                    <div class="row g-4">
                        <div class="col-4">
                            <div class="stat-card">
                                <div class="stat-number">500+</div>
                                <div class="text-white-50 small">Schools</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card">
                                <div class="stat-number">50K+</div>
                                <div class="text-white-50 small">Students</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card">
                                <div class="stat-number">99.9%</div>
                                <div class="text-white-50 small">Uptime</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="position:absolute;top:0;right:0;width:50%;height:100%;opacity:0.05;background:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><rect fill=%22white%22 width=%22200%22 height=%22200%22 fill-opacity=%220.1%22/></svg>');"></div>
    </section>

    <section id="features" class="py-5" style="background:#f8fafc;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color:#0A2342;">Everything You Need</h2>
                <p class="text-muted">Powerful features to manage every aspect of your school</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon mb-3" style="background:rgba(10,35,66,0.1);color:#0A2342;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5 class="fw-bold">Student Management</h5>
                        <p class="text-muted mb-0">Complete student profiles with admission tracking, class assignments, and performance history.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon mb-3" style="background:rgba(217,119,6,0.1);color:#D97706;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="fw-bold">Attendance Tracking</h5>
                        <p class="text-muted mb-0">Quick daily attendance marking with real-time reports and parent notifications.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon mb-3" style="background:rgba(16,185,129,0.1);color:#10b981;">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="fw-bold">Fee Management</h5>
                        <p class="text-muted mb-0">Automated fee collection, payment tracking, receipts, and overdue reminders.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon mb-3" style="background:rgba(139,92,246,0.1);color:#8b5cf6;">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h5 class="fw-bold">Teacher Portal</h5>
                        <p class="text-muted mb-0">Manage teacher profiles, class assignments, schedules, and performance tracking.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon mb-3" style="background:rgba(236,72,153,0.1);color:#ec4899;">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h5 class="fw-bold">Exams & Results</h5>
                        <p class="text-muted mb-0">Create exams, enter marks, generate report cards, and analyze performance trends.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon mb-3" style="background:rgba(6,182,212,0.1);color:#06b6d4;">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h5 class="fw-bold">Analytics Dashboard</h5>
                        <p class="text-muted mb-0">Real-time insights with charts, reports, and exportable data for informed decisions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="position-relative">
                        <div style="background:linear-gradient(135deg,#0A2342,#1a3a5c);border-radius:20px;padding:3rem;color:white;">
                            <div class="row g-3">
                                <div class="col-6"><div class="bg-white bg-opacity-10 rounded-3 p-3 text-center"><div class="fw-bold fs-3" style="color:#D97706;">24/7</div><small>Access</small></div></div>
                                <div class="col-6"><div class="bg-white bg-opacity-10 rounded-3 p-3 text-center"><div class="fw-bold fs-3" style="color:#D97706;">100%</div><small>Cloud Based</small></div></div>
                                <div class="col-6"><div class="bg-white bg-opacity-10 rounded-3 p-3 text-center"><div class="fw-bold fs-3" style="color:#D97706;">5 Min</div><small>Setup Time</small></div></div>
                                <div class="col-6"><div class="bg-white bg-opacity-10 rounded-3 p-3 text-center"><div class="fw-bold fs-3" style="color:#D97706;">Free</div><small>Updates</small></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-3" style="color:#0A2342;">Why Choose SchoolMS?</h2>
                    <p class="text-muted mb-4">SchoolMS is designed by educators for educators. We understand the challenges schools face daily, and we've built a solution that makes management effortless.</p>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-start mb-3"><i class="fas fa-check-circle me-3 mt-1" style="color:#D97706;font-size:1.2rem;"></i><div><strong>Easy to Use</strong><br><span class="text-muted">Intuitive interface that requires no technical knowledge</span></div></li>
                        <li class="d-flex align-items-start mb-3"><i class="fas fa-check-circle me-3 mt-1" style="color:#D97706;font-size:1.2rem;"></i><div><strong>Secure & Reliable</strong><br><span class="text-muted">Enterprise-grade security with automatic backups</span></div></li>
                        <li class="d-flex align-items-start mb-3"><i class="fas fa-check-circle me-3 mt-1" style="color:#D97706;font-size:1.2rem;"></i><div><strong>24/7 Support</strong><br><span class="text-muted">Our team is always here to help when you need it</span></div></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="background:linear-gradient(135deg,#0A2342,#1a3a5c);">
        <div class="container text-center py-4">
            <h2 class="text-white fw-bold mb-3">Ready to Transform Your School?</h2>
            <p class="text-white-50 mb-4">Join 500+ schools already using SchoolMS to streamline their operations.</p>
            <a href="{{ route('register') }}" class="btn btn-amber btn-lg px-5">
                <i class="fas fa-rocket me-2"></i>Get Started Free
            </a>
        </div>
    </section>

    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#D97706,#b45309);border-radius:8px;display:flex;align-items:center;justify-content:center;margin-right:10px;">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <span class="text-white fw-bold fs-5">School<span style="color:#D97706">MS</span></span>
                    </div>
                    <p class="small">Complete school management solution for modern educational institutions.</p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h6 class="text-white fw-bold mb-3">Product</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#features">Features</a></li>
                        <li class="mb-2"><a href="#about">About</a></li>
                        <li class="mb-2"><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h6 class="text-white fw-bold mb-3">Legal</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Privacy</a></li>
                        <li class="mb-2"><a href="#">Terms</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <h6 class="text-white fw-bold mb-3">Contact</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-envelope me-2" style="color:#D97706;"></i>info@schoolms.com</li>
                        <li class="mb-2"><i class="fas fa-phone me-2" style="color:#D97706;"></i>+1 (555) 123-4567</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color:rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="small mb-0">&copy; {{ date('Y') }} SchoolMS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(10,35,66,0.98)';
                nav.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                nav.style.background = 'rgba(10,35,66,0.95)';
                nav.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>

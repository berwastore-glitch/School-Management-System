@extends('layouts.frontend')

@section('title', 'School Management System - Modern Education Platform')
@section('meta_description', 'Complete school management system built with Laravel 12. Manage students, teachers, classes, attendance, exams, fees, and communication.')

@section('content')

<!-- ======= Hero Section ======= -->
<section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #0A2342 0%, #1a3a6a 100%); min-height: 92vh; display: flex; align-items: center;">
    <div class="container position-relative z-1">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-in">
                <p class="text-uppercase fw-semibold mb-2" style="color: rgba(255,255,255,0.6); letter-spacing: 2px; font-size: 0.8rem;">
                    <i class="fas fa-rocket me-2" style="color: var(--secondary);"></i>Next-Gen Education Platform
                </p>
                <h1 class="hero-headline fw-bolder text-white mb-3" style="font-size: 3rem; line-height: 1.15; letter-spacing: -1px;">
                    Complete School<br>Management System
                    <span style="color: var(--secondary);">Built with Laravel 12</span>
                </h1>
                <p class="mb-4" style="font-size: 1.1rem; color: rgba(255,255,255,0.7); line-height: 1.7; max-width: 540px;">
                    Streamline your school operations — manage students, teachers, classes, attendance, examinations, fees, and communication all from one powerful platform.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('register') }}" class="btn btn-orange btn-lg px-4 py-3">
                        <i class="fas fa-rocket me-2"></i>Get Started Free
                    </a>
                    <a href="#features" class="btn btn-outline-white btn-lg px-4 py-3">
                        <i class="fas fa-eye me-2"></i>See Features
                    </a>
                </div>
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <div class="d-flex align-items-center">
                        <div class="d-flex">
                            <div class="rounded-circle border border-2 border-white" style="width: 36px; height: 36px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.75rem; font-weight: 700; margin-right: -8px;">JD</div>
                            <div class="rounded-circle border border-2 border-white" style="width: 36px; height: 36px; background: linear-gradient(135deg, #f093fb, #f5576c); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.75rem; font-weight: 700; margin-right: -8px;">SM</div>
                            <div class="rounded-circle border border-2 border-white" style="width: 36px; height: 36px; background: linear-gradient(135deg, #4facfe, #00f2fe); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.75rem; font-weight: 700; margin-right: -8px;">AK</div>
                            <div class="rounded-circle border border-2 border-white" style="width: 36px; height: 36px; background: var(--secondary); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.75rem; font-weight: 700;">+2K</div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-1 mb-1">
                            <i class="fas fa-star" style="color: #f59e0b; font-size: 0.8rem;"></i>
                            <i class="fas fa-star" style="color: #f59e0b; font-size: 0.8rem;"></i>
                            <i class="fas fa-star" style="color: #f59e0b; font-size: 0.8rem;"></i>
                            <i class="fas fa-star" style="color: #f59e0b; font-size: 0.8rem;"></i>
                            <i class="fas fa-star" style="color: #f59e0b; font-size: 0.8rem;"></i>
                        </div>
                        <p style="font-size: 0.8rem; color: rgba(255,255,255,0.6); margin: 0;">Trusted by 2,000+ schools</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="dashboard-mockup">
                    <div class="mockup-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                        <span style="color: rgba(255,255,255,0.4); font-size: 0.75rem; margin-left: 0.5rem;">Admin Dashboard</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="mockup-stat-card">
                                <div class="mockup-stat-icon"><i class="fas fa-user-graduate"></i></div>
                                <div class="mockup-stat-number"><span class="counter" data-target="1234">0</span></div>
                                <div class="mockup-stat-label">Students</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mockup-stat-card">
                                <div class="mockup-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                                <div class="mockup-stat-number"><span class="counter" data-target="85">0</span></div>
                                <div class="mockup-stat-label">Teachers</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mockup-stat-card">
                                <div class="mockup-stat-icon"><i class="fas fa-door-open"></i></div>
                                <div class="mockup-stat-number"><span class="counter" data-target="24">0</span></div>
                                <div class="mockup-stat-label">Classes</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mockup-stat-card">
                                <div class="mockup-stat-icon"><i class="fas fa-credit-card"></i></div>
                                <div class="mockup-stat-number">RWF <span class="counter" data-target="128">0</span>M</div>
                                <div class="mockup-stat-label">Fees Collected</div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <div style="background: rgba(255,255,255,0.06); border-radius: 0.5rem; padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                    <span style="color: rgba(255,255,255,0.6); font-size: 0.75rem;">Attendance Today</span>
                                </div>
                                <span style="color: #fff; font-weight: 700; font-size: 0.85rem;">94.2%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Features Section ======= -->
<section class="section-padding" id="features" style="background: #f8fafc;">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                <i class="fas fa-cog me-1"></i>Powerful Features
            </span>
            <h2 class="section-title">Everything You Need to Run Your School</h2>
            <p class="section-subtitle">Comprehensive modules designed to simplify every aspect of school management, from enrollment to graduation.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.1s;">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-user-graduate"></i></div>
                    <h5>Student Management</h5>
                    <ul>
                        <li>Complete student profiles with documents and photos</li>
                        <li>Automated roll numbers and ID card generation</li>
                        <li>Advanced search, filters, and bulk import/export</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.2s;">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h5>Teacher Management</h5>
                    <ul>
                        <li>Teacher profiles with qualifications and experience</li>
                        <li>Class and subject assignment management</li>
                        <li>Attendance tracking and performance reports</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.3s;">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-calendar-check"></i></div>
                    <h5>Attendance Tracking</h5>
                    <ul>
                        <li>Daily attendance with bulk and individual entry</li>
                        <li>Real-time reports and monthly summaries</li>
                        <li>Automated SMS/email notifications for absentees</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.4s;">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-file-alt"></i></div>
                    <h5>Examination Module</h5>
                    <ul>
                        <li>Create exams with custom grading schemes and marks</li>
                        <li>Automated report cards and rank generation</li>
                        <li>Subject-wise performance analytics and charts</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.5s;">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-credit-card"></i></div>
                    <h5>Fee Management</h5>
                    <ul>
                        <li>Configure fee structures and payment schedules</li>
                        <li>Online payments via multiple gateways</li>
                        <li>Automatic invoices, receipts, and due reminders</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.6s;">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-bell"></i></div>
                    <h5>Communication</h5>
                    <ul>
                        <li>Send announcements to parents, teachers, and students</li>
                        <li>Integrated SMS, email, and push notifications</li>
                        <li>Two-way messaging with read receipts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= How It Works Section ======= -->
<section class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                <i class="fas fa-list-ol me-1"></i>How It Works
            </span>
            <h2 class="section-title">Get Started in 3 Simple Steps</h2>
            <p class="section-subtitle">Launch your school management system in minutes, not months.</p>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-4 fade-in" style="transition-delay: 0.1s;">
                <div class="text-center position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--secondary), var(--secondary-dark)); color: #fff; font-size: 1.75rem; font-weight: 800;">1</div>
                    <h5 class="fw-bold mb-2" style="color: var(--primary);">Create Your Account</h5>
                    <p class="text-muted" style="font-size: 0.9rem; line-height: 1.6;">Sign up as a teacher or student. Set up your school profile with name, logo, and details in under 2 minutes.</p>
                </div>
            </div>
            <div class="col-lg-4 fade-in" style="transition-delay: 0.2s;">
                <div class="text-center position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; font-size: 1.75rem; font-weight: 800;">2</div>
                    <h5 class="fw-bold mb-2" style="color: var(--primary);">Configure Your School</h5>
                    <p class="text-muted" style="font-size: 0.9rem; line-height: 1.6;">Add curriculums, classes, subjects, teachers, and students. Import existing data with our bulk upload tool.</p>
                </div>
            </div>
            <div class="col-lg-4 fade-in" style="transition-delay: 0.3s;">
                <div class="text-center position-relative">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); color: #fff; font-size: 1.75rem; font-weight: 800;">3</div>
                    <h5 class="fw-bold mb-2" style="color: var(--primary);">Start Managing</h5>
                    <p class="text-muted" style="font-size: 0.9rem; line-height: 1.6;">Take attendance, enter marks, track fees, generate report cards. Your entire school on one platform.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Stats Section ======= -->
<section class="section-padding" style="background: linear-gradient(135deg, #0A2342 0%, #06152b 100%);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-2 col-md-4 col-6 fade-in">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-mobile-alt"></i></div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Responsive Design</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6 fade-in" style="transition-delay: 0.1s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="stat-number">Secure</div>
                    <div class="stat-label">Authentication</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6 fade-in" style="transition-delay: 0.2s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-bolt"></i></div>
                    <div class="stat-number">Laravel 12</div>
                    <div class="stat-label">Powered Platform</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6 fade-in" style="transition-delay: 0.3s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-database"></i></div>
                    <div class="stat-number">MySQL</div>
                    <div class="stat-label">Database Engine</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 fade-in" style="transition-delay: 0.4s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number">Multi-user</div>
                    <div class="stat-label">Role-Based Access</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Why Choose Us Section ======= -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 fade-in-left">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                    <i class="fas fa-check-circle me-1"></i>Why Choose Us
                </span>
                <h2 class="section-title">Why Choose Our System?</h2>
                <p class="text-muted mb-4" style="font-size: 1.05rem; line-height: 1.8;">
                    SchoolMS delivers a modern, all-in-one solution that transforms how educational institutions operate. Built on Laravel 12's robust architecture, our platform offers unmatched reliability, security, and scalability for schools of all sizes.
                </p>
                <p class="text-muted" style="font-size: 0.95rem; line-height: 1.7;">
                    From small private schools to large educational institutions, SchoolMS adapts to your workflow — not the other way around. Our intuitive interface means minimal training time and maximum adoption.
                </p>
            </div>
            <div class="col-lg-6 offset-lg-1 fade-in-right">
                <div class="d-flex flex-column gap-3">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <h6>Modern Laravel 12 Architecture</h6>
                            <p>Built on the latest Laravel framework ensuring high performance, security, and maintainability.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <h6>Intuitive & User-Friendly Interface</h6>
                            <p>Clean, responsive design that works on all devices with minimal learning curve for staff.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <h6>Comprehensive Feature Set</h6>
                            <p>All-in-one platform covering students, teachers, attendance, exams, fees, and communication.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <h6>Role-Based Access Control</h6>
                            <p>Granular permissions for admin, teachers, students, and parents ensure data security.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <h6>Regular Updates & Support</h6>
                            <p>Dedicated support team and regular feature updates to keep your system current.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <h6>Scalable & Customizable</h6>
                            <p>Grows with your institution. Custom modules and integrations available on request.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Screenshots Section ======= -->
<section class="section-padding section-bg-light">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                <i class="fas fa-images me-1"></i>Gallery
            </span>
            <h2 class="section-title">See SchoolMS in Action</h2>
            <p class="section-subtitle">Explore our intuitive modules designed for every stakeholder in your school community.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.1s;">
                <div class="screenshot-card">
                    <div class="screenshot-img" style="background: linear-gradient(135deg, #0A2342, #1a3a6a);">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <div class="screenshot-label">Admin Dashboard</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.2s;">
                <div class="screenshot-card">
                    <div class="screenshot-img" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="screenshot-label">Student Dashboard</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.3s;">
                <div class="screenshot-card">
                    <div class="screenshot-img" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="screenshot-label">Teacher Dashboard</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.4s;">
                <div class="screenshot-card">
                    <div class="screenshot-img" style="background: linear-gradient(135deg, #D97706, #b45309);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="screenshot-label">Attendance Module</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.5s;">
                <div class="screenshot-card">
                    <div class="screenshot-img" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="screenshot-label">Exam Module</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.6s;">
                <div class="screenshot-card">
                    <div class="screenshot-img" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="screenshot-label">Fees Module</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Testimonials Section ======= -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                <i class="fas fa-quote-left me-1"></i>Testimonials
            </span>
            <h2 class="section-title">What Our Users Say</h2>
            <p class="section-subtitle">Hear from school administrators, teachers, and staff who use SchoolMS every day.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 fade-in" style="transition-delay: 0.1s;">
                <div class="testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="quote">"SchoolMS transformed how we manage our school. The attendance and exam modules alone saved us countless hours. Our staff adopted it immediately — the interface is incredibly intuitive."</p>
                    <div class="author">
                        <div class="author-avatar">JD</div>
                        <div class="author-info">
                            <h6>John Davis</h6>
                            <span>Principal, Riverside Academy</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 fade-in" style="transition-delay: 0.2s;">
                <div class="testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="quote">"The fee management module is a game-changer. Online payments, automated reminders, and detailed reports have reduced our administrative workload by over 60%. Exceptional support team."</p>
                    <div class="author">
                        <div class="author-avatar">SM</div>
                        <div class="author-info">
                            <h6>Sarah Mitchell</h6>
                            <span>Administrator, Greenwood School</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 fade-in" style="transition-delay: 0.3s;">
                <div class="testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="quote">"As a teacher, I love how easy it is to take attendance, record grades, and communicate with parents. The dashboard gives me everything I need at a glance. Highly recommend SchoolMS."</p>
                    <div class="author">
                        <div class="author-avatar">AK</div>
                        <div class="author-info">
                            <h6>Ahmed Khan</h6>
                            <span>Senior Teacher, Delta College</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Pricing Section ======= -->
<section class="section-padding section-bg-gray" id="pricing">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                <i class="fas fa-tags me-1"></i>Pricing
            </span>
            <h2 class="section-title">Simple, Transparent Pricing</h2>
            <p class="section-subtitle">Choose the plan that fits your school's needs. All plans include a 14-day free trial.</p>
        </div>
        <div class="row g-4 justify-content-center align-items-stretch">
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.1s;">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h5>Basic</h5>
                        <div class="price">RWF 29,000<span>/mo</span></div>
                        <div class="description">Perfect for small schools</div>
                    </div>
                    <div class="pricing-body">
                        <ul>
                            <li><i class="fas fa-check"></i> Student Management</li>
                            <li><i class="fas fa-check"></i> Teacher Management</li>
                            <li><i class="fas fa-check"></i> Attendance Tracking</li>
                            <li><i class="fas fa-check"></i> Basic Reports</li>
                            <li><i class="fas fa-check"></i> Up to 500 Students</li>
                            <li><i class="fas fa-xmark"></i> Exam Module</li>
                            <li><i class="fas fa-xmark"></i> Fee Management</li>
                            <li><i class="fas fa-xmark"></i> Communication</li>
                        </ul>
                    </div>
                    <div class="pricing-footer">
                        <a href="{{ route('register') }}" class="btn btn-outline-dark-blue w-100">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.2s;">
                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <h5>Professional</h5>
                        <div class="price">RWF 79,000<span>/mo</span></div>
                        <div class="description">Best for growing schools</div>
                    </div>
                    <div class="pricing-body">
                        <ul>
                            <li><i class="fas fa-check"></i> All Basic Features</li>
                            <li><i class="fas fa-check"></i> Examination Module</li>
                            <li><i class="fas fa-check"></i> Fee Management</li>
                            <li><i class="fas fa-check"></i> Communication Tools</li>
                            <li><i class="fas fa-check"></i> Up to 2,000 Students</li>
                            <li><i class="fas fa-check"></i> Advanced Reports</li>
                            <li><i class="fas fa-check"></i> SMS & Email Notifications</li>
                            <li><i class="fas fa-xmark"></i> Custom Branding</li>
                        </ul>
                    </div>
                    <div class="pricing-footer">
                        <a href="{{ route('register') }}" class="btn btn-orange w-100">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 fade-in" style="transition-delay: 0.3s;">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h5>Enterprise</h5>
                        <div class="price">RWF 199,000<span>/mo</span></div>
                        <div class="description">For large institutions</div>
                    </div>
                    <div class="pricing-body">
                        <ul>
                            <li><i class="fas fa-check"></i> All Professional Features</li>
                            <li><i class="fas fa-check"></i> Full Module Access</li>
                            <li><i class="fas fa-check"></i> Unlimited Students</li>
                            <li><i class="fas fa-check"></i> Priority Support</li>
                            <li><i class="fas fa-check"></i> Custom Branding</li>
                            <li><i class="fas fa-check"></i> Dedicated Account Manager</li>
                            <li><i class="fas fa-check"></i> API Access & Integrations</li>
                            <li><i class="fas fa-check"></i> Custom Development</li>
                        </ul>
                    </div>
                    <div class="pricing-footer">
                        <a href="{{ route('register') }}" class="btn btn-dark-blue w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= CTA Section ======= -->
<section class="section-padding" style="background: linear-gradient(135deg, #0A2342 0%, #1a3a6a 50%, #0A2342 100%); position: relative; overflow: hidden;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Ccircle fill=\'%23ffffff\' fill-opacity=\'0.03\' cx=\'50\' cy=\'50\' r=\'40\'/%3E%3C/svg%3E') repeat; background-size: 100px 100px;"></div>
    <div class="container position-relative z-1 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 fade-in">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.2); color: var(--secondary); font-weight: 600; font-size: 0.8rem; border: 1px solid rgba(217,119,6,0.3);">
                    <i class="fas fa-rocket me-1"></i>Get Started Today
                </span>
                <h2 style="font-size: 2.5rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 1rem;">
                    Ready to Transform Your<br>School Management?
                </h2>
                <p style="font-size: 1.1rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto 2rem; line-height: 1.7;">
                    Get started today and see how SchoolMS can help streamline your operations, improve communication, and enhance the learning experience for everyone.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('register') }}" class="btn btn-orange btn-lg px-5 py-3">
                        <i class="fas fa-rocket me-2"></i>Start Free Trial
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-white btn-lg px-5 py-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right').forEach(el => observer.observe(el));

        // Animated counters
        function animateCounters() {
            document.querySelectorAll('.counter').forEach(counter => {
                if (counter.dataset.animated) return;
                const target = +counter.dataset.target;
                const duration = 2000;
                const start = performance.now();

                function update(now) {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    counter.textContent = Math.floor(target * eased).toLocaleString();
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        counter.textContent = target.toLocaleString();
                        counter.dataset.animated = 'true';
                    }
                }
                requestAnimationFrame(update);
            });
        }

        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    heroObserver.disconnect();
                }
            });
        }, { threshold: 0.3 });

        const mockup = document.querySelector('.dashboard-mockup');
        if (mockup) heroObserver.observe(mockup);
    });
</script>
@endpush

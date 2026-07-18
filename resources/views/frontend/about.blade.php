@extends('layouts.frontend')

@section('title', 'About Us - SchoolMS School Management System')
@section('meta_description', 'Learn about SchoolMS — our mission, vision, core values, and the team behind the leading school management platform.')

@section('content')

<!-- ======= Page Header ======= -->
<section class="section-padding" style="background: linear-gradient(135deg, #0A2342 0%, #1a3a6a 100%);">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 fade-in">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.2); color: var(--secondary); font-weight: 600; font-size: 0.8rem; border: 1px solid rgba(217,119,6,0.3);">
                    <i class="fas fa-info-circle me-1"></i>About Us
                </span>
                <h1 class="fw-bolder text-white mb-3" style="font-size: 2.75rem; letter-spacing: -0.5px;">
                    About SchoolMS —<br><span style="color: var(--secondary);">Empowering Education Through Technology</span>
                </h1>
                <p class="mb-0" style="font-size: 1.1rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto; line-height: 1.7;">
                    We are on a mission to transform school management with innovative technology that simplifies administration and enhances learning outcomes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ======= Our Story Section ======= -->
<section class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-in-left">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                    <i class="fas fa-book-open me-1"></i>Our Story
                </span>
                <h2 class="section-title">The Journey So Far</h2>
                <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.8;">
                    SchoolMS was born from a simple observation: schools were drowning in paperwork, fragmented tools, and inefficient processes. Educators were spending more time on administration than on teaching.
                </p>
                <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.8;">
                    Founded in 2020 by a team of educators and technologists, we set out to build a unified platform that could handle every aspect of school management — from admissions to alumni. We combined deep educational expertise with modern Laravel architecture to create a system that is powerful, intuitive, and scalable.
                </p>
                <p class="text-muted mb-0" style="font-size: 1rem; line-height: 1.8;">
                    Today, SchoolMS serves over 500 schools across multiple countries, processing millions of data points daily. But we're just getting started. Our roadmap is packed with innovations powered by AI, analytics, and community feedback.
                </p>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="d-flex flex-column gap-4">
                    <div class="feature-card" style="border-left: 4px solid var(--secondary);">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 56px; height: 56px; background: rgba(217,119,6,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--secondary); flex-shrink: 0;">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-2" style="font-size: 1.2rem; color: var(--primary);">Our Mission</h4>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">
                                    To provide accessible, reliable, and comprehensive school management technology that empowers educators, engages parents, and enhances the learning experience for every student.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="feature-card" style="border-left: 4px solid var(--primary);">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 56px; height: 56px; background: rgba(10,35,66,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--primary); flex-shrink: 0;">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-2" style="font-size: 1.2rem; color: var(--primary);">Our Vision</h4>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">
                                    To become the world's leading education management platform, shaping the future of learning by making technology an integral part of every school's success story.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Core Values Section ======= -->
<section class="section-padding section-bg-light">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                <i class="fas fa-heart me-1"></i>Core Values
            </span>
            <h2 class="section-title">What Drives Us</h2>
            <p class="section-subtitle">These core principles guide every decision we make and every feature we build.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.1s;">
                <div class="feature-card text-center">
                    <div class="icon-box mx-auto" style="width: 64px; height: 64px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--secondary); margin-bottom: 1.25rem;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--primary); font-size: 1.1rem;">Innovation</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                        We constantly push boundaries, embracing emerging technologies to build smarter, faster, and more intuitive solutions for schools.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.2s;">
                <div class="feature-card text-center">
                    <div class="icon-box mx-auto" style="width: 64px; height: 64px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--secondary); margin-bottom: 1.25rem;">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--primary); font-size: 1.1rem;">Excellence</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                        We are committed to delivering the highest quality in everything we do — from our code to our customer support and documentation.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.3s;">
                <div class="feature-card text-center">
                    <div class="icon-box mx-auto" style="width: 64px; height: 64px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--secondary); margin-bottom: 1.25rem;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--primary); font-size: 1.1rem;">Integrity</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                        We uphold the highest standards of data security, privacy, and ethical practices. Our users' trust is our most valuable asset.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.4s;">
                <div class="feature-card text-center">
                    <div class="icon-box mx-auto" style="width: 64px; height: 64px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--secondary); margin-bottom: 1.25rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: var(--primary); font-size: 1.1rem;">Community</h5>
                    <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                        We believe in the power of collaboration. We listen to our community and build features that truly make a difference in education.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Our Team Section ======= -->
<section class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="text-center mb-5 fade-in">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.1); color: var(--secondary); font-weight: 600; font-size: 0.8rem;">
                <i class="fas fa-users me-1"></i>Our Team
            </span>
            <h2 class="section-title">Meet the People Behind SchoolMS</h2>
            <p class="section-subtitle">A passionate team of educators, engineers, and visionaries dedicated to transforming education.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.1s;">
                <div class="feature-card text-center">
                    <div style="width: 88px; height: 88px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.5rem; margin: 0 auto 1.25rem;">
                        JD
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--primary); font-size: 1.05rem;">John Davidson</h5>
                    <p class="mb-2" style="color: var(--secondary); font-weight: 600; font-size: 0.85rem;">CEO & Founder</p>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.6;">
                        Former educator with 15+ years in school administration. Founded SchoolMS to solve the challenges he experienced firsthand.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.2s;">
                <div class="feature-card text-center">
                    <div style="width: 88px; height: 88px; border-radius: 50%; background: linear-gradient(135deg, var(--secondary), var(--secondary-dark)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.5rem; margin: 0 auto 1.25rem;">
                        SM
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--primary); font-size: 1.05rem;">Sarah Mitchell</h5>
                    <p class="mb-2" style="color: var(--secondary); font-weight: 600; font-size: 0.85rem;">Chief Technology Officer</p>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.6;">
                        Full-stack architect with deep expertise in Laravel and cloud infrastructure. Leads our engineering team and technical strategy.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.3s;">
                <div class="feature-card text-center">
                    <div style="width: 88px; height: 88px; border-radius: 50%; background: linear-gradient(135deg, #1a3a6a, #0A2342); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.5rem; margin: 0 auto 1.25rem;">
                        AK
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--primary); font-size: 1.05rem;">Ahmed Khan</h5>
                    <p class="mb-2" style="color: var(--secondary); font-weight: 600; font-size: 0.85rem;">Head of Product</p>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.6;">
                        Product strategist with a keen eye for UX. Ensures every feature we ship is intuitive, valuable, and aligns with school needs.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in" style="transition-delay: 0.4s;">
                <div class="feature-card text-center">
                    <div style="width: 88px; height: 88px; border-radius: 50%; background: linear-gradient(135deg, var(--secondary-dark), var(--secondary)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.5rem; margin: 0 auto 1.25rem;">
                        ER
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--primary); font-size: 1.05rem;">Emily Rodriguez</h5>
                    <p class="mb-2" style="color: var(--secondary); font-weight: 600; font-size: 0.85rem;">Head of Support</p>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.6;">
                        Customer success champion. Builds our support systems and ensures every school gets the help they need, when they need it.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Stats Strip ======= -->
<section class="section-padding" style="background: linear-gradient(135deg, #0A2342 0%, #06152b 100%);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-6 fade-in" style="transition-delay: 0.1s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-school"></i></div>
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Schools</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6 fade-in" style="transition-delay: 0.2s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Students</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6 fade-in" style="transition-delay: 0.3s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="stat-number">5K+</div>
                    <div class="stat-label">Teachers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6 fade-in" style="transition-delay: 0.4s;">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
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
                    Join 500+ Schools Already<br>Using SchoolMS
                </h2>
                <p style="font-size: 1.1rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto 2rem; line-height: 1.7;">
                    Experience the difference a modern school management system can make. Start your journey today.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="#demo" class="btn btn-orange btn-lg px-5 py-3">
                        <i class="fas fa-play-circle me-2"></i>Request a Demo
                    </a>
                    <a href="#" class="btn btn-outline-white btn-lg px-5 py-3">
                        <i class="fas fa-headset me-2"></i>Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

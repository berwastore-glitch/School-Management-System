@extends('layouts.frontend')

@section('title', 'Features - SchoolMS School Management System')
@section('meta_description', 'Explore powerful features of SchoolMS including student management, teacher management, attendance, examinations, fees, timetables, communication, and library management.')

@section('content')

<!-- ======= Page Header ======= -->
<section class="section-padding" style="background: linear-gradient(135deg, #0A2342 0%, #1a3a6a 100%);">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 fade-in">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(217,119,6,0.2); color: var(--secondary); font-weight: 600; font-size: 0.8rem; border: 1px solid rgba(217,119,6,0.3);">
                    <i class="fas fa-cog me-1"></i>Comprehensive Modules
                </span>
                <h1 class="fw-bolder text-white mb-3" style="font-size: 2.75rem; letter-spacing: -0.5px;">
                    Powerful Features for<br><span style="color: var(--secondary);">Modern Schools</span>
                </h1>
                <p class="mb-0" style="font-size: 1.1rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto; line-height: 1.7;">
                    Everything you need to streamline operations, enhance communication, and improve educational outcomes — all in one integrated platform.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 1: Student Management ======= -->
<section class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 fade-in-left">
                <div class="feature-detail-card pe-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Student Management</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Comprehensive student information system that simplifies admissions, enrollment, and record keeping. Maintain complete academic histories, generate transcripts, and manage student profiles with ease.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        From registration to graduation, track every aspect of a student's journey with detailed reports and analytics at your fingertips.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Automated student registration with document upload and verification</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Detailed student profiles with photos, emergency contacts, and medical records</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Complete academic history tracking with grade books and transcript generation</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Bulk import/export, ID card generation, and advanced search capabilities</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="screenshot-label">Student Management Dashboard</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 2: Teacher Management ======= -->
<section class="section-padding section-bg-light">
    <div class="container">
        <div class="row align-items-center mb-5 flex-lg-row-reverse">
            <div class="col-lg-6 fade-in-right">
                <div class="feature-detail-card ps-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Teacher Management</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Empower your educators with a dedicated portal for managing their professional records, class assignments, and performance evaluations. Streamline leave requests and substitute planning.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        Comprehensive tools that help administrators and teachers collaborate effectively for better educational outcomes.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Complete teacher profiles with qualifications, experience, and certifications</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Intelligent class and subject assignment with workload balancing</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Performance tracking with evaluation reports and goal setting</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Leave management system with approval workflows and substitute allocation</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-left">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="screenshot-label">Teacher Management Portal</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 3: Attendance Management ======= -->
<section class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 fade-in-left">
                <div class="feature-detail-card pe-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Attendance Management</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Modern attendance tracking system that goes beyond simple check-ins. Record daily attendance through multiple methods and generate comprehensive reports with actionable insights.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        Keep parents informed and reduce absenteeism with automated notifications and detailed analytics.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Daily attendance tracking with bulk, individual, and biometric integration</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Real-time attendance reports with monthly summaries and trends analysis</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Detailed analytics dashboards showing attendance patterns by class and period</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Automated SMS and email notifications for absentees and late arrivals</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="screenshot-label">Attendance Tracking System</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 4: Examination Management ======= -->
<section class="section-padding section-bg-light">
    <div class="container">
        <div class="row align-items-center mb-5 flex-lg-row-reverse">
            <div class="col-lg-6 fade-in-right">
                <div class="feature-detail-card ps-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Examination Management</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Streamline the entire examination lifecycle from scheduling to result publication. Create custom exam patterns, manage seating arrangements, and publish results with automated report cards.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        Powerful grade analysis tools help identify student strengths and areas for improvement across subjects and terms.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Flexible exam scheduling with custom grading schemes and mark entry</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Automated result processing with report cards, rankings, and transcripts</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Publication system for online results with secure student access</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">In-depth grade analysis with charts, comparisons, and performance trends</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-left">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="screenshot-label">Examination Management Module</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 5: Fee Management ======= -->
<section class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 fade-in-left">
                <div class="feature-detail-card pe-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Fee Management</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Complete financial management system that handles fee structures, online payments, and receipt generation. Configure complex fee schedules for different classes and categories.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        Reduce administrative workload with automated invoicing, payment reminders, and real-time fee tracking dashboards.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Customizable fee structures with installment plans and late fee calculations</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Online payment integration supporting multiple gateways and currencies</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Automatic invoice generation with digital receipts and payment history</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Real-time dues tracking with automated reminders for pending payments</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="screenshot-label">Fee Management Dashboard</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 6: Timetable Management ======= -->
<section class="section-padding section-bg-light">
    <div class="container">
        <div class="row align-items-center mb-5 flex-lg-row-reverse">
            <div class="col-lg-6 fade-in-right">
                <div class="feature-detail-card ps-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Timetable Management</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Intelligent class scheduling system that optimizes resource allocation and prevents conflicts. Create, manage, and publish timetables for multiple classes, teachers, and rooms simultaneously.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        Smart conflict detection ensures no double-booking of teachers or rooms, making schedule management effortless.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Drag-and-drop timetable builder with visual grid interface</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Automatic teacher allocation with workload distribution and period management</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Real-time conflict detection for teachers, rooms, and class groups</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Published timetables accessible via web and mobile for all stakeholders</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-left">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="screenshot-label">Timetable Scheduling System</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 7: Communication ======= -->
<section class="section-padding" style="background: #fff;">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 fade-in-left">
                <div class="feature-detail-card pe-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Communication</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Bridge the gap between school and home with a comprehensive communication platform. Send announcements, alerts, and updates to parents, teachers, and students through multiple channels.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        Integrated SMS, email, and push notifications ensure important messages reach the right people at the right time.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Broadcast announcements to specific groups — classes, parents, or all staff</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">SMS gateway integration for instant alerts and emergency notifications</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Email notification system for daily reports, event reminders, and updates</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Dedicated parent portal with direct messaging and real-time progress updates</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="screenshot-label">Communication & Notification Center</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Feature 8: Library Management ======= -->
<section class="section-padding section-bg-light">
    <div class="container">
        <div class="row align-items-center mb-5 flex-lg-row-reverse">
            <div class="col-lg-6 fade-in-right">
                <div class="feature-detail-card ps-lg-4">
                    <div class="icon-box mb-3" style="width: 70px; height: 70px; background: rgba(217,119,6,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--secondary);">
                        <i class="fas fa-book"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="font-size: 1.75rem; color: var(--primary); letter-spacing: -0.3px;">Library Management</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem; line-height: 1.7;">
                        Modern library automation system that simplifies book inventory management, borrowing workflows, and fine tracking. Students and staff can search the catalog and manage checkouts online.
                    </p>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.7;">
                        Keep your library organized with automated reminders, overdue tracking, and comprehensive usage reports.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Complete book inventory with ISBN lookup, categories, and barcode support</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Automated borrowing and return system with due date tracking</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Fine management with configurable rates and online payment options</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1" style="color: var(--secondary); font-size: 1rem;"></i>
                            <span style="color: #475569; font-size: 0.95rem;">Online catalog search with availability status and reservation system</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 fade-in-left">
                <div class="screenshot-card">
                    <div class="screenshot-img">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="screenshot-label">Library Management System</div>
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

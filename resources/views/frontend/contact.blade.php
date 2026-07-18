@extends('layouts.frontend')

@section('content')
<style>
    .contact-header {
        background: linear-gradient(135deg, #0A2342 0%, #0d2e55 100%);
        padding: 80px 0 60px;
    }
    .contact-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
    }
    .contact-header p {
        font-size: 1.15rem;
        opacity: 0.85;
    }
    .info-card {
        border: 1px solid #e9ecef;
        border-radius: 16px;
        transition: all 0.3s ease;
        height: 100%;
    }
    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(10, 35, 66, 0.08);
    }
    .info-card .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        background: rgba(217, 119, 6, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #D97706;
        margin: 0 auto 16px;
    }
    .info-card h6 {
        font-weight: 700;
        color: #0A2342;
    }
    .info-card p {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    .form-section {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        padding: 2rem;
    }
    .form-section .form-control {
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #dee2e6;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-section .form-control:focus {
        border-color: #D97706;
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
    }
    .form-section .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #0A2342;
        margin-bottom: 6px;
    }
    .btn-orange {
        background: #D97706;
        border-color: #D97706;
        color: #fff;
        border-radius: 50px;
        padding: 12px 36px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-orange:hover {
        background: #c06400;
        border-color: #c06400;
        color: #fff;
        transform: translateY(-1px);
    }
    .map-placeholder {
        border-radius: 16px;
        background: #f1f3f5;
        min-height: 380px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #e9ecef;
        color: #6c757d;
    }
    .map-placeholder i {
        font-size: 3rem;
        color: #D97706;
        margin-bottom: 12px;
    }
    .map-placeholder p {
        font-weight: 500;
    }
    .alert-success {
        border-radius: 12px;
        border-left: 5px solid #198754;
    }
</style>

<section class="contact-header text-white text-center">
    <div class="container">
        <h1>Get in Touch</h1>
        <p class="mb-0 mx-auto" style="max-width: 560px;">Have a question, feedback, or want to learn more? We'd love to hear from you.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-card card text-center p-4">
                    <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                    <h6>Visit Us</h6>
                    <p>123 Education Street,<br>Learning City, ED 10001</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card card text-center p-4">
                    <div class="icon-box"><i class="fas fa-phone"></i></div>
                    <h6>Call Us</h6>
                    <p>+1 (555) 123-4567</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card card text-center p-4">
                    <div class="icon-box"><i class="fas fa-envelope"></i></div>
                    <h6>Email Us</h6>
                    <p>info@schoolms.com</p>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-8">
                <div class="form-section">
                    <h4 class="fw-bold mb-1" style="color: #0A2342;">Send Us a Message</h4>
                    <p class="text-muted mb-4">We'll get back to you within 24 hours.</p>
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="school_name">School Name</label>
                                <input type="text" class="form-control" id="school_name" name="school_name">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="message">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-orange">
                                    <i class="fas fa-paper-plane me-1"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <p class="mb-1">Map Location</p>
                    <span class="small">123 Education Street,<br>Learning City, ED 10001</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

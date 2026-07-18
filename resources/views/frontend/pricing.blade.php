@extends('layouts.frontend')

@section('content')
<style>
    .pricing-header {
        background: linear-gradient(135deg, #0A2342 0%, #0d2e55 100%);
        padding: 80px 0 60px;
    }
    .pricing-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
    }
    .pricing-header p {
        font-size: 1.15rem;
        opacity: 0.85;
    }
    .pricing-card {
        border: 1px solid #e9ecef;
        border-radius: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .pricing-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(10, 35, 66, 0.10);
    }
    .pricing-card.featured {
        border-color: #D97706;
        box-shadow: 0 8px 30px rgba(217, 119, 6, 0.15);
        transform: scale(1.03);
    }
    .pricing-card.featured:hover {
        box-shadow: 0 20px 50px rgba(217, 119, 6, 0.25);
    }
    .badge-popular {
        position: absolute;
        top: 16px;
        right: -32px;
        background: #D97706;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 40px;
        transform: rotate(45deg);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .price-amount {
        font-size: 2.75rem;
        font-weight: 800;
        color: #0A2342;
    }
    .price-period {
        font-size: 1rem;
        color: #6c757d;
    }
    .pricing-card .btn {
        border-radius: 50px;
        font-weight: 600;
        padding: 12px 0;
    }
    .btn-outline-primary {
        border-color: #0A2342;
        color: #0A2342;
    }
    .btn-outline-primary:hover {
        background: #0A2342;
        color: #fff;
    }
    .btn-orange {
        background: #D97706;
        border-color: #D97706;
        color: #fff;
    }
    .btn-orange:hover {
        background: #c06400;
        border-color: #c06400;
        color: #fff;
    }
    .feature-item {
        padding: 8px 0;
        border-bottom: 1px solid #f1f3f5;
        font-size: 0.95rem;
    }
    .feature-item:last-child {
        border-bottom: none;
    }
    .feature-item i {
        color: #D97706;
    }
    .toggle-bg {
        background: #e9ecef;
        border-radius: 50px;
        padding: 4px;
        display: inline-flex;
    }
    .toggle-bg .btn-check:checked + .btn {
        background: #0A2342;
        color: #fff;
        border-color: #0A2342;
    }
    .toggle-bg .btn {
        border-radius: 50px;
        padding: 8px 28px;
        border: none;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.2s;
    }
    .toggle-bg .btn:hover {
        color: #0A2342;
    }
    .comparison-table th {
        background: #0A2342;
        color: #fff;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    .comparison-table th:first-child {
        border-radius: 12px 0 0 0;
    }
    .comparison-table th:last-child {
        border-radius: 0 12px 0 0;
    }
    .comparison-table td {
        vertical-align: middle;
        padding: 14px 16px;
        text-align: center;
    }
    .comparison-table td:first-child {
        text-align: left;
        font-weight: 500;
    }
    .comparison-table tbody tr:nth-child(even) {
        background: #f8f9fa;
    }
    .comparison-table tbody tr:hover {
        background: #fff3e0;
    }
    .comparison-table td i.fa-check {
        color: #198754;
        font-size: 1.1rem;
    }
    .comparison-table td i.fa-times {
        color: #dc3545;
        font-size: 1.1rem;
    }
    .annual-save {
        font-size: 0.8rem;
        background: #d1e7dd;
        color: #0f5132;
        padding: 2px 10px;
        border-radius: 50px;
        font-weight: 600;
        display: inline-block;
        margin-left: 6px;
    }
</style>

<section class="pricing-header text-white text-center">
    <div class="container">
        <h1>Simple, Transparent Pricing</h1>
        <p class="mb-0 mx-auto" style="max-width: 560px;">Choose the perfect plan for your school. No hidden fees, no surprises. Upgrade or downgrade at any time.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="toggle-bg" role="group">
                <input type="radio" class="btn-check" name="billing" id="monthly" value="monthly" checked autocomplete="off">
                <label class="btn" for="monthly">Monthly</label>
                <input type="radio" class="btn-check" name="billing" id="annual" value="annual" autocomplete="off">
                <label class="btn" for="annual">Annual <span class="annual-save">Save 15%</span></label>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-lg-4">
                <div class="pricing-card card h-100" data-monthly="29" data-annual="290">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-1" style="color: #0A2342;">Basic</h5>
                        <p class="text-muted small mb-3">For small schools</p>
                        <div class="mb-3">
                            <span class="price-amount" id="basic-price">$29</span>
                            <span class="price-period" id="basic-period">/mo</span>
                        </div>
                        <p class="text-muted small mb-3">Student Management <span class="fw-semibold">(up to 500)</span></p>
                        <a href="#" class="btn btn-outline-primary w-100 mb-4">Get Started</a>
                        <div class="text-start">
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Student Management <span class="text-muted">(up to 500)</span></div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Attendance Tracking</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Basic Reports</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Email Support</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> 1 School Admin</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="pricing-card featured card h-100" data-monthly="79" data-annual="790">
                    <span class="badge-popular">Most Popular</span>
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-1" style="color: #0A2342;">Professional</h5>
                        <p class="text-muted small mb-3">For growing schools</p>
                        <div class="mb-3">
                            <span class="price-amount" id="pro-price">$79</span>
                            <span class="price-period" id="pro-period">/mo</span>
                        </div>
                        <p class="text-muted small mb-3">All Basic Features <span class="fw-semibold">(unlimited students)</span></p>
                        <a href="#" class="btn btn-orange w-100 mb-4">Get Started</a>
                        <div class="text-start">
                            <div class="feature-item"><i class="fas fa-check me-2"></i> All Basic Features <span class="text-muted">(unlimited students)</span></div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Examination Management</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Fee Management</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Communication Tools</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> SMS Integration</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> 5 School Admins</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="pricing-card card h-100" data-monthly="199" data-annual="1990">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-1" style="color: #0A2342;">Enterprise</h5>
                        <p class="text-muted small mb-3">For large institutions</p>
                        <div class="mb-3">
                            <span class="price-amount" id="enterprise-price">$199</span>
                            <span class="price-period" id="enterprise-period">/mo</span>
                        </div>
                        <p class="text-muted small mb-3">Full Modules <span class="fw-semibold">(Library, Transport)</span></p>
                        <a href="#" class="btn btn-outline-primary w-100 mb-4">Get Started</a>
                        <div class="text-start">
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Full Modules <span class="text-muted">(Library, Transport)</span></div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Priority Support <span class="text-muted">(24/7)</span></div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Custom Branding</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> API Access</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Dedicated Account Manager</div>
                            <div class="feature-item"><i class="fas fa-check me-2"></i> Unlimited Admins</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #0A2342;">Feature Comparison</h2>
            <p class="text-muted">See exactly what you get with each plan.</p>
        </div>
        <div class="table-responsive">
            <table class="table comparison-table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 32%;">Features</th>
                        <th style="width: 22.66%;">Basic</th>
                        <th style="width: 22.66%;">Professional</th>
                        <th style="width: 22.66%;">Enterprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Student Management</td>
                        <td>Up to 500</td>
                        <td><i class="fas fa-check"></i> Unlimited</td>
                        <td><i class="fas fa-check"></i> Unlimited</td>
                    </tr>
                    <tr>
                        <td>Attendance Tracking</td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Examination Management</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Fee Management</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Communication Tools</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>SMS Integration</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Library &amp; Transport Modules</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Basic Reports</td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Email Support</td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Priority Support (24/7)</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Custom Branding</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>API Access</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Dedicated Account Manager</td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-times"></i></td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    <tr>
                        <td>Number of Admins</td>
                        <td>1</td>
                        <td>5</td>
                        <td><i class="fas fa-check"></i> Unlimited</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-3" style="color: #0A2342;">Need a Custom Plan?</h2>
        <p class="text-muted mb-4" style="max-width: 520px; margin: 0 auto;">We offer tailored solutions for school districts and large institutions. Talk to our team.</p>
        <a href="{{ route('contact') }}" class="btn btn-orange px-5 py-2 rounded-pill fw-semibold">Contact Us</a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('input[name="billing"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var isAnnual = document.getElementById('annual').checked;

            document.querySelectorAll('.pricing-card').forEach(function(card) {
                var monthly = parseInt(card.getAttribute('data-monthly'));
                var annual = parseInt(card.getAttribute('data-annual'));
                var priceEl = card.querySelector('.price-amount');
                var periodEl = card.querySelector('.price-period');

                if (isAnnual) {
                    priceEl.textContent = '$' + annual;
                    periodEl.textContent = '/yr';
                } else {
                    priceEl.textContent = '$' + monthly;
                    periodEl.textContent = '/mo';
                }
            });
        });
    });
</script>
@endpush

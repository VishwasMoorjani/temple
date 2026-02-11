<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Donate</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Support Our Mission</h1>
        <p class="text-white-50 fs-5 mt-3" data-aos="fade-up" data-aos-delay="100">Your generosity fuels hope and uplifts our community.</p>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <!-- Cause Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 p-md-5 hover-lift">
                    <div class="feature-icon mx-auto mb-4 bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4 class="playfair mb-3">Education Fund</h4>
                    <p class="text-muted">Support scholarships and educational institutions for community youth.</p>
                    <div class="mt-auto pt-3 border-top">
                        <p class="fw-bold text-primary mb-0">Starting from ₹1,100</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 p-md-5 hover-lift">
                    <div class="feature-icon mx-auto mb-4 bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h4 class="playfair mb-3">Medical Aid</h4>
                    <p class="text-muted">Help fund medical treatments and health camps for those in need.</p>
                    <div class="mt-auto pt-3 border-top">
                        <p class="fw-bold text-primary mb-0">Starting from ₹2,100</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 p-md-5 hover-lift">
                    <div class="feature-icon mx-auto mb-4 bg-success bg-opacity-10 text-success rounded-circle" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                        <i class="fas fa-gopuram"></i>
                    </div>
                    <h4 class="playfair mb-3">Temple Renovation</h4>
                    <p class="text-muted">Contribute to the preservation and renovation of ancient Jain temples.</p>
                    <div class="mt-auto pt-3 border-top">
                        <p class="fw-bold text-primary mb-0">Starting from ₹5,100</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donation Form -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-5">
                            <h6 class="text-primary fw-bold text-uppercase ls-wide mb-2">Contribute</h6>
                            <h2 class="playfair display-6 mb-3">Make Your Donation</h2>
                        </div>

                        <div class="alert border-0 bg-info bg-opacity-10 text-info rounded-4 shadow-sm mb-5 p-4" role="alert">
                            <i class="fas fa-shield-alt me-2"></i> 
                            All donations are eligible for tax exemption under Section 80G. A receipt will be emailed to you.
                        </div>

                        <form class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Full Name *</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" required placeholder="Your full name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Email *</label>
                                <input type="email" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" required placeholder="your@email.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Phone *</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" required placeholder="+91 000 000 0000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Donation Category</label>
                                <select class="form-select form-select-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring">
                                    <option>General Donation</option>
                                    <option>Education Fund</option>
                                    <option>Medical Aid</option>
                                    <option>Temple Renovation</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Amount (₹) *</label>
                                <input type="number" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" min="100" placeholder="Enter amount" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">PAN Number (for 80G)</label>
                                <input type="text" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" placeholder="Optional">
                            </div>
                            <div class="col-12 text-center pt-3">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg">
                                    <i class="fas fa-heart me-2"></i> Make a Donation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-5 text-muted small" data-aos="fade-up">
                    <i class="fas fa-phone-alt me-1 text-primary"></i> For offline donations, call <strong>+91 141 1234567</strong> or email <strong>info@rajasthanjainsabha.in</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift { transition: all 0.3s ease; }
.hover-lift:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
.focus-ring:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(211, 84, 0, 0.15) !important; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Contact Us</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Get in Touch</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="mb-5" data-aos="fade-right">
                    <h2 class="playfair mb-4">Contact Information</h2>
                    <p class="text-muted mb-5">Have questions or need assistance? Our team is here to help you. Reach out to us through any of these channels.</p>
                </div>

                <div class="row g-4">
                    <div class="col-12" data-aos="fade-right" data-aos-delay="100">
                        <div class="card border-0 shadow-sm p-4 rounded-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-4 text-primary">
                                    <i class="fas fa-map-marker-alt fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Our Office</h6>
                                    <p class="text-muted mb-0 small">Johari Bazar, Jaipur, Rajasthan, India</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" data-aos="fade-right" data-aos-delay="200">
                        <div class="card border-0 shadow-sm p-4 rounded-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-4 text-primary">
                                    <i class="fas fa-phone fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Phone Number</h6>
                                    <p class="text-muted mb-0 small">+91 141 1234567</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" data-aos="fade-right" data-aos-delay="300">
                        <div class="card border-0 shadow-sm p-4 rounded-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-4 text-primary">
                                    <i class="fas fa-envelope fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email Address</h6>
                                    <p class="text-muted mb-0 small">info@rajasthanjainsabha.in</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="card border-0 shadow-lg p-3 p-md-5 rounded-5 overflow-hidden">
                    <div class="card-body">
                        <h3 class="playfair mb-4">Send Us a Message</h3>
                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('contact-us') ?>" method="post" class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Your Name *</label>
                                <input type="text" name="name" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" required placeholder="John Doe">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Email Address *</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" required placeholder="john@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Phone Number</label>
                                <input type="text" name="phone" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" placeholder="+91 000 000 0000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Subject *</label>
                                <input type="text" name="subject" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" required placeholder="How can we help?">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Message *</label>
                                <textarea name="message" class="form-control form-control-lg bg-light border-0 rounded-4 px-4 py-3 shadow-none focus-ring" rows="5" required placeholder="Tell us more about your inquiry..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg mt-2">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.focus-ring:focus {
    background-color: #fff !important;
    box-shadow: 0 0 0 0.25rem rgba(211, 84, 0, 0.15) !important;
}
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


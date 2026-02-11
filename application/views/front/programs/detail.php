<?php ob_start(); ?>

<!-- Page Header Overlay -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('programs/upcoming') ?>" class="text-white-50 text-decoration-none">Programs</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Details</li>
            </ol>
        </nav>
        <h1 class="display-5 text-white playfair mb-0" data-aos="fade-up"><?= $event->title ?></h1>
    </div>
</section>

<div class="bg-white py-5">
    <div class="container py-4">
        <div class="row g-5">
            <div class="col-lg-8" data-aos="fade-right">
                <!-- Banner Image with Shadow -->
                <?php if($event->banner_image): ?>
                <div class="mb-5 position-relative">
                    <img src="<?= base_url('assets/uploads/events/'.$event->banner_image) ?>" class="img-fluid rounded-5 shadow-lg w-100" style="max-height: 500px; object-fit: cover;">
                </div>
                <?php endif; ?>

                <div class="event-meta-card d-flex flex-wrap gap-4 p-4 bg-light rounded-4 mb-5 border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                            <i class="far fa-calendar-alt fa-lg"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold text-uppercase ls-wide">Date</p>
                            <p class="mb-0 fw-bold"><?= date('l, d M Y', strtotime($event->event_date)) ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                            <i class="far fa-clock fa-lg"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold text-uppercase ls-wide">Time</p>
                            <p class="mb-0 fw-bold"><?= date('h:i A', strtotime($event->event_date)) ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold text-uppercase ls-wide">Venue</p>
                            <p class="mb-0 fw-bold"><?= $event->venue ?></p>
                        </div>
                    </div>
                </div>

                <div class="event-content lead text-muted lh-lg mb-5">
                    <?= $event->description ?>
                </div>

                <?php if($event->gallery_link): ?>
                <div class="mt-4 pt-4 border-top">
                    <a href="<?= $event->gallery_link ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">
                        <i class="fas fa-images me-2"></i> View Event Gallery
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="sticky-top" style="top: 100px;">
                    <div class="card border-0 shadow-lg rounded-5 overflow-hidden mb-4">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="playfair mb-4 text-center">Interested?</h4>
                            
                            <?php if($event->is_registration_open): ?>
                            <button class="btn btn-primary btn-lg w-100 rounded-pill py-3 mb-4 shadow-sm">
                                <i class="fas fa-user-plus me-2"></i>Register Now
                            </button>
                            <?php endif; ?>

                            <div class="share-box p-4 bg-light rounded-4 text-center mb-4">
                                <h6 class="small fw-bold text-uppercase ls-wide text-muted mb-3">Share this Event</h6>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="#" class="bg-white text-primary p-3 rounded-circle shadow-sm hover-lift"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="bg-white text-info p-3 rounded-circle shadow-sm hover-lift"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="bg-white text-success p-3 rounded-circle shadow-sm hover-lift"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                            
                            <a href="<?= base_url('programs/upcoming') ?>" class="btn btn-outline-secondary w-100 rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i>Back to Programs
                            </a>
                        </div>
                    </div>
                    
                    <div class="card border-0 bg-primary text-white rounded-5 p-4 text-center">
                        <h5 class="mb-3">Need Assistance?</h5>
                        <p class="small text-white-50 mb-4">Contact our committee for any questions about this program.</p>
                        <a href="<?= base_url('contact-us') ?>" class="btn btn-light rounded-pill btn-sm px-4">Help Center</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift { transition: all 0.3s ease; }
.hover-lift:hover { transform: translateY(-5px); }
.ls-wide { letter-spacing: 0.1em; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


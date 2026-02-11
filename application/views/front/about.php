<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">About Rajasthan Jain Sabha</h1>
    </div>
    <!-- Decorative element -->
    <div class="position-absolute top-50 end-0 translate-middle-y opacity-10 pe-5 d-none d-lg-block">
        <i class="fas fa-om fa-10x text-white"></i>
    </div>
</section>

<div class="bg-white py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <?php if(isset($page) && $page): ?>
                    <div class="content lead text-muted" data-aos="fade-up"><?= $page->description ?></div>
                <?php else: ?>
                    <div class="row align-items-center mb-5 g-5">
                        <div class="col-md-7" data-aos="fade-right">
                            <h6 class="text-primary fw-bold text-uppercase ls-wide mb-3">Our Legacy</h6>
                            <h2 class="display-5 playfair mb-4">Dedicated to the Service of Humanity</h2>
                            <p class="lead text-muted mb-4">Rajasthan Jain Sabha is a premier organization dedicated to the social, cultural, and spiritual upliftment of the Jain community across Rajasthan.</p>
                            <p class="text-secondary">Established with a vision to unite and serve, the Sabha has been at the forefront of social welfare, education, and religious activities for decades. Our mission is to preserve and promote Jain values while creating a modern support system for community members.</p>
                        </div>
                        <div class="col-md-5" data-aos="fade-left">
                            <div class="card bg-primary text-white p-5 text-center border-0 shadow-lg rounded-5">
                                <i class="fas fa-om fa-4x mb-4 opacity-50"></i>
                                <h3 class="playfair mb-3">Our Mission</h3>
                                <p class="mb-0 fs-5 text-white-50">To foster unity, preserve heritage, and empower the Jain community through education, healthcare, and spiritual growth.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Section -->
                    <div class="row text-center py-5 g-4 mb-5">
                        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                            <div class="p-4 bg-light rounded-4 border-0 shadow-sm h-100">
                                <h2 class="text-primary fw-bold display-5 mb-1">70+</h2>
                                <p class="mb-0 text-muted text-uppercase small ls-wide">Years of Service</p>
                            </div>
                        </div>
                        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                            <div class="p-4 bg-light rounded-4 border-0 shadow-sm h-100">
                                <h2 class="text-primary fw-bold display-5 mb-1">5000+</h2>
                                <p class="mb-0 text-muted text-uppercase small ls-wide">Members</p>
                            </div>
                        </div>
                        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                            <div class="p-4 bg-light rounded-4 border-0 shadow-sm h-100">
                                <h2 class="text-primary fw-bold display-5 mb-1">100+</h2>
                                <p class="mb-0 text-muted text-uppercase small ls-wide">Events Monthly</p>
                            </div>
                        </div>
                        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="400">
                            <div class="p-4 bg-light rounded-4 border-0 shadow-sm h-100">
                                <h2 class="text-primary fw-bold display-5 mb-1">50+</h2>
                                <p class="mb-0 text-muted text-uppercase small ls-wide">Temples Supported</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-5" data-aos="fade-up">
                        <h6 class="text-primary fw-bold text-uppercase ls-wide mb-3">What We Do</h6>
                        <h2 class="display-6 playfair">Key Initiatives & Impact</h2>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="card h-100 border-0 shadow-sm p-4 hover-lift rounded-4">
                                <div class="card-body text-center">
                                    <div class="feature-icon mx-auto mb-4 bg-light text-primary rounded-circle" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <h4 class="playfair mb-3">Education Support</h4>
                                    <p class="text-muted">Scholarships and educational support for deserving students from the community to build a better future.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="card h-100 border-0 shadow-sm p-4 hover-lift rounded-4">
                                <div class="card-body text-center">
                                    <div class="feature-icon mx-auto mb-4 bg-light text-danger rounded-circle" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                                        <i class="fas fa-heartbeat"></i>
                                    </div>
                                    <h4 class="playfair mb-3">Medical Aid</h4>
                                    <p class="text-muted">Regular health camps and financial assistance for community members facing medical emergencies.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="card h-100 border-0 shadow-sm p-4 hover-lift rounded-4">
                                <div class="card-body text-center">
                                    <div class="feature-icon mx-auto mb-4 bg-light text-success rounded-circle" style="width: 80px; height: 80px; line-height: 80px; font-size: 2rem;">
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </div>
                                    <h4 class="playfair mb-3">Social Welfare</h4>
                                    <p class="text-muted">Extensive pension schemes and donation drives dedicated to the elderly and disenfranchised.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


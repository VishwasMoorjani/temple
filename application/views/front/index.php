<?php ob_start(); ?>

<!-- Hero Slider -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php if(!empty($sliders)): foreach($sliders as $key => $slide): ?>
        <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
            <div class="hero-section" style="background-image: url('<?= base_url('assets/uploads/sliders/'.$slide->image_path) ?>');">
                <div class="hero-overlay"></div>
                <div class="container position-relative z-3">
                    <div class="row">
                        <div class="col-lg-8" data-aos="fade-up">
                            <h1 class="display-3 text-white mb-4 playfair"><?= $slide->title ?></h1>
                            <?php if($slide->link_url): ?>
                            <a href="<?= $slide->link_url ?>" class="btn btn-primary btn-lg px-5 mt-3">Explore Now <i class="fas fa-arrow-right ms-2"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
        <!-- Fallback Static Hero -->
        <div class="carousel-item active">
            <div class="hero-section" style="background-image: url('https://images.unsplash.com/photo-1548013146-72479768bbaa?auto=format&fit=crop&q=80&w=1600');">
                <div class="hero-overlay"></div>
                <div class="container position-relative z-3">
                    <div class="row">
                        <div class="col-lg-8" data-aos="fade-up">
                            <span class="badge bg-accent text-dark mb-3 px-3 py-2 rounded-pill fw-bold">ESTABLISHED 1953</span>
                            <h1 class="display-2 text-white mb-4 playfair">Preserving Jain Heritage <br>& Serving Humanity</h1>
                            <p class="lead text-white-50 mb-5 fs-4">A premier organization dedicated to the social, cultural, and spiritual upliftment of the community.</p>
                            <div class="d-flex gap-3">
                                <a href="<?= base_url('register') ?>" class="btn btn-primary btn-lg px-5">Join Us</a>
                                <a href="<?= base_url('about-us') ?>" class="btn btn-outline-light btn-lg px-5 rounded-pill">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Intro Section -->
<section class="py-5 overflow-hidden">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="<?=base_url('assets/front/images/temple.png')?>" class="img-fluid rounded-5 shadow-lg" alt="Temple">
                    <div class="position-absolute bottom-0 end-0 bg-primary p-4 rounded-4 shadow-lg m-4 d-none d-md-block" data-aos="zoom-in" data-aos-delay="200">
                        <h4 class="text-white mb-0">70+ Years</h4>
                        <p class="text-white-50 mb-0 small">Of Community Service</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h6 class="text-primary fw-bold text-uppercase ls-wide mb-3">About Rajasthan Jain Sabha</h6>
                <h2 class="display-5 mb-4 playfair">A Legacy of Faith and Compassion</h2>
                <div class="text-muted mb-4 lead">
                    <?php if(!empty($home_intro)): ?>
                        <?= $home_intro->content ?>
                    <?php else: ?>
                        <p>Rajasthan Jain Sabha has been at the forefront of community development, spiritual growth, and social welfare. We strive to bring the Jain community together through shared values and collective action.</p>
                    <?php endif; ?>
                </div>
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded-circle me-3"><i class="fas fa-heart text-primary"></i></div>
                            <h6 class="mb-0">Social Welfare</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded-circle me-3"><i class="fas fa-book-open text-primary"></i></div>
                            <h6 class="mb-0">Education Support</h6>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('about-us') ?>" class="btn btn-outline-primary px-5">View Our History</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-5">
        <div class="row g-4 text-center">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 rounded-4 border border-secondary bg-white bg-opacity-10 backdrop-blur">
                    <h2 class="display-4 fw-bold text-white mb-2 counter"><?= $stats['total_members'] ?></h2>
                    <p class="text-accent text-uppercase small ls-wide mb-0">Active Members</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 rounded-4 border border-secondary bg-white bg-opacity-10 backdrop-blur">
                    <h2 class="display-4 fw-bold text-white mb-2 counter"><?= $stats['total_business'] ?></h2>
                    <p class="text-accent text-uppercase small ls-wide mb-0">Business Network</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="p-4 rounded-4 border border-secondary bg-white bg-opacity-10 backdrop-blur">
                    <h2 class="display-4 fw-bold text-white mb-2 counter"><?= $stats['total_donations'] ?></h2>
                    <p class="text-accent text-uppercase small ls-wide mb-0">Donations (₹)</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="p-4 rounded-4 border border-secondary bg-white bg-opacity-10 backdrop-blur">
                    <h2 class="display-4 fw-bold text-white mb-2 counter"><?= $stats['total_applications'] ?></h2>
                    <p class="text-accent text-uppercase small ls-wide mb-0">Help Requests</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services / Directories -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase ls-wide mb-3">Our Resources</h6>
            <h2 class="display-5 playfair">Digital Directories</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 p-4 border-0 text-center">
                    <div class="card-body">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-gopuram"></i>
                        </div>
                        <h4 class="mb-3">Temples Directory</h4>
                        <p class="text-muted mb-4">A comprehensive guide to Jain temples in Rajasthan with location and timings.</p>
                        <a href="<?= base_url('information/temples') ?>" class="text-primary fw-bold text-decoration-none">Explore Directory <i class="fas fa-chevron-right ms-2 mt-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 p-4 border-0 text-center">
                    <div class="card-body">
                        <div class="feature-icon mx-auto" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <h4 class="mb-3">Dharmshala Hub</h4>
                        <p class="text-muted mb-4">Find and book community hospedajes and dharmshalas for your pilgrimage travel.</p>
                        <a href="<?= base_url('information/dharmshalas') ?>" class="text-primary fw-bold text-decoration-none">Search Now <i class="fas fa-chevron-right ms-2 mt-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 p-4 border-0 text-center">
                    <div class="card-body">
                        <div class="feature-icon mx-auto" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h4 class="mb-3">Social Support</h4>
                        <p class="text-muted mb-4">Access various community support funds, scholarships, and medical aids.</p>
                        <a href="<?= base_url('donate') ?>" class="text-primary fw-bold text-decoration-none">Get Assistance <i class="fas fa-chevron-right ms-2 mt-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Events -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <h6 class="text-primary fw-bold text-uppercase ls-wide mb-3">Stay Updated</h6>
                <h2 class="display-5 playfair mb-0">Upcoming Programs</h2>
            </div>
            <a href="<?= base_url('programs/upcoming') ?>" class="btn btn-outline-primary px-4 mb-2">View Calendar</a>
        </div>
        
        <div class="row g-4">
            <?php if(!empty($upcoming)): foreach($upcoming as $key => $event): ?>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?= $key * 100 ?>">
                <div class="card h-100 overflow-hidden border-0">
                    <div class="position-relative overflow-hidden">
                        <?php if($event->banner_image): ?>
                        <img src="<?= base_url('assets/uploads/events/'.$event->banner_image) ?>" class="card-img-top hover-zoom" style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="far fa-calendar-alt fa-3x opacity-25"></i>
                        </div>
                        <?php endif; ?>
                        <div class="position-absolute top-0 end-0 p-3">
                            <div class="bg-white rounded-4 p-2 text-center shadow-sm" style="min-width: 60px;">
                                <span class="d-block fw-bold fs-5 text-primary"><?= date('d', strtotime($event->event_date)) ?></span>
                                <span class="d-block small text-uppercase fw-bold"><?= date('M', strtotime($event->event_date)) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><?= $event->title ?></h5>
                        <p class="card-text text-muted small mb-4"><i class="fas fa-map-marker-alt text-primary me-2"></i> <?= $event->venue ?></p>
                        <a href="<?= base_url('programs/'.$event->slug) ?>" class="btn btn-link text-primary p-0 text-decoration-none fw-bold">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="far fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No programs scheduled at this time. Check back later!</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5">
    <div class="container py-5">
        <div class="bg-primary rounded-5 p-5 text-center position-relative overflow-hidden shadow-lg" data-aos="zoom-in">
            <div class="position-relative z-3">
                <h2 class="display-4 text-white playfair mb-4">Be Part of Something Greater</h2>
                <p class="text-white-50 lead mb-5 px-lg-5 mx-lg-5">Join the Rajasthan Jain Sabha and contribute to the heritage, education, and welfare of our community.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg px-5">Join Now</a>
                    <a href="<?= base_url('contact-us') ?>" class="btn btn-outline-light btn-lg px-5 rounded-pill">Contact Us</a>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute top-0 start-0 translate-middle bg-white opacity-10 rounded-circle" style="width: 300px; height: 300px;"></div>
            <div class="position-absolute bottom-0 end-0 translate-middle-y bg-white opacity-10 rounded-circle me-n5" style="width: 200px; height: 200px;"></div>
        </div>
    </div>
</section>

<?php $content = ob_get_clean(); ?>
<?php include('layout.php'); ?>


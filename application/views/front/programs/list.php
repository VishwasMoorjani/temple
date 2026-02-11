<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Programs</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up"><?= $page_title ?></h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-4">
            <?php if(!empty($events)): foreach($events as $key => $e): ?>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= ($key % 2) * 100 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
                    <div class="row g-0 h-100">
                        <div class="col-sm-4">
                            <div class="position-relative h-100">
                                <?php if($e->banner_image): ?>
                                <img src="<?= base_url('assets/uploads/events/'.$e->banner_image) ?>" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 200px;">
                                <?php else: ?>
                                <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center h-100" style="min-height: 200px;">
                                    <i class="far fa-calendar-alt fa-3x opacity-25"></i>
                                </div>
                                <?php endif; ?>
                                <div class="position-absolute top-0 start-0 m-3 px-2 py-1 bg-white rounded-3 shadow-sm text-center">
                                    <span class="d-block fw-bold text-primary lh-1"><?= date('d', strtotime($e->event_date)) ?></span>
                                    <span class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;"><?= date('M', strtotime($e->event_date)) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body p-4 d-flex flex-column h-100">
                                <h4 class="playfair mb-3 text-truncate-2"><?= $e->title ?></h4>
                                <div class="d-flex flex-column gap-2 mb-4 text-muted small">
                                    <span><i class="far fa-clock text-primary me-2"></i><?= date('h:i A', strtotime($e->event_date)) ?></span>
                                    <span><i class="fas fa-map-marker-alt text-primary me-2"></i><?= $e->venue ?></span>
                                </div>
                                <p class="text-secondary small mb-4 line-clamp-2"><?= character_limiter(strip_tags($e->description), 100) ?></p>
                                <div class="mt-auto">
                                    <a href="<?= base_url('programs/'.$e->slug) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                        <?= (isset($type) && $type == 'upcoming') ? 'Register Now' : 'View Highlights' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                    <i class="far fa-calendar-times fa-4x text-muted mb-4 opacity-25"></i>
                    <h3 class="playfair">No Programs Scheduled</h3>
                    <p class="text-muted mb-0">Stay tuned for upcoming spiritual events and community programs.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.hover-lift { transition: all 0.3s ease; }
.hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


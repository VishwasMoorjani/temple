<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Careers</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Community Job Opportunities</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-4">
            <?php if(!empty($jobs)): foreach($jobs as $key => $j): ?>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= ($key % 2) * 100 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h4 class="playfair mb-1"><?= $j->title ?></h4>
                                <?php if(isset($j->company_name)): ?>
                                <p class="text-primary fw-bold mb-0 small text-uppercase ls-wide"><?= $j->company_name ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 small">Active</span>
                        </div>
                        
                        <div class="d-flex align-items-center mb-4 gap-4 text-muted small">
                            <span><i class="fas fa-map-marker-alt text-primary me-2"></i><?= $j->location ?></span>
                            <?php if(isset($j->expiry_date)): ?>
                            <span><i class="far fa-calendar-alt text-primary me-2"></i>Expires: <?= date('d M Y', strtotime($j->expiry_date)) ?></span>
                            <?php endif; ?>
                        </div>

                        <p class="text-secondary small mb-4 lh-lg"><?= character_limiter(strip_tags($j->description), 200) ?></p>
                        
                        <div class="border-top pt-4 d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Posted by Sabha Member</span>
                            <?php if(isset($j->contact_email)): ?>
                            <a href="mailto:<?= $j->contact_email ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i>Apply Now
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="fas fa-briefcase fa-4x text-muted mb-4 opacity-25"></i>
                    <h3 class="playfair">No Opportunities Found</h3>
                    <p class="text-muted">Currently, there are no active job listings. Please check back soon.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if(!empty($pagination)): ?>
        <div class="mt-5 d-flex justify-content-center">
            <div class="pagination-wrapper shadow-sm rounded-pill bg-white px-4 py-2" data-aos="fade-up">
                <?= $pagination ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.hover-lift { transition: all 0.3s ease; }
.hover-lift:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important; }
.pagination a, .pagination strong { border: none; padding: 8px 16px; margin: 0 4px; border-radius: 50px; color: var(--secondary-color); text-decoration: none; font-weight: 600; }
.pagination strong { background: var(--primary-color); color: white; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


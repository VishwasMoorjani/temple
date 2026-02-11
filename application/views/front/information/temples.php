<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Temples</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Temples Directory</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-4">
            <?php if(!empty($temples)): foreach($temples as $key => $t): ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= ($key % 3) * 100 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
                    <div class="position-relative">
                        <?php if($t->image_path): ?>
                            <img src="<?= base_url('assets/uploads/temples/'.$t->image_path) ?>" class="card-img-top hover-zoom" style="height: 240px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="height: 240px;">
                                <i class="fas fa-gopuram fa-4x opacity-25"></i>
                            </div>
                        <?php endif; ?>
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark">
                            <span class="badge bg-primary rounded-pill px-3 py-1 small"><?= $t->city ?></span>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <h4 class="playfair mb-3"><?= $t->name ?></h4>
                        <p class="text-muted small mb-4"><i class="fas fa-map-marker-alt text-primary me-2"></i><?= character_limiter($t->address, 100) ?></p>
                        
                        <div class="border-top pt-3 mt-3">
                            <h6 class="small fw-bold text-uppercase ls-wide text-muted mb-2">Contact Person</h6>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle text-primary me-2"></i>
                                <span class="small"><?= $t->contact_person ?></span>
                            </div>
                            <?php if(!empty($t->phone)): ?>
                            <div class="d-flex align-items-center mt-1">
                                <i class="fas fa-phone-alt text-primary me-2 small"></i>
                                <span class="small fw-bold"><?= $t->phone ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="fas fa-gopuram fa-4x text-muted mb-4 opacity-25"></i>
                    <h3 class="playfair">Listings Coming Soon</h3>
                    <p class="text-muted">We are currently updating our temple directory. Please check back later.</p>
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
.bg-gradient-dark { background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%); }
.pagination a, .pagination strong { border: none; padding: 8px 16px; margin: 0 4px; border-radius: 50px; color: var(--secondary-color); text-decoration: none; font-weight: 600; }
.pagination strong { background: var(--primary-color); color: white; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


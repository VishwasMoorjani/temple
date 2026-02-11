<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Dharmshala</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Dharmshala Directory</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-4">
            <?php if(!empty($dharmshalas)): foreach($dharmshalas as $key => $d): ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= ($key % 3) * 100 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
                    <div class="position-relative">
                        <?php if(isset($d->image_path) && $d->image_path): ?>
                            <img src="<?= base_url('assets/uploads/dharmshalas/'.$d->image_path) ?>" class="card-img-top hover-zoom" style="height: 240px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="height: 240px;">
                                <i class="fas fa-bed fa-4x opacity-25"></i>
                            </div>
                        <?php endif; ?>
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark">
                            <span class="badge bg-info rounded-pill px-3 py-1 small"><?= $d->city ?></span>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <h4 class="playfair mb-3"><?= $d->name ?></h4>
                        <p class="text-muted small mb-4"><i class="fas fa-map-marker-alt text-danger me-2"></i><?= character_limiter($d->address, 100) ?></p>
                        
                        <div class="d-flex gap-3 mb-4">
                            <?php if(isset($d->rooms_available)): ?>
                            <div class="small text-muted"><i class="fas fa-door-open text-primary me-1"></i> <?= $d->rooms_available ?> Rooms</div>
                            <?php endif; ?>
                            <div class="small text-muted"><i class="fas fa-check-circle text-success me-1"></i> Community verified</div>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <h6 class="small fw-bold text-uppercase ls-wide text-muted mb-2">Management</h6>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                <span class="small"><?= $d->contact_person ?></span>
                            </div>
                            <div class="d-flex align-items-center mt-1">
                                <i class="fas fa-phone-alt text-primary me-2 small"></i>
                                <span class="small fw-bold"><?= $d->phone ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="fas fa-hotel fa-4x text-muted mb-4 opacity-25"></i>
                    <h3 class="playfair">No Directory Found</h3>
                    <p class="text-muted">Currently, there are no dharmshalas listed. Check again soon!</p>
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


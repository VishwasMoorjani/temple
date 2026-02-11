<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Maharaj & Mataji</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up"><?= $page_title ?></h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-4 justify-content-center">
            <?php if(!empty($maharaj)): foreach($maharaj as $key => $m): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($key % 3) * 100 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift p-3 bg-white">
                    <div class="position-relative mb-4">
                        <?php 
                        $img_path = FCPATH.'assets/uploads/maharaj/'.$m->image_path;
                        if($m->image_path && file_exists($img_path)): 
                        ?>
                            <img src="<?= base_url('assets/uploads/maharaj/'.$m->image_path) ?>" class="card-img-top rounded-4 shadow-sm" alt="<?= $m->name ?>" style="height: 380px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded-4" style="height: 380px;">
                                <i class="fas fa-om fa-6x opacity-10"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-3 text-center">
                        <h3 class="playfair text-primary mb-3"><?= $m->name ?></h3>
                        <div class="text-muted small lh-lg">
                            <?= !empty($m->description) ? nl2br($m->description) : 'A dedicated spiritual leader serving the community through guidance and devotion.' ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="fas fa-om fa-4x text-muted mb-4 opacity-25"></i>
                    <h3 class="playfair">Information Coming Soon</h3>
                    <p class="text-muted">We are currently profiling our respected spiritual leaders. Please visit again.</p>
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
.hover-lift:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Gallery</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Photo Gallery</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <?php if(isset($gallery) && !empty($gallery)): ?>
        <div class="row g-4">
            <?php foreach($gallery as $key => $img): ?>
            <div class="col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="<?= ($key % 3) * 100 ?>">
                <div class="card border-0 shadow-sm overflow-hidden rounded-4 hover-lift h-100">
                    <div class="position-relative">
                        <img src="<?= base_url('assets/uploads/gallery/'.$img->image) ?>" class="card-img-top hover-zoom" style="height: 300px; object-fit: cover;" alt="<?= $img->title ?? 'Gallery Image' ?>">
                        <div class="gallery-overlay d-flex align-items-center justify-content-center">
                            <i class="fas fa-expand text-white fa-2x"></i>
                        </div>
                    </div>
                    <?php if(!empty($img->title)): ?>
                    <div class="card-body py-3 text-center">
                        <h6 class="mb-0 text-secondary fw-bold"><?= $img->title ?></h6>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5" data-aos="fade-up">
            <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                <i class="fas fa-images fa-4x text-muted mb-4 opacity-25"></i>
                <h3 class="playfair">Memories Loading</h3>
                <p class="text-muted mb-0">Our gallery is currently being curated. We'll be sharing beautiful moments soon.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(211, 84, 0, 0.4);
    opacity: 0;
    transition: all 0.3s ease;
    backdrop-filter: blur(2px);
}
.card:hover .gallery-overlay {
    opacity: 1;
}
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


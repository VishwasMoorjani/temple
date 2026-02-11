<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('news') ?>" class="text-white-50 text-decoration-none">News</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Article</li>
            </ol>
        </nav>
        <h1 class="display-5 text-white playfair mb-0" data-aos="fade-up"><?= $news->title ?></h1>
    </div>
</section>

<div class="bg-white py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9" data-aos="fade-up">
                <div class="d-flex align-items-center mb-5 gap-3">
                    <div class="bg-primary text-white p-3 rounded-4 text-center" style="min-width: 70px;">
                        <span class="d-block fw-bold fs-4 lh-1"><?= date('d', strtotime($news->publish_date)) ?></span>
                        <span class="small text-uppercase text-white-50"><?= date('M Y', strtotime($news->publish_date)) ?></span>
                    </div>
                    <p class="text-muted mb-0">Published on <?= date('l, d F Y', strtotime($news->publish_date)) ?></p>
                </div>

                <?php if($news->image_path): ?>
                <div class="mb-5">
                    <img src="<?= base_url('assets/uploads/news/'.$news->image_path) ?>" class="img-fluid rounded-5 shadow-lg w-100" style="max-height: 500px; object-fit: cover;" alt="<?= $news->title ?>">
                </div>
                <?php endif; ?>

                <div class="content lead text-secondary lh-lg mb-5">
                    <?= $news->content ?>
                </div>

                <?php if($news->attachement_path): ?>
                <div class="p-4 p-md-5 bg-light rounded-5 border-0 shadow-sm mb-5">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-4">
                            <i class="fas fa-paperclip fa-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="playfair mb-1">Attachment Available</h5>
                            <p class="text-muted small mb-0">Download the related document for more details.</p>
                        </div>
                        <a href="<?= base_url('assets/uploads/news/'.$news->attachement_path) ?>" target="_blank" class="btn btn-primary rounded-pill px-5 shadow-sm">
                            <i class="fas fa-download me-2"></i> Download
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="border-top pt-5">
                    <a href="<?= base_url('news') ?>" class="btn btn-outline-secondary rounded-pill px-5">
                        <i class="fas fa-arrow-left me-2"></i> Back to News
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

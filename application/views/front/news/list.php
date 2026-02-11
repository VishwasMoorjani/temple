<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">News</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up"><?= $page_title ?></h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if(!empty($news)): foreach($news as $key => $n): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden hover-lift" data-aos="fade-up" data-aos-delay="<?= ($key % 3) * 80 ?>">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-stretch">
                            <div class="col-md-2 col-3">
                                <div class="bg-primary text-white d-flex flex-column align-items-center justify-content-center h-100 p-3" style="min-height: 140px;">
                                    <span class="display-4 fw-bold lh-1 mb-1"><?= date('d', strtotime($n->publish_date)) ?></span>
                                    <span class="text-uppercase small fw-bold ls-wide text-white-50"><?= date('M', strtotime($n->publish_date)) ?></span>
                                    <span class="text-white-50 small"><?= date('Y', strtotime($n->publish_date)) ?></span>
                                </div>
                            </div>
                            <div class="col-md-10 col-9">
                                <div class="p-4 p-md-5">
                                    <h4 class="playfair mb-3"><?= $n->title ?></h4>
                                    <p class="text-muted mb-4"><?= character_limiter(strip_tags($n->content), 200) ?></p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?= base_url('news/'.$n->slug) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                            Read Full Story <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                        <?php if($n->attachement_path): ?>
                                        <a href="<?= base_url('assets/uploads/news/'.$n->attachement_path) ?>" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                                            <i class="fas fa-file-pdf me-1"></i> Download PDF
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <div class="text-center py-5" data-aos="fade-up">
                    <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                        <i class="far fa-newspaper fa-4x text-muted mb-4 opacity-25"></i>
                        <h3 class="playfair">No News Yet</h3>
                        <p class="text-muted mb-0">Stay tuned for the latest updates and announcements.</p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($pagination)): ?>
                <div class="mt-5 d-flex justify-content-center">
                    <div class="pagination-wrapper shadow-sm rounded-pill bg-white px-4 py-2" data-aos="fade-up">
                        <?= $pagination ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift { transition: all 0.3s ease; }
.hover-lift:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.1) !important; }
.pagination a, .pagination strong { border: none; padding: 8px 16px; margin: 0 4px; border-radius: 50px; color: var(--secondary-color); text-decoration: none; font-weight: 600; }
.pagination strong { background: var(--primary-color); color: white; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

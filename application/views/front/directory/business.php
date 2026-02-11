<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Business Directory</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Yellow Pages</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <!-- Search & Filter -->
        <div class="card mb-5 border-0 shadow-lg rounded-4 overflow-hidden" data-aos="fade-up">
            <div class="card-body p-4 p-md-5">
                <form action="<?= base_url('business') ?>" method="get" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Business Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 px-3"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none fs-6" placeholder="Find by name..." value="<?= isset($search_q) ? $search_q : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Category</label>
                        <select name="cat" class="form-select form-select-lg bg-light border-0 rounded-4 shadow-none fs-6">
                            <option value="">All Categories</option>
                            <?php if(!empty($categories)): foreach($categories as $c): ?>
                            <option value="<?= $c->id ?>" <?= $this->input->get('cat') == $c->id ? 'selected' : '' ?>><?= $c->name ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-4 shadow-sm">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Business grid -->
        <div class="row g-4">
            <?php if(!empty($businesses)): foreach($businesses as $key => $b): ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= ($key % 3) * 100 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm border border-white border-2" style="width: 70px; height: 70px; flex-shrink: 0; overflow: hidden;">
                            <?php if(!empty($b->logo) && file_exists(FCPATH.'assets/uploads/business/'.$b->logo)): ?>
                                <img src="<?= base_url('assets/uploads/business/'.$b->logo) ?>" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fas fa-store fa-2x"></i>
                            <?php endif; ?>
                        </div>
                        <div class="overflow-hidden">
                            <h5 class="fw-bold mb-1 text-truncate"><?= $b->business_name ?></h5>
                            <?php if(isset($b->category_name)): ?>
                            <span class="badge bg-light text-primary fw-normal px-3 py-1 rounded-pill small border border-primary border-opacity-10"><?= $b->category_name ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <p class="text-muted small mb-4 line-clamp-3" style="min-height: 4.5em;"><?= character_limiter(strip_tags($b->description ?? ''), 120) ?></p>
                        
                        <div class="border-top pt-4 mt-auto">
                            <?php if(!empty($b->address)): ?>
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-map-marker-alt text-primary mt-1 me-3 small opacity-50"></i>
                                <p class="mb-0 small text-muted"><?= $b->address ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if(!empty($b->contact_phone)): ?>
                            <div class="d-flex align-items-start">
                                <i class="fas fa-phone-alt text-primary mt-1 me-3 small opacity-50"></i>
                                <p class="mb-0 small fw-bold text-secondary"><?= $b->contact_phone ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="fas fa-store-slash fa-4x text-muted mb-4"></i>
                    <h3 class="playfair">No Businesses Found</h3>
                    <p class="text-muted">We couldn't find any listings matching your search.</p>
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
.hover-lift {
    transition: all 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.pagination a, .pagination strong {
    border: none;
    padding: 8px 16px;
    margin: 0 4px;
    border-radius: 50px;
    color: var(--secondary-color);
    text-decoration: none;
    font-weight: 600;
}
.pagination strong {
    background: var(--primary-color);
    color: white;
}
.pagination a:hover {
    background: var(--light-bg);
    color: var(--primary-color);
}
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


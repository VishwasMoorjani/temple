<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Member Directory</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Our Community</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <!-- Search & Filter -->
        <div class="card mb-5 border-0 shadow-lg rounded-4 overflow-hidden" data-aos="fade-up">
            <div class="card-body p-4 p-md-5">
                <form action="<?= base_url('members') ?>" method="get" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Search Members</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 px-3"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none fs-6" placeholder="Name, City, or Gotra..." value="<?= isset($search_q) ? $search_q : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Member Type</label>
                        <select name="type" class="form-select form-select-lg bg-light border-0 rounded-4 shadow-none fs-6">
                            <option value="">All Members</option>
                            <option value="executive" <?= $this->input->get('type') == 'executive' ? 'selected' : '' ?>>Executive Committee</option>
                            <option value="life" <?= $this->input->get('type') == 'life' ? 'selected' : '' ?>>Life Members</option>
                            <option value="patron" <?= $this->input->get('type') == 'patron' ? 'selected' : '' ?>>Patrons</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-4 shadow-sm">
                            Find Now
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Members Grid -->
        <div class="row g-4">
            <?php if(!empty($members)): foreach($members as $key => $m): ?>
            <div class="col-sm-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?= ($key % 4) * 100 ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 hover-lift">
                    <div class="position-relative mb-4">
                        <?php 
                        $pic = isset($m->profile_pic) ? $m->profile_pic : (isset($m->photo) ? $m->photo : '');
                        $path = FCPATH.'assets/uploads/members/'.$pic;
                        if($pic && $pic != '9ead1773a7e4.png' && file_exists($path)): 
                        ?>
                            <img src="<?= base_url('assets/uploads/members/'.$pic) ?>" class="rounded-circle shadow-sm border border-4 border-white" width="120" height="120" style="object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto shadow-sm border border-4 border-white" style="width: 120px; height: 120px; font-size: 2.5rem; font-family: 'Outfit', sans-serif; font-weight: 700;">
                                <?= strtoupper(substr($m->first_name ?? '?', 0, 1) . substr($m->last_name ?? '', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body p-0">
                        <h5 class="fw-bold mb-1 text-truncate"><?= ($m->first_name ?? 'Member') . ' ' . ($m->last_name ?? '') ?></h5>
                        <p class="text-primary small fw-bold text-uppercase ls-wide mb-3 opacity-75"><?= $m->membership_type ?? 'Member' ?></p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <span class="badge bg-light text-muted fw-normal px-3 py-2 rounded-pill small">
                                <i class="fas fa-map-marker-alt me-1 text-primary"></i> <?= !empty($m->city) ? $m->city : 'Jaipur' ?>
                            </span>
                        </div>
                        
                        <a href="<?= base_url('member/'.$m->id) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 w-100">
                            View Profile
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm">
                    <i class="fas fa-users-slash fa-4x text-muted mb-4"></i>
                    <h3 class="playfair">No Members Found</h3>
                    <p class="text-muted">Try adjusting your search filters to find what you're looking for.</p>
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


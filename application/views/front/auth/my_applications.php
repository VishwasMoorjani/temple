<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('my-profile') ?>" class="text-white-50 text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">My Applications</li>
            </ol>
        </nav>
        <h1 class="display-5 text-white playfair mb-0" data-aos="fade-up">My Applications</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-md-3" data-aos="fade-right">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                    <div class="card-body p-0">
                        <a href="<?= base_url('my-profile') ?>" class="d-flex align-items-center p-4 text-decoration-none text-secondary border-bottom hover-bg-light">
                            <i class="fas fa-user-circle me-3 text-primary"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="<?= base_url('my-applications') ?>" class="d-flex align-items-center p-4 text-decoration-none border-bottom" style="background: var(--gold-gradient); color: white;">
                            <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                <i class="fas fa-file-alt" style="font-size: 0.8rem;"></i>
                            </div>
                            <span class="fw-bold">My Applications</span>
                            <?php if(isset($application_count) && $application_count > 0): ?>
                                <span class="badge bg-white bg-opacity-25 text-white rounded-pill ms-auto"><?= $application_count ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="<?= base_url('donation-history') ?>" class="d-flex align-items-center p-4 text-decoration-none text-secondary border-bottom hover-bg-light">
                            <i class="fas fa-donate me-3 text-primary"></i>
                            <span>Donation History</span>
                            <?php if(isset($donation_count) && $donation_count > 0): ?>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-auto"><?= $donation_count ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="<?= base_url('logout') ?>" class="d-flex align-items-center p-4 text-decoration-none text-danger hover-bg-light">
                            <i class="fas fa-sign-out-alt me-3"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-9" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 p-4 d-flex align-items-center justify-content-between">
                        <h5 class="playfair mb-0"><i class="fas fa-file-alt text-primary me-2"></i>Assistance Applications</h5>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('medical-assistance') ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-plus me-1"></i>New Application
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php if(!empty($applications)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small fw-bold text-uppercase text-muted border-0 rounded-start-3">#</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Type</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Amount</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Status</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0 rounded-end-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($applications as $i => $app): ?>
                                        <tr>
                                            <td class="text-muted"><?= $i + 1 ?></td>
                                            <td>
                                                <?php
                                                    $icons = ['Medical' => 'fa-heartbeat text-danger', 'Education' => 'fa-graduation-cap text-info', 'Pension' => 'fa-hand-holding-usd text-success'];
                                                    $icon = $icons[$app->type] ?? 'fa-file text-secondary';
                                                ?>
                                                <span class="d-flex align-items-center">
                                                    <i class="fas <?= $icon ?> me-2"></i>
                                                    <span class="fw-bold"><?= $app->type ?></span>
                                                </span>
                                            </td>
                                            <td class="fw-bold">
                                                <?= $app->amount_requested ? '₹' . number_format($app->amount_requested, 2) : '-' ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $status_map = [
                                                        'submitted'    => ['bg-info', 'Submitted'],
                                                        'under_review' => ['bg-warning', 'Under Review'],
                                                        'approved'     => ['bg-success', 'Approved'],
                                                        'rejected'     => ['bg-danger', 'Rejected'],
                                                        'disbursed'    => ['bg-primary', 'Disbursed'],
                                                    ];
                                                    $s = $status_map[$app->status] ?? ['bg-secondary', ucfirst($app->status)];
                                                ?>
                                                <span class="badge <?= $s[0] ?> bg-opacity-10 text-<?= str_replace('bg-', '', $s[0]) ?> rounded-pill px-3 py-1"><?= $s[1] ?></span>
                                            </td>
                                            <td class="text-muted small"><?= date('d M Y', strtotime($app->created_at)) ?></td>
                                        </tr>
                                        <?php if($app->status == 'rejected' && !empty($app->rejection_reason)): ?>
                                        <tr>
                                            <td colspan="5" class="border-0 pt-0 pb-3">
                                                <div class="alert alert-danger bg-danger bg-opacity-10 border-0 rounded-3 mb-0 py-2 px-3 small">
                                                    <i class="fas fa-info-circle me-1"></i><strong>Reason:</strong> <?= $app->rejection_reason ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-file-alt fa-4x text-muted opacity-25"></i>
                                </div>
                                <h5 class="playfair text-muted mb-2">No Applications Yet</h5>
                                <p class="text-muted mb-4">You haven't submitted any assistance applications.</p>
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                    <a href="<?= base_url('medical-assistance') ?>" class="btn btn-outline-danger rounded-pill px-4">
                                        <i class="fas fa-heartbeat me-2"></i>Medical
                                    </a>
                                    <a href="<?= base_url('education-assistance') ?>" class="btn btn-outline-info rounded-pill px-4">
                                        <i class="fas fa-graduation-cap me-2"></i>Education
                                    </a>
                                    <a href="<?= base_url('pension-assistance') ?>" class="btn btn-outline-success rounded-pill px-4">
                                        <i class="fas fa-hand-holding-usd me-2"></i>Pension
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-bg-light:hover { background-color: #f8f9fa; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

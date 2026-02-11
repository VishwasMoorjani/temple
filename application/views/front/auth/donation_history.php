<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('my-profile') ?>" class="text-white-50 text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Donation History</li>
            </ol>
        </nav>
        <h1 class="display-5 text-white playfair mb-0" data-aos="fade-up">Donation History</h1>
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
                        <a href="<?= base_url('my-applications') ?>" class="d-flex align-items-center p-4 text-decoration-none text-secondary border-bottom hover-bg-light">
                            <i class="fas fa-file-alt me-3 text-primary"></i>
                            <span>My Applications</span>
                            <?php if(isset($application_count) && $application_count > 0): ?>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-auto"><?= $application_count ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="<?= base_url('donation-history') ?>" class="d-flex align-items-center p-4 text-decoration-none border-bottom" style="background: var(--gold-gradient); color: white;">
                            <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                <i class="fas fa-donate" style="font-size: 0.8rem;"></i>
                            </div>
                            <span class="fw-bold">Donation History</span>
                            <?php if(isset($donation_count) && $donation_count > 0): ?>
                                <span class="badge bg-white bg-opacity-25 text-white rounded-pill ms-auto"><?= $donation_count ?></span>
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

                <!-- Stats Row -->
                <?php if(!empty($donations)): ?>
                <div class="row g-3 mb-4">
                    <?php
                        $total_amt = 0;
                        $success_count = 0;
                        foreach($donations as $d) {
                            if($d->payment_status == 'success') {
                                $total_amt += $d->amount;
                                $success_count++;
                            }
                        }
                    ?>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <h3 class="mb-1"><?= count($donations) ?></h3>
                                <p class="text-muted small mb-0">Total Donations</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h3 class="mb-1"><?= $success_count ?></h3>
                                <p class="text-muted small mb-0">Successful</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-rupee-sign"></i>
                                </div>
                                <h3 class="mb-1">₹<?= number_format($total_amt, 0) ?></h3>
                                <p class="text-muted small mb-0">Total Contributed</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 p-4 d-flex align-items-center justify-content-between">
                        <h5 class="playfair mb-0"><i class="fas fa-donate text-primary me-2"></i>All Donations</h5>
                        <a href="<?= base_url('donate') ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-plus me-1"></i>Make Donation
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <?php if(!empty($donations)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small fw-bold text-uppercase text-muted border-0 rounded-start-3">#</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Cause</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Amount</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Mode</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Status</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Receipt</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0 rounded-end-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($donations as $i => $don): ?>
                                        <tr>
                                            <td class="text-muted"><?= $i + 1 ?></td>
                                            <td class="fw-bold"><?= $don->cause_name ?? 'General' ?></td>
                                            <td class="fw-bold text-success">₹<?= number_format($don->amount, 2) ?></td>
                                            <td>
                                                <?php
                                                    $mode_icons = ['Online' => 'fa-globe', 'Cash' => 'fa-money-bill-wave', 'Cheque' => 'fa-money-check', 'UPI' => 'fa-mobile-alt'];
                                                    $m_icon = $mode_icons[$don->payment_mode] ?? 'fa-credit-card';
                                                ?>
                                                <span class="d-flex align-items-center small">
                                                    <i class="fas <?= $m_icon ?> text-muted me-2"></i><?= $don->payment_mode ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                    $ps_map = [
                                                        'pending' => ['warning', 'Pending'],
                                                        'success' => ['success', 'Success'],
                                                        'failed'  => ['danger', 'Failed'],
                                                    ];
                                                    $ps = $ps_map[$don->payment_status] ?? ['secondary', ucfirst($don->payment_status)];
                                                ?>
                                                <span class="badge bg-<?= $ps[0] ?> bg-opacity-10 text-<?= $ps[0] ?> rounded-pill px-3 py-1"><?= $ps[1] ?></span>
                                            </td>
                                            <td>
                                                <?php if($don->receipt_no): ?>
                                                    <span class="small fw-bold text-primary"><?= $don->receipt_no ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-muted small"><?= date('d M Y', strtotime($don->created_at)) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-donate fa-4x text-muted opacity-25"></i>
                                </div>
                                <h5 class="playfair text-muted mb-2">No Donations Yet</h5>
                                <p class="text-muted mb-4">You haven't made any donations. Your contribution can make a difference!</p>
                                <a href="<?= base_url('donate') ?>" class="btn btn-primary rounded-pill px-5">
                                    <i class="fas fa-heart me-2"></i>Make a Donation
                                </a>
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

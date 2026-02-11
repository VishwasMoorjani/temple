<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('members') ?>" class="text-white-50 text-decoration-none">Members</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Profile</li>
            </ol>
        </nav>
        <h1 class="display-5 text-white playfair mb-0" data-aos="fade-up"><?= $member->first_name . ' ' . $member->last_name ?></h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9" data-aos="fade-up">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="text-center p-5 position-relative" style="background: var(--gold-gradient);">
                        <?php 
                        if($member->profile_pic && $member->profile_pic != '9ead1773a7e4.png'): 
                        ?>
                            <img src="<?= base_url('assets/uploads/members/'.$member->profile_pic) ?>" class="rounded-circle border border-4 border-white mb-3 shadow-lg" width="140" height="140" style="object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center mx-auto mb-3 shadow-lg" style="width: 140px; height: 140px; font-size: 2.8rem; font-weight: 700;">
                                <?= strtoupper(substr($member->first_name ?? '?', 0, 1) . substr($member->last_name ?? '', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <h2 class="text-white playfair mb-2"><?= $member->first_name . ' ' . $member->last_name ?></h2>
                        <p class="text-white-50 mb-0"><i class="fas fa-map-marker-alt me-2"></i><?= $member->city ? $member->city : 'Unknown City' ?></p>
                    </div>

                    <!-- Profile Body -->
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-5">
                            <!-- Personal Details -->
                            <div class="col-md-6">
                                <h6 class="text-primary fw-bold text-uppercase ls-wide mb-4"><i class="fas fa-user me-2"></i>Personal Details</h6>
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                        <i class="fas fa-om text-primary me-3"></i>
                                        <div>
                                            <p class="text-muted small mb-0" style="font-size: 0.7rem;">GOTRA</p>
                                            <p class="mb-0 fw-bold"><?= $member->gotra ?? '-' ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                        <i class="fas fa-calendar-alt text-primary me-3"></i>
                                        <div>
                                            <p class="text-muted small mb-0" style="font-size: 0.7rem;">DATE OF BIRTH</p>
                                            <p class="mb-0 fw-bold"><?= $member->dob ? date('d M Y', strtotime($member->dob)) : '-' ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                        <i class="fas fa-heart text-primary me-3"></i>
                                        <div>
                                            <p class="text-muted small mb-0" style="font-size: 0.7rem;">MARITAL STATUS</p>
                                            <p class="mb-0 fw-bold"><?= $member->marital_status ?? '-' ?></p>
                                        </div>
                                    </div>
                                    <?php if(isset($member->spouse_name) && $member->spouse_name): ?>
                                    <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                        <i class="fas fa-users text-primary me-3"></i>
                                        <div>
                                            <p class="text-muted small mb-0" style="font-size: 0.7rem;">SPOUSE</p>
                                            <p class="mb-0 fw-bold"><?= $member->spouse_name ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary fw-bold text-uppercase ls-wide mb-4"><i class="fas fa-address-book me-2"></i>Contact Information</h6>
                                <?php if($can_view_contact): ?>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                            <i class="fas fa-phone-alt text-primary me-3"></i>
                                            <div>
                                                <p class="text-muted small mb-0" style="font-size: 0.7rem;">PHONE</p>
                                                <p class="mb-0 fw-bold"><?= $member->phone ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                            <i class="fas fa-envelope text-primary me-3"></i>
                                            <div>
                                                <p class="text-muted small mb-0" style="font-size: 0.7rem;">EMAIL</p>
                                                <p class="mb-0 fw-bold"><?= $member->email ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                            <div>
                                                <p class="text-muted small mb-0" style="font-size: 0.7rem;">ADDRESS</p>
                                                <p class="mb-0 fw-bold"><?= $member->address ?? '-' ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert border-0 bg-warning bg-opacity-10 text-warning rounded-4 p-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-lock fa-2x me-3"></i>
                                            <div>
                                                <p class="fw-bold mb-1">Contact details are private</p>
                                                <p class="small mb-0">Visible only to logged-in members. <a href="<?= base_url('login') ?>" class="text-primary fw-bold">Login now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Family Members -->
                        <?php if(!empty($member->family)): ?>
                        <div class="mt-5 pt-5 border-top">
                            <h6 class="text-primary fw-bold text-uppercase ls-wide mb-4"><i class="fas fa-users me-2"></i>Family Members</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Name</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Relation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($member->family as $f): ?>
                                        <tr>
                                            <td class="fw-bold"><?= $f->name ?></td>
                                            <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3"><?= $f->relation ?></span></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-5 pt-4 border-top">
                            <a href="<?= base_url('members') ?>" class="btn btn-outline-secondary rounded-pill px-5">
                                <i class="fas fa-arrow-left me-2"></i>Back to Directory
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

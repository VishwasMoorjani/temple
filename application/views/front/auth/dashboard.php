<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">My Dashboard</li>
            </ol>
        </nav>
        <h1 class="display-5 text-white playfair mb-0" data-aos="fade-up">Welcome, <?= $member->first_name ?>!</h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center" data-aos="fade-down">
                <i class="fas fa-check-circle me-3 fs-5"></i>
                <span><?= $this->session->flashdata('success') ?></span>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center" data-aos="fade-down">
                <i class="fas fa-exclamation-circle me-3 fs-5"></i>
                <span><?= $this->session->flashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-md-3" data-aos="fade-right">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                    <div class="card-body p-0">
                        <a href="<?= base_url('my-profile') ?>" class="d-flex align-items-center p-4 text-decoration-none border-bottom" style="background: var(--gold-gradient); color: white;">
                            <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <span class="fw-bold">My Profile</span>
                        </a>
                        <a href="<?= base_url('my-applications') ?>" class="d-flex align-items-center p-4 text-decoration-none text-secondary border-bottom hover-bg-light">
                            <i class="fas fa-file-alt me-3 text-primary"></i>
                            <span>My Applications</span>
                            <?php if(isset($application_count) && $application_count > 0): ?>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-auto"><?= $application_count ?></span>
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
                <!-- Profile Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="text-primary fw-bold text-uppercase ls-wide mb-0">Profile Summary</h6>
                            <a href="<?= base_url('edit-profile') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="fas fa-edit me-1"></i>Edit Profile
                            </a>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-0 fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.1em;">Membership ID</p>
                                        <p class="mb-0 fw-bold"><?= $member->membership_no ?? 'Pending Approval' ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-0 fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.1em;">Email</p>
                                        <p class="mb-0 fw-bold"><?= $member->email ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-0 fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.1em;">Phone</p>
                                        <p class="mb-0 fw-bold"><?= $member->phone ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted small mb-0 fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.1em;">Status</p>
                                        <?php if($member->status == 1): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Active Member</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Pending / Inactive</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Card -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 p-4">
                        <h5 class="playfair mb-0"><i class="fas fa-users text-primary me-2"></i>Family Members</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if(!empty($member->family)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small fw-bold text-uppercase text-muted border-0 rounded-start-3">Name</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0">Relation</th>
                                            <th class="small fw-bold text-uppercase text-muted border-0 rounded-end-3">Date of Birth</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($member->family as $f): ?>
                                        <tr>
                                            <td class="fw-bold"><?= $f->name ?></td>
                                            <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3"><?= $f->relation ?></span></td>
                                            <td class="text-muted"><?= $f->dob ? date('d M Y', strtotime($f->dob)) : '-' ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#requestUpdateModal" onclick="document.getElementById('update_type').value='family'">
                                    <i class="fas fa-edit me-2"></i>Request Family Update
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3 opacity-25"></i>
                                <p class="text-muted mb-3">No family members listed yet.</p>
                                <button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#requestUpdateModal" onclick="document.getElementById('update_type').value='family'">
                                    <i class="fas fa-edit me-2"></i>Request Update
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Request Update Modal -->
<div class="modal fade" id="requestUpdateModal" tabindex="-1" aria-labelledby="requestUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">
            <div class="modal-header border-0 p-4" style="background: var(--gold-gradient);">
                <h5 class="modal-title text-white playfair" id="requestUpdateModalLabel">
                    <i class="fas fa-edit me-2"></i>Request Profile Update
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('request-update') ?>
                <div class="modal-body p-4 p-md-5">
                    <p class="text-muted small mb-4">
                        Describe the changes you'd like made to your profile. Our admin team will review and update your details.
                    </p>
                    <input type="hidden" name="update_type" id="update_type" value="general">
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase ls-wide text-muted">What do you want to update?</label>
                        <select name="update_type_display" class="form-select bg-light border-0 rounded-4 shadow-none" onchange="document.getElementById('update_type').value=this.value">
                            <option value="general">General Profile Info</option>
                            <option value="family">Family Members</option>
                            <option value="contact">Contact Details</option>
                            <option value="address">Address</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Describe the changes</label>
                        <textarea name="message" class="form-control bg-light border-0 rounded-4 shadow-none" rows="5" required placeholder="E.g., Please add my daughter Priya (DOB: 15 Jan 2010) to my family members..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-paper-plane me-2"></i>Submit Request
                    </button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<style>
.hover-bg-light:hover { background-color: #f8f9fa; }
</style>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

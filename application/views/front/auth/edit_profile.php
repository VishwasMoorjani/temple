<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('my-profile') ?>" class="text-white-50 text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Edit Profile</li>
            </ol>
        </nav>
        <h1 class="display-5 text-white playfair mb-0" data-aos="fade-up">Edit Profile</h1>
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
                        <a href="<?= base_url('my-profile') ?>" class="d-flex align-items-center p-4 text-decoration-none text-secondary border-bottom hover-bg-light">
                            <i class="fas fa-user-circle me-3 text-primary"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="<?= base_url('edit-profile') ?>" class="d-flex align-items-center p-4 text-decoration-none border-bottom" style="background: var(--gold-gradient); color: white;">
                            <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                            </div>
                            <span class="fw-bold">Edit Profile</span>
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
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 p-4">
                        <h5 class="playfair mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Update Your Details</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        
                        <?= form_open_multipart('edit-profile') ?>
                            <div class="row g-4">
                                <!-- Profile Picture Upload -->
                                <div class="col-12 text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <?php if($member->profile_pic && $member->profile_pic != '9ead1773a7e4.png'): ?>
                                            <img src="<?= base_url('assets/uploads/members/'.$member->profile_pic) ?>" class="rounded-circle shadow-lg border border-4 border-white" width="120" height="120" style="object-fit: cover;" id="profilePreview">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto shadow-lg border border-4 border-white" style="width: 120px; height: 120px;" id="profilePlaceholder">
                                                <i class="fas fa-user fa-3x text-secondary opacity-50"></i>
                                            </div>
                                            <img src="" class="rounded-circle shadow-lg border border-4 border-white d-none" width="120" height="120" style="object-fit: cover;" id="profilePreviewImg">
                                        <?php endif; ?>
                                        <label for="profile_pic" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm cursor-pointer hover-scale" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-camera small"></i>
                                        </label>
                                        <input type="file" name="profile_pic" id="profile_pic" class="d-none" accept="image/*" onchange="previewImage(this)">
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">Tap icon to change photo</p>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">First Name</label>
                                    <input type="text" name="first_name" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" required value="<?= set_value('first_name', $member->first_name) ?>">
                                    <?= form_error('first_name', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Last Name</label>
                                    <input type="text" name="last_name" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" required value="<?= set_value('last_name', $member->last_name) ?>">
                                    <?= form_error('last_name', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Phone Number</label>
                                    <input type="text" name="phone" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" required value="<?= set_value('phone', $member->phone) ?>">
                                    <?= form_error('phone', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" value="<?= set_value('dob', $member->dob) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Gotra</label>
                                    <input type="text" name="gotra" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" value="<?= set_value('gotra', $member->gotra) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Marital Status</label>
                                    <select name="marital_status" class="form-select form-select-lg bg-light border-0 rounded-4 shadow-none">
                                        <option value="Single" <?= set_select('marital_status', 'Single', ($member->marital_status == 'Single')) ?>>Single</option>
                                        <option value="Married" <?= set_select('marital_status', 'Married', ($member->marital_status == 'Married')) ?>>Married</option>
                                        <option value="Widowed" <?= set_select('marital_status', 'Widowed', ($member->marital_status == 'Widowed')) ?>>Widowed</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Spouse Name (if married)</label>
                                    <input type="text" name="spouse_name" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" value="<?= set_value('spouse_name', $member->spouse_name) ?>">
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Address</label>
                                    <textarea name="address" class="form-control bg-light border-0 rounded-4 shadow-none" rows="2"><?= set_value('address', $member->address) ?></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">City</label>
                                    <input type="text" name="city" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" value="<?= set_value('city', $member->city) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Pincode</label>
                                    <input type="text" name="pincode" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" value="<?= set_value('pincode', $member->pincode) ?>">
                                </div>

                                <div class="col-12 pt-3">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 shadow-sm">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                    <a href="<?= base_url('my-profile') ?>" class="btn btn-light rounded-pill px-5 py-3 ms-2">Cancel</a>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-bg-light:hover { background-color: #f8f9fa; }
.cursor-pointer { cursor: pointer; }
.hover-scale { transition: transform 0.2s; }
.hover-scale:hover { transform: scale(1.1); }
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var placeholder = document.getElementById('profilePlaceholder');
            var img = document.getElementById('profilePreview');
            var imgNew = document.getElementById('profilePreviewImg');

            if(placeholder) placeholder.classList.add('d-none');
            
            if(img) {
                img.src = e.target.result;
            } else if(imgNew) {
                imgNew.src = e.target.result;
                imgNew.classList.remove('d-none');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

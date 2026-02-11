<?php ob_start(); ?>

<div class="bg-light min-vh-100 d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6" data-aos="fade-up">
                <div class="text-center mb-5">
                    <a href="<?= base_url() ?>" class="text-decoration-none">
                        <i class="fas fa-om text-primary fs-1 mb-3 d-block"></i>
                        <h4 class="playfair text-dark">Rajasthan Jain Sabha</h4>
                    </a>
                </div>

                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="playfair text-center mb-4">Create Your Account</h4>
                        <p class="text-muted text-center small mb-4">Join our community of over 10,000 members</p>

                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger border-0 rounded-4 small"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>

                        <?= form_open('memberauth/register') ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">First Name</label>
                                    <input type="text" name="first_name" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" required value="<?= set_value('first_name') ?>" placeholder="First Name">
                                    <?= form_error('first_name', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Last Name</label>
                                    <input type="text" name="last_name" class="form-control form-control-lg bg-light border-0 rounded-4 shadow-none" required value="<?= set_value('last_name') ?>" placeholder="Last Name">
                                    <?= form_error('last_name', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 rounded-start-4"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" name="email" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none" required value="<?= set_value('email') ?>" placeholder="your@email.com">
                                    </div>
                                    <?= form_error('email', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 rounded-start-4"><i class="fas fa-phone text-muted"></i></span>
                                        <input type="text" name="phone" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none" required value="<?= set_value('phone') ?>" placeholder="+91 000 000 0000">
                                    </div>
                                    <?= form_error('phone', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 rounded-start-4"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="password" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none" required placeholder="••••••••">
                                    </div>
                                    <?= form_error('password', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 rounded-start-4"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="confirm_password" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none" required placeholder="••••••••">
                                    </div>
                                    <?= form_error('confirm_password', '<div class="text-danger small mt-1">', '</div>') ?>
                                </div>

                                <div class="col-12 pt-2">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 shadow-sm">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>
                                </div>
                            </div>
                        <?= form_close() ?>
                        
                        <div class="text-center pt-4 border-top mt-4">
                            <p class="text-muted small mb-0">Already a member? <a href="<?= base_url('login') ?>" class="text-primary fw-bold text-decoration-none">Login Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

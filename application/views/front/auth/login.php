<?php ob_start(); ?>

<div class="bg-light min-vh-100 d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4" data-aos="fade-up">
                <div class="text-center mb-5">
                    <a href="<?= base_url() ?>" class="text-decoration-none">
                        <i class="fas fa-om text-primary fs-1 mb-3 d-block"></i>
                        <h4 class="playfair text-dark">Rajasthan Jain Sabha</h4>
                    </a>
                </div>

                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="playfair text-center mb-4">Welcome Back</h4>
                        <p class="text-muted text-center small mb-4">Sign in to access your member dashboard</p>

                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger border-0 rounded-4 small"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success border-0 rounded-4 small"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>

                        <?= form_open('memberauth/login') ?>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none" required value="<?= set_value('email') ?>" placeholder="your@email.com">
                                </div>
                                <?= form_error('email', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase ls-wide text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control form-control-lg bg-light border-0 rounded-end-4 shadow-none" required placeholder="••••••••">
                                </div>
                                <?= form_error('password', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 shadow-sm mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        <?= form_close() ?>
                        
                        <div class="text-center pt-4 border-top mt-4">
                            <p class="text-muted small mb-0">New to our community? <a href="<?= base_url('register') ?>" class="text-primary fw-bold text-decoration-none">Register Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

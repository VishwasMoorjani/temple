<?php ob_start(); ?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Privacy Policy</li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up">Privacy Policy</h1>
    </div>
</section>

<div class="bg-white py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="mb-5" data-aos="fade-up">
                    <p class="text-primary fw-bold text-uppercase ls-wide small mb-2">Legal Information</p>
                    <p class="text-muted">Last Updated: <?= date('F d, Y') ?></p>
                </div>

                <div class="content text-secondary lh-lg" data-aos="fade-up">
                    <div class="mb-5">
                        <h4 class="playfair text-dark mb-3">1. Information We Collect</h4>
                        <p>We collect personal information that you voluntarily provide when registering as a member, making donations, or contacting us. This may include your name, email, phone number, address, date of birth, and family details. This information is essential for us to provide personalized community services and maintain accurate records.</p>
                    </div>

                    <div class="mb-5">
                        <h4 class="playfair text-dark mb-3">2. How We Use Your Information</h4>
                        <p>Your information is used for specific, transparent purposes aimed at serving you and the community:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> To manage your membership and provide tailored community services.</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> To process donations securely and issue official receipts.</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> To communicate about upcoming events, spiritual programs, and news.</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> To maintain the member directory with robust privacy controls.</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> To process assistance and welfare applications for those in need.</li>
                        </ul>
                    </div>

                    <div class="mb-5">
                        <h4 class="playfair text-dark mb-3">3. Data Protection</h4>
                        <p>We implement industry-standard security measures to protect your personal data against unauthorized access, alteration, or disclosure. Contact information in the member directory is only visible to verified, logged-in members of the Rajasthan Jain Sabha.</p>
                    </div>

                    <div class="mb-5">
                        <h4 class="playfair text-dark mb-3">4. Information Sharing</h4>
                        <p>We honor your privacy. We do not sell, trade, or share your personal information with third parties for marketing purposes. Data sharing only occurs when required by law or with your explicit, written consent.</p>
                    </div>

                    <div class="mb-5">
                        <h4 class="playfair text-dark mb-3">5. Your Rights</h4>
                        <p>You have the full right to access, correct, or request the deletion of your personal information at any time. This can be done easily through your member dashboard or by contacting our support team directly.</p>
                    </div>

                    <div class="p-4 bg-light rounded-4 border-start border-4 border-primary">
                        <h4 class="playfair text-dark mb-3">6. Contact Us</h4>
                        <p class="mb-0">For any privacy-related inquiries or to exercise your rights, please reach out to us:</p>
                        <div class="mt-3">
                            <p class="mb-1"><i class="fas fa-envelope text-primary me-2"></i> <strong>info@rajasthanjainsabha.in</strong></p>
                            <p class="mb-0"><i class="fas fa-phone text-primary me-2"></i> <strong>+91 141 1234567</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>


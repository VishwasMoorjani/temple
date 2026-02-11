<?php ob_start(); ?>

<?php
$config = [
    'medical' => [
        'icon' => 'fas fa-heartbeat',
        'color' => 'danger',
        'desc' => 'The Sabha provides financial assistance for medical treatments including surgeries, chronic illnesses, and emergency healthcare needs.',
        'eligibility' => [
            'Must be a registered member of the community',
            'Annual family income below ₹3,00,000',
            'Treatment from an empaneled or government hospital',
            'Application must be submitted within 30 days of treatment'
        ],
        'documents' => [
            'Medical reports and doctor\'s prescription',
            'Hospital bills / treatment estimate',
            'Income certificate or salary slip',
            'Aadhaar card and membership ID',
            'Bank passbook (first page copy)'
        ]
    ],
    'education' => [
        'icon' => 'fas fa-graduation-cap',
        'color' => 'warning',
        'desc' => 'Scholarships and financial support for students pursuing higher education, professional courses, and skill development programs.',
        'eligibility' => [
            'Student must be from the Jain community',
            'Minimum 60% marks in last qualifying exam',
            'Annual family income below ₹5,00,000',
            'Enrolled in a recognized institution',
            'Not receiving any other major scholarship'
        ],
        'documents' => [
            'Mark sheets of last two years',
            'Admission letter / Fee receipt',
            'Income certificate of parent/guardian',
            'Aadhaar card of student and guardian',
            'Community certificate',
            'Bank passbook (student\'s account)'
        ]
    ],
    'pension' => [
        'icon' => 'fas fa-hand-holding-usd',
        'color' => 'success',
        'desc' => 'Monthly pension and financial assistance for senior citizens, widows, and economically weaker members of the community.',
        'eligibility' => [
            'Must be above 60 years of age (or widow of any age)',
            'Must be a registered community member for 5+ years',
            'No regular source of income or pension',
            'Annual income below ₹1,50,000',
            'Not receiving government pension'
        ],
        'documents' => [
            'Age proof (Aadhaar/Voter ID)',
            'Membership ID card',
            'Income certificate / BPL card',
            'Bank passbook',
            'Passport-size photograph',
            'Death certificate of spouse (for widow pension)'
        ]
    ]
];
$c = $config[$type];
?>

<!-- Page Header -->
<section class="py-5 position-relative" style="background: var(--secondary-color);">
    <div class="container py-4 position-relative z-3">
        <nav aria-label="breadcrumb" data-aos="fade-down">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white-50">Services</li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $page_title ?></li>
            </ol>
        </nav>
        <h1 class="display-4 text-white playfair mb-0" data-aos="fade-up"><?= $page_title ?></h1>
    </div>
</section>

<div class="bg-light py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Hero Card -->
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden mb-5" data-aos="fade-up">
                    <div class="card-body p-5 text-center">
                        <div class="feature-icon mx-auto mb-4 bg-<?= $c['color'] ?> bg-opacity-10 text-<?= $c['color'] ?> rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; font-size: 2.5rem;">
                            <i class="<?= $c['icon'] ?>"></i>
                        </div>
                        <h2 class="playfair display-6 mb-3"><?= $page_title ?></h2>
                        <p class="lead text-muted col-lg-8 mx-auto"><?= $c['desc'] ?></p>
                    </div>
                </div>

                <!-- Eligibility & Documents -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                            <div class="card-header bg-<?= $c['color'] ?> bg-opacity-10 border-0 p-4">
                                <h5 class="mb-0 text-<?= $c['color'] ?>"><i class="fas fa-check-circle me-2"></i>Eligibility Criteria</h5>
                            </div>
                            <div class="card-body p-4">
                                <ul class="list-unstyled mb-0">
                                    <?php foreach($c['eligibility'] as $item): ?>
                                    <li class="d-flex align-items-start mb-3">
                                        <i class="fas fa-check-circle text-success mt-1 me-3 flex-shrink-0"></i>
                                        <span class="text-secondary"><?= $item ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                            <div class="card-header bg-secondary bg-opacity-10 border-0 p-4">
                                <h5 class="mb-0 text-secondary"><i class="fas fa-file-alt me-2"></i>Required Documents</h5>
                            </div>
                            <div class="card-body p-4">
                                <ul class="list-unstyled mb-0">
                                    <?php foreach($c['documents'] as $doc): ?>
                                    <li class="d-flex align-items-start mb-3">
                                        <i class="far fa-file-alt text-primary mt-1 me-3 flex-shrink-0"></i>
                                        <span class="text-secondary"><?= $doc ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Apply CTA -->
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden" data-aos="fade-up">
                    <div class="card-body text-center p-5">
                        <h6 class="text-primary fw-bold text-uppercase ls-wide mb-2">Get Started</h6>
                        <h3 class="playfair mb-3">How to Apply</h3>
                        <p class="text-muted col-lg-8 mx-auto mb-4">Gather all required documents and submit your application online. Our team will review and respond within <strong>15 working days</strong>.</p>
                        <?php if($is_logged_in): ?>
                            <a href="#" class="btn btn-lg btn-<?= $c['color'] ?> rounded-pill px-5 py-3 shadow-lg">
                                <i class="fas fa-paper-plane me-2"></i> Submit Application
                            </a>
                        <?php else: ?>
                            <div class="alert border-0 bg-warning bg-opacity-10 text-warning d-inline-block rounded-4 px-4 py-3 mb-4">
                                <i class="fas fa-lock me-2"></i> You must be a <strong>registered member</strong> and logged in to apply.
                            </div><br>
                            <div class="d-flex gap-3 justify-content-center mt-3">
                                <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">Login to Apply</a>
                                <a href="<?= base_url('register') ?>" class="btn btn-outline-primary btn-lg rounded-pill px-5">Register First</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php include(APPPATH . 'views/front/layout.php'); ?>

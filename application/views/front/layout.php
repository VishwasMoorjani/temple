<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' | ' : '' ?>Rajasthan Jain Sabha</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #d35400;
            --secondary-color: #2c3e50;
            --accent-color: #f39c12;
            --light-bg: #fdfdfd;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --premium-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --gold-gradient: linear-gradient(135deg, #d35400 0%, #f39c12 100%);
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--light-bg); 
            color: #333;
            overflow-x: hidden;
        }

        h1, h2, h3, .navbar-brand { 
            font-family: 'Outfit', sans-serif; 
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .playfair { font-family: 'Playfair Display', serif; }

        /* Glassmorphism Header */
        .main-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .main-header.scrolled {
            box-shadow: var(--premium-shadow);
            background: rgba(255, 255, 255, 0.98);
        }

        .navbar {
            padding: 0;
        }

        .nav-link {
            font-weight: 500;
            color: var(--secondary-color) !important;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-brand {
            font-size: 1.5rem;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Buttons */
        .btn-primary {
            background: var(--gold-gradient);
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(211, 84, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(211, 84, 0, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 50px;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Premium Cards */
        .card {
            border: none;
            border-radius: 20px;
            background: #fff;
            box-shadow: var(--premium-shadow);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(211, 84, 0, 0.1);
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .card:hover .feature-icon {
            background: var(--primary-color);
            color: white;
            transform: rotateY(180deg);
        }

        /* Hero Styling */
        .hero-section {
            position: relative;
            background-attachment: fixed;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.3));
        }

        /* Footer Styling */
        .footer {
            background: var(--secondary-color);
            color: #ecf0f1;
            padding: 80px 0 30px;
            border-top: 5px solid var(--accent-color);
        }

        .footer h5 {
            color: #fff;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .footer p { color: #bdc3c7; }

        .footer-link {
            transition: all 0.3s ease;
            color: #bdc3c7;
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
        }

        .footer-link:hover {
            color: var(--accent-color);
            padding-left: 8px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 5px; }

        /* Utilities */
        .ls-wide { letter-spacing: 0.1em; }
        .backdrop-blur { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .bg-accent { background-color: var(--accent-color); }
        .text-accent { color: var(--accent-color); }
        
        .hover-zoom {
            transition: transform 0.5s ease;
        }
        .card:hover .hover-zoom {
            transform: scale(1.1);
        }

        .z-3 { z-index: 3; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <!-- Header -->
    <header class="sticky-top main-header">
        <!-- Top Bar -->
        <div class="header-top py-2 d-none d-lg-block border-bottom border-light">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <a class="navbar-brand m-0" href="<?= base_url() ?>">
                        <!-- <i class="fas fa-om me-2"></i>RAJASTHAN JAIN SABHA -->
                        <img src="<?= base_url('assets/front/images/logo.png') ?>" style="width: 100px;" alt="Logo" class="img-fluid"> &nbsp; Rajasthan Jain Sabha
                    </a>
                    
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex gap-2">
                             <?php if($this->session->userdata('isMemberLoggedIn')): ?>
                                <a href="<?= base_url('my-profile') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="fas fa-user-circle me-1"></i> My Profile
                                </a>
                                <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-danger rounded-pill px-3">Logout</a>
                            <?php else: ?>
                                <a href="<?= base_url('login') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Login</a>
                                <a href="<?= base_url('register') ?>" class="btn btn-sm btn-primary rounded-pill px-3 text-white">Join Community</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar (Navigation) -->
        <div class="header-bottom">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand d-lg-none" href="<?= base_url() ?>">
                        <img src="<?= base_url('assets/front/images/logo.png') ?>" style="width: 100px;" alt="Logo" class="img-fluid"> &nbsp;Rajasthan Jain Sabha
                    </a>

                    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('about-us') ?>">About Us</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('members') ?>">Members</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('business') ?>">Business</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">Services</a>
                                <ul class="dropdown-menu border-0 shadow-lg p-3 rounded-4">
                                    <li><a class="dropdown-item rounded-3" href="<?= base_url('donate') ?>">Donate</a></li>
                                    <li><a class="dropdown-item rounded-3" href="<?= base_url('medical-assistance') ?>">Medical Assistance</a></li>
                                    <li><a class="dropdown-item rounded-3" href="<?= base_url('education-assistance') ?>">Education Fund</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown">Information</a>
                                <ul class="dropdown-menu border-0 shadow-lg p-3 rounded-4">
                                    <li><a class="dropdown-item rounded-3" href="<?= base_url('information/temples') ?>">Temples</a></li>
                                    <li><a class="dropdown-item rounded-3" href="<?= base_url('information/maharaj') ?>">Maharaj & Mataji</a></li>
                                    <li><a class="dropdown-item rounded-3" href="<?= base_url('information/dharmshalas') ?>">Dharmshalas</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('contact-us') ?>">Contact</a></li>
                        </ul>
                        
                        <div class="d-lg-none mt-3 pb-3 border-top pt-3">
                             <?php if($this->session->userdata('isMemberLoggedIn')): ?>
                                <a href="<?= base_url('my-profile') ?>" class="btn btn-outline-primary w-100 mb-2">My Profile</a>
                                <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Logout</a>
                            <?php else: ?>
                                <a href="<?= base_url('login') ?>" class="btn btn-outline-primary w-100 mb-2">Login</a>
                                <a href="<?= base_url('register') ?>" class="btn btn-primary w-100">Join Community</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="navbar-brand text-white mb-4">RAJASTHAN JAIN SABHA</h5>
                    <p class="mb-4">A premier organization dedicated to the service of the community since 1953. Preserving our values, serving humanity.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('about-us') ?>" class="footer-link">About Us</a></li>
                        <li><a href="<?= base_url('members') ?>" class="footer-link">Member Directory</a></li>
                        <li><a href="<?= base_url('business') ?>" class="footer-link">Business Hub</a></li>
                        <li><a href="<?= base_url('donate') ?>" class="footer-link">Contribution</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('contact-us') ?>" class="footer-link">Help Center</a></li>
                        <li><a href="<?= base_url('privacy-policy') ?>" class="footer-link">Privacy Policy</a></li>
                        <li><a href="<?= base_url('terms') ?>" class="footer-link">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Newsletter</h5>
                    <p class="small">Subscribe to get the latest community updates.</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control bg-transparent border-secondary text-white" placeholder="Email Address">
                        <button class="btn btn-primary" type="button">Join</button>
                    </div>
                </div>
            </div>
            <hr class="mt-5 opacity-10">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 small">&copy; <?= date('Y') ?> Rajasthan Jain Sabha. Handcrafted with devotion.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <img src="https://img.icons8.com/color/48/000000/visa.png" height="25" class="me-2" alt="Visa">
                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" height="25" class="me-2" alt="Mastercard">
                    <img src="https://img.icons8.com/color/48/000000/upi.png" height="25" alt="UPI">
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS Animation
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Navbar Scroll Effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.main-header').addClass('scrolled');
            } else {
                $('.main-header').removeClass('scrolled');
            }
        });
    </script>
</body>
</html>

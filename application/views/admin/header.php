</head>

<body class="g-sidenav-show  bg-gray-200">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="<?= base_url(); ?>" target="_blank">
                <img style="height: 100%" src="<?= base_url('assets/front/images/dazzle-logo.jpg'); ?>"  alt="" srcset="">&nbsp; 
                <!-- <span style="color:#fff"><?=sitename?></span> -->
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('admin/dashboard'); ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-tachometer "></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li> 

                <?php
                $modules = $this->db->order_by('id', 'ASC')->get('modules')->result();
                if (!empty($modules)):
                ?>
                <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Dynamic Modules</h6>
                </li>

                <?php foreach ($modules as $m): ?>
                <li class="nav-item">
                <a class="nav-link text-white" href="<?= base_url('admin/module/'.$m->hash); ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-cube"></i>
                    </div>
                    <span class="nav-link-text ms-1"><?= ucfirst($m->name); ?></span>
                </a>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>                            

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Community</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('admin/community/members'); ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="nav-link-text ms-1">Members</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('admin/community/categories'); ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <span class="nav-link-text ms-1">Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= base_url('admin/community/posts'); ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-comments"></i>
                        </div>
                        <span class="nav-link-text ms-1">Posts</span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Settings</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " href="<?= base_url('admin/globalsettings'); ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky noPrint" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <!-- <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                    </ol> -->
                    <img src="<?= base_url('assets/front/images/dazzle-logo.jpg'); ?>" style="height:3rem" alt="" srcset="">
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar" style="justify-content: end;">
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="<?=site_url('auth/logout') ?>" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Logout</span>
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <!-- <li class="nav-item px-3 d-flex align-items-center">
                            <a href="<?=site_url('admin/globalsettings') ?>" class="nav-link text-body p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li> -->
                        <!--<li class="nav-item dropdown pe-2 d-flex align-items-center">-->
                        <!--    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">-->
                        <!--        <i class="fa fa-bell cursor-pointer"></i>-->
                        <!--    </a>-->
                        <!--    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">-->
                        <!--        <li class="mb-2">-->
                        <!--            <a class="dropdown-item border-radius-md" href="javascript:;">-->
                        <!--                <div class="d-flex py-1">-->
                        <!--                    <div class="my-auto">-->
                        <!--                        <img src="<?=base_url('assets/admin/img/team-2.jpg'); ?>" class="avatar avatar-sm  me-3 ">-->
                        <!--                    </div>-->
                        <!--                    <div class="d-flex flex-column justify-content-center">-->
                        <!--                        <h6 class="text-sm font-weight-normal mb-1">-->
                        <!--                            <span class="font-weight-bold">New message</span> from Laur-->
                        <!--                        </h6>-->
                        <!--                        <p class="text-xs text-secondary mb-0">-->
                        <!--                            <i class="fa fa-clock me-1"></i>-->
                        <!--                            13 minutes ago-->
                        <!--                        </p>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--            </a>-->
                        <!--        </li>-->
                        <!--        <li class="mb-2">-->
                        <!--            <a class="dropdown-item border-radius-md" href="javascript:;">-->
                        <!--                <div class="d-flex py-1">-->
                        <!--                    <div class="my-auto">-->
                        <!--                        <img src="<?=base_url('assets/admin/img/small-logos/logo-spotify.svg'); ?>" class="avatar avatar-sm bg-gradient-dark  me-3 ">-->
                        <!--                    </div>-->
                        <!--                    <div class="d-flex flex-column justify-content-center">-->
                        <!--                        <h6 class="text-sm font-weight-normal mb-1">-->
                        <!--                            <span class="font-weight-bold">New album</span> by Travis Scott-->
                        <!--                        </h6>-->
                        <!--                        <p class="text-xs text-secondary mb-0">-->
                        <!--                            <i class="fa fa-clock me-1"></i>-->
                        <!--                            1 day-->
                        <!--                        </p>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--            </a>-->
                        <!--        </li>-->
                        <!--        <li>-->
                        <!--            <a class="dropdown-item border-radius-md" href="javascript:;">-->
                        <!--                <div class="d-flex py-1">-->
                        <!--                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">-->
                        <!--                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">-->
                        <!--                            <title>credit-card</title>-->
                        <!--                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
                        <!--                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">-->
                        <!--                                    <g transform="translate(1716.000000, 291.000000)">-->
                        <!--                                        <g transform="translate(453.000000, 454.000000)">-->
                        <!--                                            <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>-->
                        <!--                                            <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>-->
                        <!--                                        </g>-->
                        <!--                                    </g>-->
                        <!--                                </g>-->
                        <!--                            </g>-->
                        <!--                        </svg>-->
                        <!--                    </div>-->
                        <!--                    <div class="d-flex flex-column justify-content-center">-->
                        <!--                        <h6 class="text-sm font-weight-normal mb-1">-->
                        <!--                            Payment successfully completed-->
                        <!--                        </h6>-->
                        <!--                        <p class="text-xs text-secondary mb-0">-->
                        <!--                            <i class="fa fa-clock me-1"></i>-->
                        <!--                            2 days-->
                        <!--                        </p>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--            </a>-->
                        <!--        </li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
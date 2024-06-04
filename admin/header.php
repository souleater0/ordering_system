<?php
//require 'admin/session_restrict.php';
$route = $_GET['route'] ?? 'home';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EC - Inventory System</title>
    <link rel="shortcut icon" type="../image/png" href="../assets/images/logos/eclogo.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!-- <link rel="stylesheet" href="../assets/css/table.css"> -->
    <style>
        .nav-small-cap {
            cursor: pointer;
        }
    </style>
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <!-- <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script> -->
    <!-- <script src="../assets/js/dashboard.js"></script> -->
    <!-- fontawesome-->
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <script src="../assets/js/all.min.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <!-- DATATABLE -->
    <link href="../assets/libs/datatablejs/css/datatables.min.css" rel="stylesheet">
    <script src="../assets/libs/datatablejs/js/datatables.min.js"></script>
    <!-- bootstrap select -->
    <!-- Latest BS-Select compiled and minified CSS/JS -->
    <!-- <link rel="stylesheet" href="../assets/libs/bootstrap-select/dist/css/bootstrap-select.min.css">
    <script src="../assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js"></script> -->

    <!-- TOASTR -->
    <link rel="stylesheet" href="../assets/libs/toastr/css/toastr.min.css">
    <script src="../assets/libs/toastr/js/toastr.min.js"></script>
    <!-- <script src="../assets/js/all.js"></script> -->


</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/ecsolution_logo.png" height="40" width="200" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="index.php?route=dashboard" aria-expanded="false">
                                <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <span class="sidebar-divider lg"></span>
                        </li>
                        <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#collapseProduct" aria-expanded="<?php echo ($route == 'product-management') ? 'true' : 'false'; ?>" aria-controls="collapseProduct">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                            <span class="hide-menu text-uppercase">order management</span>
                        </li>
                        <div class="collapse <?php echo ($route == 'customer-order' || $route == 'process-order' || $route == 'canceled-order') ? 'show' : ''; ?>" id="collapseProduct">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=customer-order" aria-expanded="false">
                                    <iconify-icon icon="mdi:cart"></iconify-icon>
                                    <span class="hide-menu">Customer Order</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=process-order" aria-expanded="false">
                                    <iconify-icon icon="material-symbols:category"></iconify-icon>
                                    <span class="hide-menu">Process Order</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=canceled-order" aria-expanded="false">
                                    <iconify-icon icon="material-symbols:category"></iconify-icon>
                                    <span class="hide-menu">Canceled Order</span>
                                </a>
                            </li>
                        </div>
                        <li>
                            <span class="sidebar-divider lg"></span>
                        </li>
                        <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#collapseStock" aria-expanded="false" aria-controls="collapseStock">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                            <span class="hide-menu text-uppercase">menu management</span>
                        </li>
                        <div class="collapse <?php echo ($route == 'food-menu' || $route == 'category-management') ? 'show' : ''; ?>" id="collapseStock">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=food-menu" aria-expanded="false">
                                    <iconify-icon icon="ph:stack-plus"></iconify-icon>
                                    <span class="hide-menu">Food Menu</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=category-management" aria-expanded="false">
                                    <iconify-icon icon="ph:stack-minus"></iconify-icon>
                                    <span class="hide-menu">Categories</span>
                                </a>
                            </li>
                        </div>
                        <li>
                            <span class="sidebar-divider lg"></span>
                        </li>
                        <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#collapseStock" aria-expanded="false" aria-controls="collapseStock">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                            <span class="hide-menu text-uppercase">customer management</span>
                        </li>
                        <div class="collapse <?php echo ($route == 'customer-detail' || $route == 'customer-feedback') ? 'show' : ''; ?>" id="collapseStock">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=customer-detail" aria-expanded="false">
                                    <iconify-icon icon="ph:stack-plus"></iconify-icon>
                                    <span class="hide-menu">Customer Detail</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=customer-feedback" aria-expanded="false">
                                    <iconify-icon icon="ph:stack-minus"></iconify-icon>
                                    <span class="hide-menu">Customer Feedback</span>
                                </a>
                            </li>
                        </div>
                        <li>
                            <span class="sidebar-divider lg"></span>
                        </li>
                        <li class="nav-small-cap" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="<?php echo ($route == 'product-management') ? 'true' : 'false'; ?>" aria-controls="collapseUser">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                            <span class="hide-menu text-uppercase">user management</span>
                        </li>
                        <div class="collapse <?php echo ($route == 'user-management' || $route == 'role-management') ? 'show' : ''; ?>" id="collapseUser">
                            <li class="sidebar-item">
                                <a class="sidebar-link <?php echo ($route == 'user-management') ? 'active' : ''; ?>" href="index.php?route=user-management" aria-expanded="false">
                                    <iconify-icon icon="mdi:cart"></iconify-icon>
                                    <span class="hide-menu">User</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="index.php?route=role-management" aria-expanded="false">
                                    <iconify-icon icon="material-symbols:category"></iconify-icon>
                                    <span class="hide-menu">Role</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="javascript:void(0)">
                                <iconify-icon icon="solar:bell-linear" class="fs-6"></iconify-icon>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">Settings</p>
                                        </a>
                                        <a href="admin/process/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
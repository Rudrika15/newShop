<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>New shop </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    {{--  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">  --}}

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.home') }}" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Admin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        {{--  <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->  --}}

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"> {{ Auth::user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6> {{ Auth::user()->name }}</h6>
                            {{--  <span>Web Designer</span>  --}}
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>

                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('user.password', auth()->user()->id) }}">
                                <i class="bi bi-gear"></i>
                                <span>Change Password</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.home') ? '' : 'collapsed' }}"
                    href="{{ route('admin.home') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>

            </li>
            
            <!-- End Dashboard Nav -->


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index') ? '' : 'collapsed' }}"
                    data-bs-target="#forms-nav" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person"></i><span>User Managment</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse {{ request()->routeIs('user.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>User List</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End User Managment Nav -->

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('category.index') ? '' : 'collapsed' }}"
                    data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Category Managment</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav"
                    class="nav-content collapse {{ request()->routeIs('category.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('category.index') }}"
                            class="{{ request()->routeIs('category.index') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Category List</span>
                        </a>
                    </li>
                    {{--  <li>
                    <a href="tables-data.html">
                      <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                  </li>  --}}
                </ul>
            </li><!-- End Tables Nav -->


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sku.index') ? '' : 'collapsed' }}"
                    data-bs-target="#sku-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-box"></i><span>SKU Management</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="sku-nav" class="nav-content collapse {{ request()->routeIs('sku.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('sku.index') }}"
                            class="{{ request()->routeIs('sku.index') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>SKU List</span>
                        </a>
                    </li>
                    {{--  <li>
                      <a href="{{ route('sku.create') }}">
                          <i class="bi bi-circle"></i><span>Create SKU</span>
                      </a>
                  </li>  --}}
                    <!-- Add more menu items for SKU management here... -->
                </ul>
            </li><!-- End SKU Management Nav -->

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('slider.index') ? '' : 'collapsed' }}"
                    data-bs-target="#slider-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-images"></i><span>Slider Management</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="slider-nav"
                    class="nav-content collapse {{ request()->routeIs('slider.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('slider.index') }}"
                            class="{{ request()->routeIs('slider.index') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Slider List</span>
                        </a>
                    </li>

                </ul>
            </li>
            <!-- End SKU Management Nav -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('product.index') ? '' : 'collapsed' }}"
                    data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav"
                    class="nav-content collapse {{ request()->routeIs('product.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('product.index') }}"
                            class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Products</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('orders.index') ? '' : 'collapsed' }}"
                    data-bs-target="#orders-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-box"></i><span>Order Management</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="orders-nav"
                    class="nav-content collapse {{ request()->routeIs('orders.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('orders.index') }}"
                            class="{{ request()->routeIs('orders.index') ? 'active' : '' }}">
                            <i class="bi bi-box"></i><span>Order List</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('report.index') ? '' : 'collapsed' }}"
                    data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-graph-up"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="report-nav"
                    class="nav-content collapse {{ request()->routeIs('report.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('report.index') }}"
                            class="{{ request()->routeIs('report.index') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Report List</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Reports Nav --> --}}

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pincode.index') ? '' : 'collapsed' }}"
                    data-bs-target="#pincode-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-geo-alt-fill"></i><span>Pincode Management</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pincode-nav"
                    class="nav-content collapse {{ request()->routeIs('pincode.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('pincode.index') }}"
                            class="{{ request()->routeIs('pincode.index') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt-fill"></i><span>Pincode List</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Pincode Nav -->


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('report.index') ? '' : 'collapsed' }}"
                    data-bs-target="#report" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-file-earmark-bar-graph"></i><span>Reports</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="report"
                    class="nav-content collapse {{ request()->routeIs('report.index') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('user.sticker') }}"
                            class="{{ request()->routeIs('user.sticker') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt-fill"></i><span>Address Sticker</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}"
                            class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt-fill"></i><span>User Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.catalog.index') }}"
                            class="{{ request()->routeIs('reports.catalog.index') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt-fill"></i><span>Catelog Report</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
$year = date('Y');
    ?>
    <footer id="footer" class="footer">
        <div class="copyright">
             <span>Developed by <a target="_blank" href="https://flipcodesolutions.com/">Flipcode solutions</span> || &copy; <?php print $year; ?> All rights reserved.        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            {{--  Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>  --}}
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    @yield('script')
    <script>
        // Hide the success message after 5 minutes
        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
        }, 2000);
    </script>
</body>

</html>

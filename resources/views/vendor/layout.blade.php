<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> Rideofto | Vendors | {{ $pageTitle ?? '' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Bootstrap link CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Font awsome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/favicon.ico') }}">

    <!-- jvectormap -->
    <link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom-style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="{{ asset('assets/plugins/px-pagination/px-pagination.css') }}">
    <link rel="stylesheet" type="text/css"href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
        <style>
            .required:after {
                content: " *";
                color: red;
            }
    
            .tox-statusbar__branding {
                display: none;
            }
    
            .tox-notification {
                display: none !important;
            }
        </style>
    @yield('custom-css')

</head>

<body class="">
    <!-- Left Sidenav -->
    <div class="left-sidenav">
        <!-- LOGO -->
        <div class="brand">
            <a href="{{ url('vendor/dashboard') }}" class="logo">
                <span>
                    {{-- <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm"> --}}
                </span>
                <span>
                    {{-- <img src="{{ asset('assets/images/logo.png') }}" alt="logo-large" class="logo-lg logo-light"> --}}
                    <img src="{{ asset('assets/img/logo/logo.png') }}" style="height:40px" alt="logo-large"
                        class="logo-lg logo-dark">
                </span>
            </a>
        </div>
        <!--end logo-->
        <div class="menu-content h-100" data-simplebar>
            <ul class="metismenu left-sidenav-menu">


                <li class="menu-label mt-0">Dashboard</li>
                <li class="@if (isset($currentPage) && $currentPage == 'dashboard') active @endif">
                    <a href="{{ url('vendor/dashboard') }}" class="@if (isset($currentPage) && $currentPage == 'dashboard') active @endif"> <i
                            data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span><span
                            class="menu-arrow"></span></a>
                </li>

                <hr class="hr-dashed hr-menu">
                <li class=" @if (in_array($currentPage, ['product', 'productAttr', 'allProducts', 'unit','addCycle','addAccessories'])) active mm-active @endif">
                    <a href="javascript: void(0);" class="@if (isset($currentPage) && in_array($currentPage, ['product', 'productAttr', 'allProducts'])) active @endif "> <i
                            class="fab fa-gg"></i> <span>Product</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level @if (in_array($currentPage, ['product', 'productAttr', 'allProducts', 'unit','addCycle','addAccessories'])) mm-show @endif "
                        aria-expanded="false">
                        <li class="nav-item @if ($currentPage == 'addCycle') active @endif ">
                            <a class="nav-link @if (isset($currentPage) && $currentPage == 'addCycle') active @endif "
                                href="{{ url('vendor/product?action=add-new-cycle') }}"><i class="ti-control-record">
                                </i>Add New Cycle</a>
                        </li>
                        <li class="nav-item @if ($currentPage == 'addAccessories') active @endif ">
                            <a class="nav-link @if (isset($currentPage) && $currentPage == 'addAccessories') active @endif "
                                href="{{ url('vendor/product?action=add-new-accessories') }}"><i
                                    class="ti-control-record">
                                </i>Add New Accessories</a>
                        </li>
                        <li class="nav-item @if ($currentPage == 'allProducts') active @endif ">
                            <a class="nav-link @if (isset($currentPage) && $currentPage == 'allProducts') active @endif "
                                href="{{ url('vendor/product?action=all-product') }}"><i class="ti-control-record">
                                </i>All Products</a>
                        </li>

                    </ul>
                </li>
                <li class="@if (isset($currentPage) && $currentPage == 'discount') active @endif">
                    <a href="{{ url('vendor/discount?action=add-discount') }}"
                        class="@if (isset($currentPage) && $currentPage == 'discount') text-primary @endif"><i
                            class="fas fa-percent"></i><span>Product Discount</span><span class="menu-arrow"></span></a>
                </li>
                <li class="@if ($currentPage == 'vendor_timing') active @endif">
                    <a href="{{ url('vendor/schedule?action=vendor-timing') }}"
                        class="nav-link @if (isset($currentPage) && $currentPage == 'vendor_timing') text-primary @endif "><i
                            class="dripicons-alarm"></i><span>Vendor Schedule</span><span class="menu-arrow"></span></a>
                </li>
                <li class="@if ($currentPage == 'block_date') text-primary @endif">
                    <a href="{{ url('vendor/schedule?action=vendor-block-date') }}"
                        class="nav-link @if (isset($currentPage) && $currentPage == 'block_date') text-primary @endif "><i
                        class="fa fa-calendar"></i><span>Block Date</span><span class="menu-arrow"></span></a>
                </li>
                <li class="@if ($currentPage == 'vendorProfile') active @endif">
                    <a href="{{ url('vendor/vendor-profile?action=profile') }}" class="nav-link @if (isset($currentPage) && $currentPage == 'vendorProfile') text-primary @endif"> <i
                            class="fas fa-user-tie"></i><span>Vendor Profile</span><span class="menu-arrow"></span></a>
                </li>

                <li class="@if(in_array($currentPage,['bookingReq','ongoingBooking','bookingHistory'])) text-primary mm-active @endif">
                    <a href="javascript: void(0);" class="@if (isset($currentPage) && in_array($currentPage, ['bookingReq','ongoingBooking','bookingHistory'])) text-primary @endif"> 
                        <i class="fab fa-gg"></i> <span>Booking</span><span
                            class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level @if ( in_array($currentPage, ['bookingReq','ongoingBooking','bookingHistory'])) mm-show @endif" aria-expanded="false">
                        
                        <li class="nav-item @if ($currentPage == 'bookingReq') text-primary @endif">
                            <a class="nav-link" href="{{ url('vendor/booking?action=booking-request') }}"><i
                                    class="ti-control-record">
                                </i>Booking Request</a>
                        </li>
                        <li class="nav-item @if ($currentPage == 'ongoingBooking') active @endif">
                            <a class="nav-link" href="{{ url('vendor/booking?action=progress-booking') }}"><i
                                    class="ti-control-record">
                                </i>In Progress Booking</a>
                        </li>
                        <li class="nav-item @if($currentPage == 'bookingHistory') active @endif">
                            <a class="nav-link" href="{{ url('vendor/booking?action=booking-history') }}"><i
                                    class="ti-control-record">
                                </i>Booking History</a>
                        </li>
                    </ul>
                </li>

                <li class="@if ($currentPage == 'reviewnratings') active @endif">
                    <a href="{{ url('vendor/review-ratings') }}" class="nav-link @if (isset($currentPage) && $currentPage == 'reviewnratings') active @endif"> <i
                            class="fas fa-comment-dots"></i><span>Review & Ratings</span><span class="menu-arrow"></span></a>
                </li>
                <hr class="hr-dashed hr-menu">

                <li class="@if ($currentPage == 'TERMS CONDITIONS') active @endif">
                    <a href="{{ url('vendor/terms-conditions') }}" class="nav-link @if (isset($currentPage) && $currentPage == 'TERMS CONDITIONS') active @endif"> <i
                            class="fas fa-file-contract"></i><span>Terms & Conditions</span><span class="menu-arrow"></span></a>
                </li>

                <li class="@if ($currentPage == 'Payment Aggrement') active @endif">
                    <a href="{{ url('vendor/payment-aggrement') }}" class="nav-link @if (isset($currentPage) && $currentPage == 'Payment Aggrement') active @endif"> <i
                            class="fas fa-handshake"></i><span>Payment Aggrement</span><span class="menu-arrow"></span></a>
                </li>

                
                <li class="@if (isset($currentPage) && $currentPage == 'resetPassword') active @endif">
                    <a href="{{ url('vendor/change-password') }}"
                        class="@if (isset($currentPage) && $currentPage == 'resetPassword') active @endif"><i
                            class="fas fa-lock"></i><span>Change Password</span><span class="menu-arrow"></span></a>
                </li>
            </ul>

        </div>
    </div>
    <!-- end left-sidenav-->


    <div class="page-wrapper">
        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- Navbar -->
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-nav float-end mb-0">

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user"
                            data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">

                            <img src="{{ asset('assets/images/profile.png') }}" alt="profile-user"
                                class="rounded-circle thumb-xs" />
                            <span class="ms-1 nav-user-name hidden-sm "
                                style="font-size:1rem">{{ Session::get('store_name', 'User') }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">

                            <a class="dropdown-item" href="{{ url('vendor/logout') }}"><i data-feather="power"
                                    class="align-self-center icon-xs icon-dual me-1"></i> Logout</a>
                        </div>
                    </li>
                </ul>
                <!--end topbar-nav-->

                <ul class="list-unstyled topbar-nav mb-0">
                    <li>
                        <button class="nav-link button-menu-mobile">
                            <i data-feather="menu" class="align-self-center topbar-icon"></i>
                        </button>
                    </li>
                    {{-- <li class="creat-btn">
                            <div class="nav-link">
                                <a class=" btn btn-sm btn-soft-primary" href="#" role="button"><i class="fas fa-plus me-2"></i>New Task</a>
                            </div>                                
                        </li>                            --}}
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="row">


                                <div class="col">
                                    <h4 class="page-title">{{ $pageTitle ?? '' }}</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">RIdeOfto</a></li>
                                        @yield('breadcrumb')
                                        {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
                                    </ol>
                                </div>


                                <div class="col-auto align-self-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary" id="">
                                        <span class="ay-name" id="Day_Name">Today:</span>&nbsp;
                                        <span class="" id="">{{ date('M d , Y') }}</span>
                                        {{-- <i data-feather="calendar" class="align-self-center icon-xs ms-1"></i> --}}
                                    </a>
                                    {{-- <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i data-feather="download" class="align-self-center icon-xs"></i>
                                        </a> --}}
                                </div>

                            </div>
                            <!--end row-->
                        </div>
                        <!--end page-title-box-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                <!-- end page title end breadcrumb -->

                <!-- Start Page Body -->

                @yield('body')

                <!-- End Page Body -->


            </div><!-- container -->

           <footer class="footer text-center text-sm-start">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> RideOfto,All Rights Reserved.

                <a class="text-danger" href="{{ url('vendor/agree-terms-conditions') }}"-
                    style="margin-left: 249px">Terms &
                    Conditions</a>

                {{-- <span class="text-muted d-none d-sm-inline-block float-end">Developed And Designed By
                    <a class="text-primary" href="https://codepilot.in/" target="_blank">Codepilot Technologies Pvt.
                        Ltd.</a> </span> --}}
            </footer>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->




    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    <script src="{{ asset('assets/pages/jquery.analytics_dashboard.init.js') }}"></script>
    <!--Wysiwig js Editor-->
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/pages/jquery.form-editor.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/px-pagination/px-pagination.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    @yield('custom-js')

</body>

</html>

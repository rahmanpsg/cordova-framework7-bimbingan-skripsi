<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/logo.png') ?>">
    <title>Aplikasi Bimbingan Skripsi Online</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url('assets/css/colors/blue.css') ?>" id="theme" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/bootstrap-table/bootstrap-table.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/bootstrap-validator/css/bootstrapValidator.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/assets/plugins/bootstrap-select/bootstrap-select.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.css') ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:700);

        .judul {
            /* background: #fff; */
            color: #fff;
            font-size: 1em;
            font-family: 'Open Sans';
            margin-left: 2em;
        }

        .anaglyph {
            text-shadow: -0.06em 0 red, 0.06em 0 cyan;
        }
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <!-- <div class="navbar-header"> -->
                <a class="navbar-brand" href="#">
                    <b class="container">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="<?= base_url('/assets/images/logo.png') ?>" width="50" alt="homepage" class="dark-logo" />

                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="judul anaglyph">
                        <!-- dark Logo text -->
                        Aplikasi Bimbingan Skripsi Online
                    </span>

                </a>
                <!-- </div> -->
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0 ">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a href="<?php echo base_url('admin/') ?>" class="waves-effect"><i class="fa fa-dashboard m-r-10" aria-hidden="true"></i>Dashboard</a>
                        </li>
                        <hr class="sidebar-divider">
                        <div class="sidebar-heading" style="margin-left: 1em">
                            Master Data
                        </div>
                        <li>
                            <a href="<?php echo base_url('admin/dosen') ?>" class="waves-effect"><i class="fa fa-user m-r-10" aria-hidden="true"></i>Data Dosen</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/mahasiswa') ?>" class="waves-effect"><i class="fa fa-users m-r-10" aria-hidden="true"></i>Data Mahasiswa</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/pembimbing') ?>" class="waves-effect"><i class="fa fa-list-alt m-r-10" aria-hidden="true"></i>Data Pembimbing</a>
                        </li>
                        <hr class="sidebar-divider">
                    </ul>
                    <div class="text-center m-t-30">
                        <a href="<?php echo base_url('logout') ?>" class="btn btn-danger"><i class="fa fa-power-off m-r-10" aria-hidden="true"></i> Logout</a>
                    </div>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
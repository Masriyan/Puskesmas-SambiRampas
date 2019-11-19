<?php
  session_start();
  // session_destroy();

  if (isset($_SESSION)) {
    if ($_SESSION['user_session'] == "" || $_SESSION['status_login'] == "" || $_SESSION['ha'] == "" ) {
      // echo "status login tidak ditemukan";
      header("location:".base_url()."login");
    }else {
      // echo "status Login terverivikasi.";
    }
    // print_r($_SESSION);
  }else {
    echo "tidak ada aktivitas login. izin masuk terlarang terdeteksi";
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administrasi</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url();?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url();?>assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="<?php echo base_url();?>assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="<?php echo base_url();?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="<?php echo base_url();?>assets/vendors/starrr/dist/starrr.css" rel="stylesheet">

    <!-- date time picker -->
    <link href="<?php echo base_url();?>assets/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">


    <!-- Datatables -->
    <link href="<?php echo base_url();?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo base_url();?>assets/images/logo-puskesmas.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                  <h2> </h2>
                <h2>PUSKESMAS POTA</h2>

              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <!-- <h3>General</h3> -->
                <?php
                  if ($_SESSION['ha'] == "1" || $_SESSION['ha'] == "4"){
                ?>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url().'dashboard';?>"><i class="fa fa-home"></i> Dashboard </a></li>
                </ul>
                <?php
                  }
                ?>
                <?php
                  if ($_SESSION['ha'] == "1" || $_SESSION['ha'] == "4"){
                ?>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url().'remed';?>"><i class="fa fa-home"></i> Rekap Medis </a></li>
                </ul>
                <?php
                  }
                ?>
                <?php
                  if ($_SESSION['ha'] == "1"){
                ?>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url().'ha';?>"><i class="fa fa-home"></i> Hak Akses </a></li>
                </ul>
                <?php
                  }
                ?>
                <?php
                  if ($_SESSION['ha'] == "1"){
                ?>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url().'jepem';?>"><i class="fa fa-home"></i> jenis Pembayaran </a></li>
                </ul>
                <?php
                  }
                ?>
                <?php
                  if ($_SESSION['ha'] == "1"){
                ?>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url().'jepol';?>"><i class="fa fa-home"></i> Jenis Poli </a></li>
                </ul>
                <?php
                  }
                ?>
                <?php
                  // if ($_SESSION['ha'] == "1" || $_SESSION['ha'] == "4"){
                ?>
                <!-- <ul class="nav side-menu">
                  <li><a href="<?php echo base_url().'c';?>"><i class="fa fa-home"></i> Laporan </a></li>
                </ul> -->
                <?php
                  // }
                ?>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['user_session']; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?= base_url().'login/logOut'?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>


              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

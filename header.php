<?php
session_start();
require 'koneksi/koneksi.php';

// Hitung jumlah item dalam keranjang
$jumlah_keranjang = isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $info_web->title; ?></title>
    <link rel="shortcut icon" href="assets/img/logo/<?= $info_web->logo; ?>">
    <meta content="Dapur Kynan" name="descriptison">
    <meta content="Dapur Kynan" name="keywords">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/plugins/font-awesome-4.7.0/css/font-awesome-animation.min.css">
    <!-- Sweetalert -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/swal/sweetalert.css">
    <script type="text/javascript" src="assets/plugins/swal/sweetalert.min.js"></script>
    <script src="assets/js/jquery-2.2.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <script src="ajax/js/jquery-1.10.2.min.js"></script>
    <link href="ajax/css/jquery-ui.css" rel="stylesheet">
    <script src="ajax/js/jquery-ui.js"></script>
    <!--  <script src="ajax/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="ajax/css/bootstrap.min.css"> -->
    <!-- Custom CSS -->
    <link href="ajax/css/style.css" rel="stylesheet">
    <style type="text/css">
        .gambarsorot img {
            -webkit-transform: scale(0.9);
            -moz-transform: scale(0.9);
            -o-transform: scale(0.9);
            -webkit-transition-duration: 0.3s;
            -moz-transition-duration: 0.3;
            -o-transition-duration: 0.3s;
            opacity: 0.8;
            margin: 0 5px 5px 0;
        }

        .gambarsorot img:hover {
            -webkit-transform: scale(1.0);
            -moz-transform: scale(1.0);
            -o-transform: scale(1.0);
            box-shadow: 0px 0px 5px #3c8dbc;
            -webkit-box-shadow: 0px 0px 5px #3c8dbc;
            -moz-box-shadow: 0px 0px 5px #3c8dbc;
            opacity: 1;
        }
    </style>
    <!-- Data Table -->
    <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/diva.css" rel="stylesheet">

    <!-- Sweetalert -->
    <link rel="stylesheet" type="text/css" href="assets/swal/sweetalert.css">
    <script type="text/javascript" src="assets/swal/sweetalert.min.js"></script>
    <script src="assets/js/jquery-2.2.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex">

            <div class="logo mr-auto">
                <div class="media">
                    <a class="pull-left" href="./">
                        <img style="padding-right: 5px;" src="assets/img/logo/<?= $info_web->logo; ?>" class="img-responsive" alt="Responsive image">
                    </a>
                    <div class="media-body">
                        <h1 class="media-heading">
                            <a href="./">
                                <?= $info_web->title; ?>
                        </h1>
                        <p style="position: absolute; font-size: 8px; margin-top: -50;color: #3c8dbc;letter-spacing: 1px;color: #3c8dbc; letter-spacing: 0;">
                            Cemilan Halal, Homemade dan Tanpa Pengawet
                        </p>
                        </a>
                    </div>
                </div>
            </div>
            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li><a onclick="window.location.href='./'" type="submit"><i class="fa fa-home faa-tada animated-hover"></i> Beranda</a></li>
                    <li><a type="submit" onclick="window.location.href='./#produk'"><i class="fa fa-bars faa-tada animated-hover"></i> Produk</a></li>
                    <li><a type="submit" onclick="window.location.href='./#kontak'"><i class="fa fa-phone-square faa-tada animated-hover"></i> Kontak</a></li>
                    <li><a data-toggle="tooltip" data-placement="bottom" title="keranjang Belanja" type="submit" onclick="window.location.href='keranjang.php'"><i class='fa fa-opencart faa-tada animated-hover'></i> Keranjang <span style="padding: 5px;font-size: 8px;" class="badge badge-primary"> <?php echo $jumlah_keranjang; ?></span></a></li>
                </ul>
            </nav><!-- .nav-menu -->

        </div>
    </header><!-- End Header -->

    <script>
        jQuery(document).ready(function($) {
            $('.keluar').on('click', function() {
                var getLink = $(this).attr('href');
                swal({
                    title: 'Anda Yakin Akan Keluar?',
                    text: 'Aplikasi <?= $info_web->title; ?>',
                    html: true,
                    type: 'warning',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Ya, Keluar!',
                    showCancelButton: true,
                    cancelButtonColor: "#dc3545",
                    cancelButtonText: 'Batal',
                }, function() {
                    window.location.href = getLink
                });
                return false;
            });
        });
    </script>
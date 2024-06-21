<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : header.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
session_start();
if (!empty($_SESSION['USER']['level'] == 'admin')) {
} else {
    echo '<script>alert("Login Khusus Admin !");window.location="../index.php";</script>';
}

// select untuk panggil nama admin
$id_login = $_SESSION['USER']['id_login'];

$row = $koneksi->prepare("SELECT * FROM login WHERE id_login=?");
$row->execute(array($id_login));
$hasil_login = $row->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title_web; ?> | Kynan</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Bootstrap CSS -->
    <link href="<?= $url ?>admin/assets/img/favicon.png" rel="icon">
    <link href="<?= $url ?>admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- niceAdmin -->
    <!-- Favicons -->
    <link href="<?= $url ?>admin/assets/img/favicon.png" rel="icon">
    <link href="<?= $url ?>admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="<?= $url ?>admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/boxicons/css/animations.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/boxicons/css/boxicons.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/boxicons/css/transformation.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= $url ?>admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="<?= $url ?>admin/assets/css/style.css" rel="stylesheet">
    <!-- niceAdmin -->

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= $url ?>admin/index.php" class="logo d-flex align-items-center">
                <img src="<?= $url ?>admin/assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Dashboard Admin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <!-- Topbar Search -->
        <form class="d-none d-sm-inline-flex flex-fill mr-auto ml-md-3 my-2 my-md-0 navbar-search">
            <div class="input-group">
                <?php
                date_default_timezone_set('Asia/Jakarta'); // Set zona waktu menjadi di Indonesia
                $tanggal = date("d");
                $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                $bulan = $bulan[date("n")];
                $tahun = date("Y");
                $jam = date("H");
                $waktu = date("H:i:s");

                echo '<input type="text" class="form-control bg-light border-0 small flex-grow-1" value="' . $tanggal . " " . $bulan . " " . $tahun . " | " . $waktu . ' | ';

                if (($jam >= 1) && ($jam <= 10)) {
                    echo "Selamat Pagi...";
                } else if (($jam > 10) && ($jam <= 13)) {
                    echo "Selamat Siang...";
                } else if (($jam > 13) && ($jam <= 17)) {
                    echo "Selamat Sore...";
                } else if (($jam > 17) && ($jam <= 18)) {
                    echo "Selamat Petang...";
                } else {
                    echo "Selamat Malam...";
                }

                echo '" aria-label="Search" aria-describedby="basic-addon2" disabled>';
                ?>
                <div class="input-group-append"></div>
            </div>
        </form>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <strong><i class="fa fa-user"></i> Hallo, Admin <?php echo $hasil_login['nama_pengguna']; ?></strong>
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo $url; ?>admin/logout.php" onclick="return confirm('Apakah anda ingin logout ?');">
                                <i class="bi bi-box-arrow-left"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->

    </header>
    <!-- End Header -->
    <!-- ======= Header ======= -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $url; ?>admin/">
                    <i class="bi bi-grid"></i>
                    <span>Home</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $url; ?>admin/produk/produk.php">
                    <i class="ri-restaurant-line"></i>
                    <span>Daftar Produk</span>
                </a>
            </li><!-- End produk Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $url; ?>admin/kategori/kategori.php">
                    <i class="bx bxs-duplicate"></i>
                    <span>Daftar Kategori</span>
                </a>
            </li><!-- End kategori Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $url; ?>admin/pesanan/pesanan.php">
                    <i class="bx bxs-cart-download"></i>
                    <span>Pesanan Masuk</span>
                </a>
            </li><!-- End pesanan Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#app-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-pc-display"></i><span>Aplikasi Website</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="app-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?php echo $url; ?>admin/identitas/identitas.php">
                            <i class="bi bi-circle"></i><span>Identitas</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $url; ?>admin/background/background.php">
                            <i class="bi bi-circle"></i><span>Background</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $url; ?>admin/sosialmedia/sosialmedia.php">
                            <i class="bi bi-circle"></i><span>Sosial Media</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Blank Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#catatan-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-pc-display"></i><span>Pencatatan Keuangan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="catatan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?php echo $url; ?>admin/pemasukan/pemasukan.php">
                            <i class="bi bi-circle"></i><span>Pemasukan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $url; ?>admin/pengeluaran/pengeluaran.php">
                            <i class="bi bi-circle"></i><span>Pengeluaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $url; ?>admin/laporan/laporan.php">
                            <i class="bi bi-circle"></i><span>Laporan</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Blank Page Nav -->

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $url; ?>">
                    <i class="ri ri-home-3-fill"></i>
                    <span>Halaman User</span>
                </a>
            </li><!-- End Blank Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $url; ?>admin/logout.php" onclick="return confirm('Apakah anda ingin logout ?');">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Sign Out</span>
                </a>
            </li><!-- End Blank Page Nav -->

        </ul>
    </aside><!-- End Sidebar-->
    <!-- ======= Sidebar ======= -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= $url ?>admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="<?= $url ?>admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $url ?>admin/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="<?= $url ?>admin/assets/vendor/echarts/echarts.min.js"></script>
    <script src="<?= $url ?>admin/assets/vendor/quill/quill.min.js"></script>
    <script src="<?= $url ?>admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="<?= $url ?>admin/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="<?= $url ?>admin/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= $url ?>admin/assets/js/main.js"></script>

</body>

</html>
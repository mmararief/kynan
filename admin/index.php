<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : index.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
require '../koneksi/koneksi.php';
$title_web = 'Dashboard';
include 'header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Daftar Produk</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ri-restaurant-line"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php $sql = mysqli_query($con, "SELECT count(1) FROM Produk"); ?>
                                        <?php $row =  mysqli_fetch_array($sql) ?>
                                        <?php $total =  $row[0] ?>
                                        <h6><?= $total ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Kategori Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Daftar Kategori</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bxs-duplicate"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php $sql = mysqli_query($con, "SELECT count(1) FROM kategori"); ?>
                                        <?php $row =  mysqli_fetch_array($sql) ?>
                                        <?php $total =  $row[0] ?>
                                        <h6><?= $total ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Kategori Card -->

                    <!-- pesanan Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Pesanan Masuk</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bxs-cart-download"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php $sql = mysqli_query($con, "SELECT count(1) FROM konfirmasi"); ?>
                                        <?php $row =  mysqli_fetch_array($sql) ?>
                                        <?php $total =  $row[0] ?>
                                        <h6><?= $total ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End pesanan Card -->

                </div>
            </div>

        </div>
    </section>

</main>

<!-- alert https://sweetalert2.github.io/ -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include 'footer.php'; ?>
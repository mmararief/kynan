<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : tambah.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Tambah Kategori';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tambah Kategori</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= $url ?>admin/kategori/kategori.php">Daftar Kategori</a></li>
                <li class="breadcrumb-item active">Tambah Kategori</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title">
                            Tambah Kategori
                            <div class="float-right">
                                <a class="btn btn-warning" href="kategori.php" role="button">Kembali</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=tambah" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group row">
                                            <label class="col-sm-3">Nama Kategori</label>
                                            <input type="text" class="form-control col-sm-9" name="nama_kategori" placeholder="Isi Nama Kategori">
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="float-right">
                                    <button class="btn btn-primary" role="button" type="submit">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php include '../footer.php'; ?>
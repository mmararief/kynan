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
$title_web = 'Tambah Pemasukan';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tambah Pemasukan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= $url ?>admin/pemasukan/pemasukan.php">Daftar Pemasukan</a></li>
                <li class="breadcrumb-item active">Tambah Pemasukan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title">
                            Tambah Pemasukan
                            <div class="float-right">
                                <a class="btn btn-warning" href="pemasukan.php" role="button">Kembali</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=tambah" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <tr>
                                            <td>Masukkan Tanggal Pemasukan</td>
                                            <td>:</td>
                                            <td><input class="form-control" type="date" value="<?= $today ?>" name="tanggal" required></td>
                                        </tr>
                                        <tr>
                                            <td>Masukkan Keterangan Pemasukan</td>
                                            <td>:</td>
                                            <td><input class="form-control" type="text" name="keterangan" autocomplete="off" required></td>
                                        </tr>

                                        <tr>
                                            <td>Masukkan Sumber Pemasukan</td>
                                            <td>:</td>
                                            <td>
                                                <select name="sumber" class="form-control">
                                                    <option value="" disabled selected>Pilih Sumber Pemasukan</option>
                                                    <option value="Penjualan">Penjualan Produk</option>
                                                    <option value="Biaya Antar">Biaya Antar</option>
                                                    <option value="TIP">TIP</option>
                                                    <option value="Lain-Lain">Lain-Lain</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Masukkan Jumlah Pemasukan</td>
                                            <td>:</td>
                                            <td><input class="form-control" type="text" name="jumlah" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required></td>
                                        </tr>
                                        <tr>
                                            <td><input type="hidden" name="username" value="<?= $ambilNama ?>"></td>
                                            <td></td>
                                        </tr>
                                        <br>
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
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
$title_web = 'Tambah Produk';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tambah Produk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= $url ?>admin/produk/produk.php">Daftar Produk</a></li>
                <li class="breadcrumb-item active">Tambah Produk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title">
                            Tambah Produk
                            <div class="float-right">
                                <a class="btn btn-warning" href="produk.php" role="button">Kembali</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=tambah" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3">Nama Produk</label>
                                            <input type="text" class="form-control col-sm-9" name="nama_produk" placeholder="Isi Nama Produk">
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Kategori</label>
                                            <select class="form-control col-sm-9" name="id_kategori">
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                <?php
                                                // Query to fetch categories from the database
                                                $sql_kategori = "SELECT * FROM kategori";
                                                $row_kategori = $koneksi->prepare($sql_kategori);
                                                $row_kategori->execute();
                                                $hasil_kategori = $row_kategori->fetchAll();

                                                // Display categories in the dropdown
                                                foreach ($hasil_kategori as $kategori) {
                                                    echo '<option value="' . $kategori['id_kategori'] . '">' . $kategori['nama_kategori'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Harga</label>
                                            <input type="text" class="form-control col-sm-9" name="harga" placeholder="Isi Harga">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3">Status</label>
                                            <select class="form-control col-sm-9" name="status">
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="PO">PO</option>
                                                <option value="Tidak PO">Tidak PO</option>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Gambar</label>
                                            <input type="file" accept="image/*" class="form-control col-sm-9" name="gambar" placeholder="Isi Gambar">
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
<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file      : tambah.php 
  | author     : kynan@gmail.com
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Tambah Pesanan';
include '../header.php';

if (empty($_SESSION['USER'])) {
    session_start();
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Pesanan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pesanan.php">Pesanan Masuk</a></li>
                <li class="breadcrumb-item active">Tambah Pesanan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title">
                            Tambah Pesanan
                            <div class="float-right">
                                <a class="btn btn-warning" href="pesanan.php" role="button">Kembali</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="proses.php?aksi=tambah">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label for="via">Via</label>
                                <input type="text" class="form-control" id="via" name="via" required>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                            </div>
                            <div class="form-group">
                                <label for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="62" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat (Opsional)</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                            <div class="form-group">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Total Belanja</label>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#whatsapp').on('input', function() {
            // Ensure input is numeric and starts with "62"
            this.value = this.value.replace(/[^0-9]/g, '');
            if (!this.value.startsWith('62')) {
                this.value = '62';
            }
        });
    });
</script>
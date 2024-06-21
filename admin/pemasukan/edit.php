<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : edit.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Edit Pemasukan';
include '../header.php';

// Pastikan pengguna sudah login
if (empty($_SESSION['USER'])) {
    header("Location: ../../login.php");
    exit();
}

// Ambil ID pemasukan yang akan di-edit
if (!isset($_GET['id'])) {
    header("Location: pemasukan.php");
    exit();
}
$id_pemasukan = $_GET['id'];

// Ambil data pemasukan berdasarkan ID
$sql = "SELECT * FROM pemasukan WHERE id_pemasukan = :id_pemasukan";
$row = $koneksi->prepare($sql);
$row->bindParam(':id_pemasukan', $id_pemasukan);
$row->execute();
$pemasukan = $row->fetch();

// Jika data tidak ditemukan, redirect ke halaman daftar pemasukan
if (!$pemasukan) {
    header("Location: pemasukan.php");
    exit();
}

// Proses Update data pemasukan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $sumber = $_POST['sumber'];
    $jumlah = $_POST['jumlah'];

    $sql = "UPDATE pemasukan SET tanggal = :tanggal, keterangan = :keterangan, sumber = :sumber, jumlah = :jumlah WHERE id_pemasukan = :id_pemasukan";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':keterangan', $keterangan);
    $stmt->bindParam(':sumber', $sumber);
    $stmt->bindParam(':jumlah', $jumlah);
    $stmt->bindParam(':id_pemasukan', $id_pemasukan);

    if ($stmt->execute()) {
        // Jika update berhasil, redirect ke halaman daftar pemasukan
        header("Location: pemasukan.php");
        exit();
    } else {
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Pemasukan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pemasukan.php">Daftar Pemasukan</a></li>
                <li class="breadcrumb-item active">Edit Pemasukan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary mb-4">
                        <h4 class="card-title text-light">
                            Edit Pemasukan - <?= $pemasukan['keterangan']; ?>
                            <div class="float-right">
                                <a class="btn btn-warning" href="pemasukan.php" role="button">Kembali</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=edit&id=<?= $id_pemasukan; ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label for="tanggal">Masukkan Tanggal Pemasukan</label>
                                            <input type="date" class="form-control col-sm-9" value="<?= $pemasukan['tanggal'] ?>" name="tanggal" placeholder="Masukkan Tanggal Pemasukan">
                                        </div>

                                        <div class="form-group row">
                                            <label for="keterangan">Masukkan Keterangan Pemasukan :</label>
                                            <input type="text" class="form-control col-sm-9" value="<?= $pemasukan['keterangan'] ?>" name="keterangan" placeholder="Masukkan Keterangan Pemasukan">
                                        </div>

                                        <div class="form-group row">
                                            <label for="sumber">Masukkan Sumber Pemasukan :</label>
                                            <select class="form-control col-sm-9" name="sumber">
                                                <option value="" disabled selected>Pilih Sumber Pemasukan</option>
                                                <option <?php if ($pemasukan['sumber'] == 'Penjualan') {
                                                            echo 'selected';
                                                        } ?>>Penjualan</option>
                                                <option <?php if ($pemasukan['sumber'] == 'Piutang') {
                                                            echo 'selected';
                                                        } ?>>Piutang</option>
                                                <option <?php if ($pemasukan['sumber'] == 'ATM') {
                                                            echo 'selected';
                                                        } ?>>ATM</option>
                                                <option <?php if ($pemasukan['sumber'] == 'TIP') {
                                                            echo 'selected';
                                                        } ?>>TIP</option>
                                                <option <?php if ($pemasukan['sumber'] == 'Pekerjaan') {
                                                            echo 'selected';
                                                        } ?>>Pekerjaan</option>
                                                <option <?php if ($pemasukan['sumber'] == 'Lain-Lain') {
                                                            echo 'selected';
                                                        } ?>>Lain-Lain</option>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jumlah">Masukkan Jumlah Pemasukan :</label>
                                            <input type="text" class="form-control col-sm-9" value="<?= $pemasukan['jumlah'] ?>" placeholder="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pemasukan">
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

</main>

<?php include '../footer.php'; ?>
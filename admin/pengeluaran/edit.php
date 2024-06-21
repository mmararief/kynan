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
$title_web = 'Edit Pengeluaran';
include '../header.php';

// Pastikan pengguna sudah login
if (empty($_SESSION['USER'])) {
    header("Location: ../../login.php");
    exit();
}

// Ambil ID pengeluaran yang akan di-edit
if (!isset($_GET['id'])) {
    header("Location: pengeluaran.php");
    exit();
}
$id_pengeluaran = $_GET['id'];

// Ambil data pengeluaran berdasarkan ID
$sql = "SELECT * FROM pengeluaran WHERE id_pengeluaran = :id_pengeluaran";
$row = $koneksi->prepare($sql);
$row->bindParam(':id_pengeluaran', $id_pengeluaran);
$row->execute();
$pengeluaran = $row->fetch();

// Jika data tidak ditemukan, redirect ke halaman daftar pengeluaran
if (!$pengeluaran) {
    header("Location: pengeluaran.php");
    exit();
}

// Proses Update data pengeluaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $sumber = $_POST['sumber'];
    $jumlah = $_POST['jumlah'];

    $sql = "UPDATE pengeluaran SET tanggal = :tanggal, keterangan = :keterangan, sumber = :sumber, jumlah = :jumlah WHERE id_pengeluaran = :id_pengeluaran";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':keterangan', $keterangan);
    $stmt->bindParam(':sumber', $sumber);
    $stmt->bindParam(':jumlah', $jumlah);
    $stmt->bindParam(':id_pengeluaran', $id_pengeluaran);

    if ($stmt->execute()) {
        // Jika update berhasil, redirect ke halaman daftar pengeluaran
        header("Location: pengeluaran.php");
        exit();
    } else {
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Pengeluaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pengeluaran.php">Daftar Pengeluaran</a></li>
                <li class="breadcrumb-item active">Edit Pengeluaran</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary mb-4">
                        <h4 class="card-title text-light">
                            Edit Pengeluaran - <?= $pengeluaran['keterangan']; ?>
                            <div class="float-right">
                                <a class="btn btn-warning" href="pengeluaran.php" role="button">Kembali</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=edit&id=<?= $id_pengeluaran; ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label for="tanggal">Masukkan Tanggal Pengeluaran</label>
                                            <input type="date" class="form-control col-sm-9" value="<?= $pengeluaran['tanggal'] ?>" name="tanggal" placeholder="Masukkan Tanggal Pengeluaran">
                                        </div>

                                        <div class="form-group row">
                                            <label for="keterangan">Masukkan Keterangan Pengeluaran :</label>
                                            <input type="text" class="form-control col-sm-9" value="<?= $pengeluaran['keterangan'] ?>" name="keterangan" placeholder="Masukkan Keterangan Pengeluaran">
                                        </div>

                                        <div class="form-group row">
                                            <label for="sumber">Masukkan Sumber Pengeluaran :</label>
                                            <select class="form-control col-sm-9" name="sumber">
                                                <option value="" disabled selected>Pilih Sumber Pengeluaran</option>
                                                <option <?php if ($pengeluaran['sumber'] == 'Makan dan Minum') {
                                                            echo 'selected';
                                                        } ?>>Makan dan Minum</option>
                                                <option <?php if ($pengeluaran['sumber'] == 'Hutang') {
                                                            echo 'selected';
                                                        } ?>>Hutang</option>
                                                <option <?php if ($pengeluaran['sumber'] == 'Peralatan') {
                                                            echo 'selected';
                                                        } ?>>Peralatan</option>
                                                <option <?php if ($pengeluaran['sumber'] == 'Organisasi') {
                                                            echo 'selected';
                                                        } ?>>Organisasi</option>
                                                <option <?php if ($pengeluaran['sumber'] == 'Kendaraan') {
                                                            echo 'selected';
                                                        } ?>>Kendaraan</option>
                                                <option <?php if ($pengeluaran['sumber'] == 'Keperluan Pribadi') {
                                                            echo 'selected';
                                                        } ?>>Keperluan Pribadi</option>
                                                <option <?php if ($pengeluaran['sumber'] == 'Lain-Lain') {
                                                            echo 'selected';
                                                        } ?>>Lain-Lain</option>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jumlah">Masukkan Jumlah Pengeluaran :</label>
                                            <input type="text" class="form-control col-sm-9" value="<?= $pengeluaran['jumlah'] ?>" placeholder="jumlah" name="jumlah" placeholder="Masukkan Jumlah Pengeluaran">
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
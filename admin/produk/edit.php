<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : edit.php 
  | @author    : kynan@gmail.com
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Edit Produk';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
$id = $_GET['id'];

$sql = "SELECT produk.*, kategori.nama_kategori 
        FROM produk 
        JOIN kategori ON produk.id_kategori = kategori.id_kategori 
        WHERE produk.id_produk = ?";
$row = $koneksi->prepare($sql);
$row->execute(array($id));

$hasil = $row->fetch();
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Produk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= $url ?>admin/produk/produk.php">Daftar Produk</a></li>
                <li class="breadcrumb-item active">Edit Produk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary mb-4">
                        <h4 class="card-title text-light">
                            Edit Produk - <?= $hasil['nama_produk']; ?>
                            <div class="float-right">
                                <a class="btn btn-warning" href="produk.php" role="button">Kembali</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=edit&id=<?= $id; ?>" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label class="col-sm-3">Nama Produk</label>
                                            <input type="text" class="form-control col-sm-9" value="<?= $hasil['nama_produk']; ?>" name="nama_produk" placeholder="Isi Nama Produk">
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Kategori</label>
                                            <select class="form-control col-sm-9" name="id_kategori">
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                <?php
                                                $sql_kategori = "SELECT * FROM kategori";
                                                $row_kategori = $koneksi->prepare($sql_kategori);
                                                $row_kategori->execute();
                                                $hasil_kategori = $row_kategori->fetchAll();

                                                foreach ($hasil_kategori as $kategori) {
                                                    if ($kategori['id_kategori'] == $hasil['id_kategori']) {
                                                        echo '<option value="' . $kategori['id_kategori'] . '" selected>' . $kategori['nama_kategori'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $kategori['id_kategori'] . '">' . $kategori['nama_kategori'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Harga</label>
                                            <input type="text" class="form-control col-sm-9" value="<?= $hasil['harga']; ?>" name="harga" placeholder="Isi Harga">
                                        </div>

                                    </div>

                                    <div class="col-sm-6">

                                        <div class="form-group row">
                                            <label class="col-sm-3">Status</label>
                                            <select class="form-control col-sm-9" name="status">
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option <?php if ($hasil['status'] == 'PO') {
                                                            echo 'selected';
                                                        } ?>>PO</option>
                                                <option <?php if ($hasil['status'] == 'Tidak PO') {
                                                            echo 'selected';
                                                        } ?>>Tidak PO</option>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3">Gambar</label>
                                            <input type="file" accept="image/*" class="form-control col-sm-9" name="gambar" placeholder="Isi Gambar">

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3">Penampakan</label>
                                            <img src="../assets/image/<?php echo $hasil['gambar']; ?>" class="img-fluid" style="width:150px;">
                                        </div>
                                        <input type="hidden" value="<?= $hasil['gambar']; ?>" name="gambar_cek">
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
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
$title_web = 'Edit Kategori'; // Ubah judul halaman menjadi "Edit Kategori"
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
$id = $_GET['id'];

$sql = "SELECT * FROM kategori WHERE id_kategori =  ?";
$row = $koneksi->prepare($sql);
$row->execute(array($id));

$hasil = $row->fetch();
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Kategori</h1> <!-- Ubah judul halaman menjadi "Edit Kategori" -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= $url ?>admin/kategori/kategori.php">Daftar Kategori</a></li> <!-- Ubah link menuju daftar kategori -->
                <li class="breadcrumb-item active">Edit Kategori</li> <!-- Ubah teks menjadi "Edit Kategori" -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary mb-4">
                        <h4 class="card-title text-light">
                            Edit Kategori - <?= $hasil['nama_kategori']; ?> <!-- Ubah teks menjadi "Edit Kategori" -->
                            <div class="float-right">
                                <a class="btn btn-warning" href="kategori.php" role="button">Kembali</a> <!-- Ubah link kembali ke daftar kategori -->
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=edit&id=<?= $id; ?>" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group row">
                                            <label class="col-sm-3">Nama Kategori</label> <!-- Ubah label menjadi "Nama Kategori" -->
                                            <input type="text" class="form-control col-sm-9" value="<?= $hasil['nama_kategori']; ?>" name="nama_kategori" placeholder="Isi Nama Kategori"> <!-- Ganti input dengan value dari "nama_kategori" -->
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
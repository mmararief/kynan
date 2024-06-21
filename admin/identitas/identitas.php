<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : produk.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Identitas';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
$sql = "SELECT * FROM identitas WHERE id = 1";
$row = $koneksi->prepare($sql);
$row->execute();
$edit = $row->fetch(PDO::FETCH_OBJ);


$hasil = $row->fetch();
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Ubah Identitas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Identitas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary mb-4">
                        <h4 class="card-title text-light">
                            Edit Identitas
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=edit&id=1" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Logo Saat ini</label><br>
                                        <img style="background-size: cover; object-fit: cover;overflow: hidden;border:2px solid #eee;width: 100px;height: 100px;" class="rounded" src="../../assets/img/logo/<?= $info_web->logo; ?>">
                                        <br /><label>Ganti Logo Saat ini</label>
                                        <br /><input type="file" multiple accept='image/*' id="exampleInputFile" name="gambar">
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            bsCustomFileInput.init();
                                        });
                                        var uploadField = document.getElementById("exampleInputFile");
                                        uploadField.onchange = function() {
                                            if (this.files[0].size > 500000) { // ini untuk ukuran 800KB, 1000000 untuk 1 MB.
                                                swal("Maaf. File Terlalu Besar ! Maksimal Upload 500 KB");
                                                this.value = "";
                                            };
                                        };
                                    </script>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Nama Aplikasi/Toko </label>
                                        <input type="text" class="form-control" name='title' value="<?= $info_web->title; ?>" required="true">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Nama Pemilik </label>
                                        <input type="text" class="form-control" placeholder="Diva" name="an" value="<?= $info_web->an; ?>" required="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Nomor Handphone </label>
                                        <input type="text" class="form-control" name="hp" value="<?= $info_web->hp; ?>" required="true">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Alamat Email </label>
                                        <input type="email" class="form-control" placeholder="" name="email" value="<?= $info_web->email; ?>" required="true">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Alamat Toko </label>
                                        <textarea class="form-control" name="alamat" rows="7" required="true"><?= $info_web->alamat; ?></textarea>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Alamat Toko Gmap </label>
                                        <textarea class="form-control" name="map" rows="7" required="true"><?= $info_web->map; ?></textarea>
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
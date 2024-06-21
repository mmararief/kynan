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
        <h1>Ubah Sosial Media</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Sosial Media</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary mb-4">
                        <h4 class="card-title text-light">
                            Edit Info Sosial Media
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form method="post" action="proses.php?aksi=edit&id=1" enctype="multipart/form-data">

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <center>
                                            <h1 style="background-size: cover; object-fit: cover;overflow: hidden;border:2px solid #eee;width: 80px;padding: 5px;" class="rounded"><i class="ri-whatsapp-fill"></i></h1>
                                        </center>
                                        <label>Link/url Whatsapp:</label>
                                        <input type="text" class="form-control" name='ig' value="<?= $info_web->wa; ?>" required="true">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <center>
                                            <h1 style="background-size: cover; object-fit: cover;overflow: hidden;border:2px solid #eee;width: 80px;padding: 5px;" class="rounded"><i class="ri-instagram-fill"></i></h1>
                                        </center>
                                        <label>Link/url Instagram:</label>
                                        <input type="text" class="form-control" name='ig' value="<?= $info_web->ig; ?>" required="true">
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
    </section>
</main>
<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : background.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Background';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}

if (!empty($_POST['nama_pengguna'])) {
    $data[] =  htmlspecialchars($_POST["nama_pengguna"]);
    $data[] =  htmlspecialchars($_POST["username"]);
    $data[] =  md5($_POST["password"]);
    $data[] =  $_SESSION['USER']['id_login'];
    $sql = "UPDATE login SET nama_pengguna = ?, username = ?, password = ? WHERE id_login = ? ";
    $row = $koneksi->prepare($sql);
    $row->execute($data);
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Update Data Profil Berhasil !",
        }).then(() => {
            window.location.href = "background.php";
        });
    </script>';
    exit;
}

if (!empty($_POST['title'])) {
    $data[] =  htmlspecialchars($_POST["title"]);
    $data[] =  htmlspecialchars($_POST["subtitle"]);
    $data[] =  htmlspecialchars($_POST["prom"]);
    $data[] =  1;
    $sql = "UPDATE landingpage SET title = ?, subtitle = ?, prom = ? WHERE id = ? ";
    $row = $koneksi->prepare($sql);
    $row->execute($data);
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Update Halaman Utama Website Berhasil !",
        }).then(() => {
            window.location.href = "background.php";
        });
    </script>';
    exit;
}

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Ubah Background</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Background</li>
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
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    Profil Admin
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <?php
                                        $id =  $_SESSION["USER"]["id_login"];
                                        $sql = "SELECT * FROM login WHERE id_login = ?";
                                        $row = $koneksi->prepare($sql);
                                        $row->execute(array($id));
                                        $edit_profil = $row->fetch(PDO::FETCH_OBJ);
                                        ?>
                                        <div class="form-group">
                                            <label for="">Nama Pengguna</label>
                                            <input type="text" class="form-control" value="<?= $edit_profil->nama_pengguna; ?>" name="nama_pengguna" id="nama_pengguna" placeholder="" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input type="text" required class="form-control" value="<?= $edit_profil->username; ?>" name="username" id="username" placeholder="" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" required class="form-control" value="" name="password" id="password" placeholder="" />
                                        </div><br>
                                        <button type="submit" class="btn btn-primary">
                                            Simpan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    Halaman Utama
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <?php
                                        $sql = "SELECT * FROM landingpage WHERE id = 1";
                                        $row = $koneksi->prepare($sql);
                                        $row->execute();
                                        $edit = $row->fetch(PDO::FETCH_OBJ);
                                        ?>
                                        <div class="form-group">
                                            <label for="">Judul</label>
                                            <input type="text" class="form-control" value="<?= $edit->title; ?>" name="title" id="nama_pengguna" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sub Judul</label>
                                            <input type="text" class="form-control" value="<?= $edit->subtitle; ?>" name="subtitle" id="username" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Teks Promosi</label>
                                            <input type="text" class="form-control" value="<?= $edit->prom; ?>" name="prom" id="password" />
                                        </div><br>
                                        <button type="submit" class="btn btn-primary">
                                            Simpan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- alert https://sweetalert2.github.io/ -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include '../footer.php'; ?>
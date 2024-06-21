<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : proses.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
</body>

</html>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'koneksi.php';

if ($_GET['id'] == 'login') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ? AND password = md5(?)");

    $row->execute(array($user, $pass));

    $hitung = $row->rowCount();

    if ($hitung > 0) {
        session_start();
        $hasil = $row->fetch();
        $_SESSION['USER'] = $hasil;

        if ($_SESSION['USER']['level'] == 'admin') {
            echo '
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                
                Toast.fire({
                    icon: "success",
                    title: "Login Sukses",
                }).then(() => {
                    window.location.href = "../admin/index.php";
                });
            </script>';
        } else {
            echo '
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                
                Toast.fire({
                    icon: "success",
                    title: "Login Sukses",
                }).then(() => {
                    window.location.href = "../index.php";
                });
            </script>';
        }
    } else {
        echo '
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            
            Toast.fire({
                icon: "error",
                title: "Username atau password salah",
            }).then(() => {
                window.location.href = "../login.php";
            });
        </script>';
    }
}


if ($_GET['id'] == 'daftar') {
    $data[] = $_POST['nama'];
    $data[] = $_POST['user'];
    $data[] = md5($_POST['pass']);
    $data[] = 'pengguna';
    $data[] = $_POST['user'];

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ?");

    $row->execute(array($_POST['user']));

    $hitung = $row->rowCount();

    if ($hitung > 0) {
        echo '
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            
            Toast.fire({
                icon: "error",
                title: "Daftar Gagal, Data Sudah ada",
            }).then(() => {
                history.go(-1);
            });
        </script>';
    } else {

        $sql = "INSERT INTO `login`(`nama_pengguna`, `username`, `password`, `level`)
                VALUES (?,?,?,?)";
        $row = $koneksi->prepare($sql);
        $row->execute($data);
        echo '
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            
            Toast.fire({
                icon: "success",
                title: "Daftar Sukses Silahkan Login",
            }).then(() => {
                history.go(-1);
            });
        </script>';
    }
}



if ($_GET['id'] == 'konfirmasi') {
    $tanggal = date('Y-m-d H:i:s');
    $via = $_POST['via'];
    $nama = $_POST['nama'];
    $whatsapp = $_POST['whatsapp'];
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $metode_pembayaran = $_POST['pembayaran'];
    $total_belanja = $_POST['total_belanja'];
    $status = $_POST['status'];

    $nama_produk_list = [];
    foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
        $stmt = $koneksi->prepare('SELECT nama_produk FROM produk WHERE id_produk = ?');
        $stmt->execute([$id_produk]);
        $produk = $stmt->fetch();
        $nama_produk_list[] = $produk['nama_produk'] . ' x' . $jumlah;
    }
    $nama_produk = implode(', ', $nama_produk_list);

    $stmt = $koneksi->prepare('INSERT INTO konfirmasi (tanggal, via, nama, nama_produk, whatsapp, alamat, metode_pembayaran, jumlah, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$tanggal, $via, $nama, $nama_produk, $whatsapp, $alamat, $metode_pembayaran, $total_belanja, $status]);

    // Hapus keranjang setelah konfirmasi
    unset($_SESSION['keranjang']);

    // Redirect ke halaman terima kasih atau halaman konfirmasi selesai
    header('Location: ../konfirmasi_sukses.php');
    exit();
}

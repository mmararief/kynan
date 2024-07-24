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
        $stmt = $koneksi->prepare('SELECT nama_produk, harga_jual FROM produk WHERE id_produk = ?');
        $stmt->execute([$id_produk]);
        $produk = $stmt->fetch();
        $nama_produk_list[] = [
            'id_produk' => $id_produk,
            'jumlah' => $jumlah,
            'harga' => $produk['harga_jual'],
            'subtotal' => $produk['harga_jual'] * $jumlah,
            'nama_produk' => $produk['nama_produk']
        ];
    }

    // Simpan data ke database
    $stmt = $koneksi->prepare('INSERT INTO transaksi (tanggal, via, nama, whatsapp, alamat, metode_pembayaran, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$tanggal, $via, $nama, $whatsapp, $alamat, $metode_pembayaran, $total_belanja, $status]);
    $id_transaksi = $koneksi->lastInsertId();

    // Simpan detail transaksi
    foreach ($nama_produk_list as $item) {
        $stmt = $koneksi->prepare('INSERT INTO detailtransaksi (id_transaksi, id_produk, jumlah, harga, subtotal) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$id_transaksi, $item['id_produk'], $item['jumlah'], $item['harga'], $item['subtotal']]);
    }

    // Simpan detail pesanan ke dalam sesi
    $_SESSION['order_details'] = [
        'tanggal' => $tanggal,
        'via' => $via,
        'nama' => $nama,
        'nama_produk' => implode(', ', array_map(function ($item) {
            return $item['nama_produk'] . ' x' . $item['jumlah'];
        }, $nama_produk_list)),
        'whatsapp' => $whatsapp,
        'alamat' => $alamat,
        'metode_pembayaran' => $metode_pembayaran,
        'total_belanja' => $total_belanja,
        'status' => $status
    ];

    // Kirim data ke API endpoint Node.js untuk mengirim pesan WhatsApp
    $url = 'http://localhost:8000/order-confirmation';
    $data = [
        'nama' => $nama,
        'whatsapp' => $whatsapp,
        'nama_produk' => implode(', ', array_map(function ($item) {
            return $item['nama_produk'] . ' x' . $item['jumlah'];
        }, $nama_produk_list)),
        'total' => $total_belanja,
        'metode_pembayaran' => $metode_pembayaran,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        echo 'Error sending data to API.';
    }

    // Hapus keranjang setelah konfirmasi
    unset($_SESSION['keranjang']);

    // Redirect ke halaman konfirmasi berhasil
    header('Location: ../konfirmasi_berhasil.php');
    exit();
}
?>
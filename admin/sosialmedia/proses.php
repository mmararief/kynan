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
require '../../koneksi/koneksi.php';
$title_web = 'Identitas';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}

// Pastikan hanya diproses jika metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil link/url Instagram yang dikirimkan dari form
    $ig = $_POST['ig'];

    // Update link/url Instagram dalam database
    $sql = "UPDATE identitas SET ig=? WHERE id=1";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$ig]);

    // Redirect kembali ke halaman sosial media dengan pesan sukses menggunakan alert Swal
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "Sukses!",
                text: "Link Instagram berhasil diperbarui.",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "sosialmedia.php";
                }
            });
          </script>';
} else {
    // Jika metode bukan POST, redirect ke halaman sebelumnya
    header("Location: sosialmedia.php");
    exit();
}
?>
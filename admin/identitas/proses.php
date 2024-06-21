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

// Pastikan data yang dikirimkan menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan dari form
    $logo = $_FILES['gambar']['name'];
    $temp_logo = $_FILES['gambar']['tmp_name'];
    $title = $_POST['title'];
    $an = $_POST['an'];
    $hp = $_POST['hp'];
    $email = $_POST['email'];
    $pajak = $_POST['pajak'];
    $jasa = $_POST['jasa'];
    $alamat = $_POST['alamat'];
    $map = $_POST['map'];

    // Cek apakah ada file logo yang diunggah
    if (!empty($logo)) {
        // Jika ada file logo yang diunggah, proses upload logo baru
        $upload_dir = '../../assets/img/logo/';
        $target_logo = $upload_dir . $logo;
        move_uploaded_file($temp_logo, $target_logo);
    } else {
        // Jika tidak ada file logo yang diunggah, gunakan logo yang sudah ada dalam database
        // Ambil nama logo dari database
        $sql = "SELECT logo FROM identitas WHERE id=1";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $logo = $result['logo'];
    }

    // Update data identitas dalam database
    $sql = "UPDATE identitas SET logo=?, title=?, an=?, hp=?, email=?, pajak=?, jasa=?, alamat=?, map=? WHERE id=1";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$logo, $title, $an, $hp, $email, $pajak, $jasa, $alamat, $map]);

    // Alert Swal untuk memberitahu pengguna bahwa data berhasil diubah
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "Sukses!",
                text: "Data berhasil diubah.",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "identitas.php";
                }
            });
        </script>';
} else {
    // Jika tidak ada data yang dikirimkan melalui metode POST, kembali ke halaman sebelumnya dengan pesan alert
    header("Location: identitas.php?alert=error");
    exit();
}
?>
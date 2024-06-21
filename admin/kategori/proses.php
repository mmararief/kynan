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

if ($_GET['aksi'] == 'tambah') {
    // Periksa apakah data nama_kategori sudah dikirim melalui metode POST
    if (isset($_POST['nama_kategori'])) {
        // Ambil nilai nama_kategori dari form
        $nama_kategori = $_POST['nama_kategori'];
        // Buat data yang akan dimasukkan ke database
        $data = array($nama_kategori, date("j F Y, G:i"));
        // Buat query SQL untuk menambahkan data ke dalam tabel kategori
        $sql = 'INSERT INTO kategori (nama_kategori, tgl_input) VALUES (?, ?)';
        // Persiapkan statement SQL
        $row = $koneksi->prepare($sql);
        // Jalankan statement SQL dengan menggunakan data yang sudah disiapkan
        if ($row->execute($data)) {
            // Jika penambahan data berhasil, tampilkan pesan sukses menggunakan SweetAlert2
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Sukses Tambah Kategori",
                    }).then(() => {
                        window.location = "kategori.php?success=tambah";
                    });
                </script>';
            exit; // Penting untuk menghentikan eksekusi skrip setelah menampilkan alert
        } else {
            // Jika terjadi kesalahan saat menambah data, tampilkan pesan error menggunakan SweetAlert2
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Gagal Tambah Kategori",
                        text: "Terjadi kesalahan saat menambah data.",
                    }).then(() => {
                        window.location = "tambah.php";
                    });
                </script>';
            exit; // Penting untuk menghentikan eksekusi skrip setelah menampilkan alert
        }
    } else {
        // Jika data nama_kategori tidak ditemukan, redirect kembali ke halaman tambah.php
        header('Location: tambah.php');
        exit;
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
    // Jika permintaan adalah untuk mengedit kategori
    $id = $_GET['id_kategori'];
    $nama_kategori = $_POST['nama_kategori']; // Ambil data nama kategori yang baru dari form

    $sql = "UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?";
    $row = $koneksi->prepare($sql);
    $row->execute(array($nama_kategori, $id));

    // Tampilkan alert setelah mengedit kategori
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Sukses Edit Kategori",
        }).then(() => {
            window.location = "kategori.php";
        });
    </script>';
}

if (!empty($_GET['aksi'] == 'hapus')) {
    $id = $_GET['id'];

    $sql = "DELETE FROM kategori WHERE id_kategori = ?";
    $row = $koneksi->prepare($sql);
    $row->execute(array($id));

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Sukses Hapus Kategori",
        }).then(() => {
            window.location = "kategori.php";
        });
    </script>';
}

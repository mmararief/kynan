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

if (!isset($_SESSION)) {
    session_start();
}

if ($_GET['aksi'] == 'tambah') {
    // Check if the necessary data has been sent via POST method
    if (isset($_POST['tanggal'], $_POST['via'], $_POST['nama'], $_POST['nama_produk'], $_POST['whatsapp'], $_POST['alamat'], $_POST['metode_pembayaran'], $_POST['jumlah'])) {
        // Retrieve the values from the form
        $tanggal = $_POST['tanggal'];
        $via = $_POST['via'];
        $nama = $_POST['nama'];
        $nama_produk = $_POST['nama_produk'];
        $whatsapp = $_POST['whatsapp'];
        $alamat = $_POST['alamat'];
        $metode_pembayaran = $_POST['metode_pembayaran'];
        $jumlah = $_POST['jumlah'];

        // Prepare the data for insertion into the database
        $data = array($tanggal, $via, $nama, $nama_produk, $whatsapp, $alamat, $metode_pembayaran, $jumlah);

        // Create SQL query to insert data into the konfirmasi table
        $sql = 'INSERT INTO konfirmasi (tanggal, via, nama, nama_produk, whatsapp, alamat, metode_pembayaran, jumlah) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

        // Prepare the SQL statement
        $stmt = $koneksi->prepare($sql);

        // Execute the SQL statement with the prepared data
        if ($stmt->execute($data)) {
            // Display success message using SweetAlert2
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Sukses Tambah Pesanan",
                    }).then(() => {
                        window.location = "pesanan.php?success=tambah";
                    });
                </script>';
            exit;
        } else {
            // Display error message using SweetAlert2
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Gagal Tambah Pesanan",
                        text: "Terjadi kesalahan saat menambah data.",
                    }).then(() => {
                        window.location = "tambah.php";
                    });
                </script>';
            exit;
        }
    } else {
        // Redirect back to tambah.php if the required data is not found
        header('Location: tambah.php');
        exit;
    }
}

if ($_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];

    $sql = "DELETE FROM konfirmasi WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute(array($id));

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Sukses Hapus Pesanan",
        }).then(() => {
            window.location = "pesanan.php";
        });
    </script>';
    exit;
}

if ($_GET['aksi'] == 'edit') {
    // Retrieve the values from the form
    $id = $_GET['id'];
    $tanggal = $_POST['tanggal'];
    $via = $_POST['via'];
    $nama = $_POST['nama'];
    $nama_produk = $_POST['nama_produk'];
    $whatsapp = $_POST['whatsapp'];
    $alamat = $_POST['alamat'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $jumlah = $_POST['jumlah'];

    $sql = "UPDATE konfirmasi SET tanggal = ?, via = ?, nama = ?, nama_produk = ?, whatsapp = ?, alamat = ?, metode_pembayaran = ?, jumlah = ? WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute(array($tanggal, $via, $nama, $nama_produk, $whatsapp, $alamat, $metode_pembayaran, $jumlah, $id));

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Sukses Edit Pesanan",
        }).then(() => {
            window.location = "pesanan.php";
        });
    </script>';
    exit;
}

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    switch ($aksi) {
        case 'hapus':
            $id = $_GET['id'];
            $sql = "DELETE FROM konfirmasi WHERE id = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;

        case 'selesai':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['id'];
                $tanggal = $_POST['tanggal'];
                $nama_produk = $_POST['nama_produk'];
                $jumlah = $_POST['jumlah'];

                // Insert data into pemasukan table
                $sql_insert = "INSERT INTO pemasukan (tanggal, keterangan, sumber, jumlah) VALUES (?, ?, 'Penjualan', ?)";
                $stmt_insert = $koneksi->prepare($sql_insert);
                $stmt_insert->execute([$tanggal, $nama_produk, $jumlah]);

                if ($stmt_insert) {
                    // Update the status of the order to 'Selesai'
                    $sql_update = "UPDATE konfirmasi SET status = 'Selesai' WHERE id = ?";
                    $stmt_update = $koneksi->prepare($sql_update);
                    $stmt_update->execute([$id]);

                    if ($stmt_update) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to insert data into pemasukan']);
                }
            }
            break;
    }
}
?>
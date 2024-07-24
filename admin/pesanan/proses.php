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
    if (isset($_POST['tanggal'], $_POST['via'], $_POST['nama'], $_POST['whatsapp'], $_POST['metode_pembayaran'], $_POST['status'], $_POST['produk'], $_POST['jumlah'])) {
        // Retrieve the values from the form
        $tanggal = $_POST['tanggal'];
        $via = $_POST['via'];
        $nama = $_POST['nama'];
        $whatsapp = $_POST['whatsapp'];
        $alamat = $_POST['alamat'] ?? null;
        $metode_pembayaran = $_POST['metode_pembayaran'];
        $status = $_POST['status'];
        $produk = $_POST['produk'];
        $jumlah = $_POST['jumlah'];

        // Start the transaction
        $koneksi->beginTransaction();

        try {
            // Insert into the transaksi table
            $sql = 'INSERT INTO transaksi (tanggal, via, nama, whatsapp, alamat, metode_pembayaran, status, total) VALUES (?, ?, ?, ?, ?, ?, ?, 0)';
            $stmt = $koneksi->prepare($sql);
            $stmt->execute([$tanggal, $via, $nama, $whatsapp, $alamat, $metode_pembayaran, $status]);

            // Get the last inserted id_transaksi
            $id_transaksi = $koneksi->lastInsertId();
            $total = 0;

            // Insert into the detailtransaksi table
            for ($i = 0; $i < count($produk); $i++) {
                $id_produk = $produk[$i];
                $jumlah_produk = $jumlah[$i];

                // Get the product price
                $stmt = $koneksi->prepare('SELECT harga_jual FROM produk WHERE id_produk = ?');
                $stmt->execute([$id_produk]);
                $harga_produk = $stmt->fetchColumn();

                $subtotal = $harga_produk * $jumlah_produk;
                $total += $subtotal;

                $stmt = $koneksi->prepare('INSERT INTO detailtransaksi (id_transaksi, id_produk, jumlah, harga, subtotal) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$id_transaksi, $id_produk, $jumlah_produk, $harga_produk, $subtotal]);
            }

            // Update the total in the transaksi table
            $stmt = $koneksi->prepare('UPDATE transaksi SET total = ? WHERE id_transaksi = ?');
            $stmt->execute([$total, $id_transaksi]);

            // Commit the transaction
            $koneksi->commit();

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
        } catch (Exception $e) {
            // Rollback the transaction if there is an error
            $koneksi->rollBack();
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

    // Start the transaction
    $koneksi->beginTransaction();

    try {
        // Delete from detailtransaksi table first
        $sql_detail = "DELETE FROM detailtransaksi WHERE id_transaksi = ?";
        $stmt_detail = $koneksi->prepare($sql_detail);
        $stmt_detail->execute(array($id));

        // Then delete from transaksi table
        $sql_transaksi = "DELETE FROM transaksi WHERE id_transaksi = ?";
        $stmt_transaksi = $koneksi->prepare($sql_transaksi);
        $stmt_transaksi->execute(array($id));

        // Commit the transaction
        $koneksi->commit();

        // Display success message using SweetAlert2
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
    } catch (Exception $e) {
        // Rollback the transaction if there is an error
        $koneksi->rollBack();

        // Display error message using SweetAlert2
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Gagal Hapus Pesanan",
                    text: "Terjadi kesalahan saat menghapus data.",
                }).then(() => {
                    window.location = "pesanan.php";
                });
              </script>';
        exit;
    }
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
            $sql = "DELETE FROM transaksi WHERE id_transaksi = ?";
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

                // Fetch the transaction details
                $sql_transaksi = "SELECT * FROM transaksi WHERE id_transaksi = ?";
                $stmt_transaksi = $koneksi->prepare($sql_transaksi);
                $stmt_transaksi->execute([$id]);
                $hasil_transaksi = $stmt_transaksi->fetch();

                // Fetch the details of the transaction
                $sql_detail = "SELECT d.id_produk, p.nama_produk, d.jumlah, d.harga, d.subtotal
FROM detailtransaksi d
JOIN produk p ON d.id_produk = p.id_produk
WHERE d.id_transaksi = ?";
                $stmt_detail = $koneksi->prepare($sql_detail);
                $stmt_detail->execute([$id]);
                $detail_transaksi = $stmt_detail->fetchAll();

                // Update the transaction status
                $sql_update = "UPDATE transaksi SET status = 'Selesai' WHERE id_transaksi = ?";
                $stmt_update = $koneksi->prepare($sql_update);
                $stmt_update->execute([$id]);

                if ($stmt_update) {
                    // Prepare detailed data for API request
                    $data = [
                        'id' => $id,
                        'via' => $hasil_transaksi['via'],
                        'nama' => $hasil_transaksi['nama'],
                        'tanggal' => $hasil_transaksi['tanggal'],
                        'whatsapp' => $hasil_transaksi['whatsapp'],
                        'alamat' => $hasil_transaksi['alamat'],
                        'metode_pembayaran' => $hasil_transaksi['metode_pembayaran'],
                        'status' => 'Selesai',
                        'total' => $hasil_transaksi['total'],
                        'details' => array_map(function ($item) {
                            return [
                                'nama_produk' => $item['nama_produk'],
                                'jumlah' => $item['jumlah'],
                                'harga_satuan' => $item['harga'],
                                'subtotal' => $item['subtotal']
                            ];
                        }, $detail_transaksi)
                    ];

                    // Send the data to the API
                    $url = 'http://localhost:8000/send-invoice';
                    $options = [
                        'http' => [
                            'header' => "Content-type: application/json\r\n",
                            'method' => 'POST',
                            'content' => json_encode($data),
                        ],
                    ];
                    $context = stream_context_create($options);
                    $result = file_get_contents($url, false, $context);

                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            }
            break;
    }
}

?>
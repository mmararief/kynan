<?php
session_start();
require 'koneksi/koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
unset($_SESSION['order_details']);
// Check if id_transaksi is set
if (!isset($_GET['id_transaksi'])) {
    header('Location: index.php');
    exit();
}

$id_transaksi = $_GET['id_transaksi'];

// Fetch order details from the database based on id_transaksi
function fetchOrderDetailsFromDatabase($id_transaksi, $koneksi)
{
    $sql = "SELECT t.*, dt.*, p.nama_produk, p.harga_jual, p.gambar 
            FROM transaksi t
            LEFT JOIN detailtransaksi dt ON t.id_transaksi = dt.id_transaksi
            LEFT JOIN produk p ON dt.id_produk = p.id_produk
            WHERE t.id_transaksi = :id_transaksi";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id_transaksi', $id_transaksi);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$order_details = fetchOrderDetailsFromDatabase($id_transaksi, $koneksi);

// Check if order details are found
if (!$order_details) {
    echo "<p>Order details not found. Please try again.</p>";
    exit();
}

// Format the order details to include all transaction details
$main_order = $order_details[0];
$main_order['detailtransaksi'] = array_map(function ($item) {
    return [
        'id_detail' => $item['id_detail'],
        'id_transaksi' => $item['id_transaksi'],
        'id_produk' => $item['id_produk'],
        'jumlah' => $item['jumlah'],
        'harga' => $item['harga'],
        'subtotal' => $item['subtotal'],
        'nama_produk' => $item['nama_produk'],
        'harga_jual' => $item['harga_jual'],
        'gambar' => $item['gambar']
    ];
}, $order_details);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Terima Kasih!</h1>
                <p class="card-text text-center">Pembayaran Anda telah berhasil dikonfirmasi.</p>
                <p class="card-text text-center">Kami akan segera mengirim faktur pemesanan ke nomer anda.</p>
                <hr>
                <h4 class="card-title">Detail Pesanan</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <td><?php echo htmlspecialchars($main_order['tanggal']); ?></td>
                    </tr>
                    <tr>
                        <th>Via</th>
                        <td><?php echo htmlspecialchars($main_order['via']); ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?php echo htmlspecialchars($main_order['nama']); ?></td>
                    </tr>
                    <tr>
                        <th>WhatsApp</th>
                        <td><?php echo htmlspecialchars($main_order['whatsapp']); ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo htmlspecialchars($main_order['alamat']); ?></td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td><?php echo htmlspecialchars($main_order['metode_pembayaran']); ?></td>
                    </tr>
                    <tr>
                        <th>Total Belanja</th>
                        <td><?php echo htmlspecialchars($main_order['total']); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php echo htmlspecialchars($main_order['status']); ?></td>
                    </tr>
                </table>

                <h4 class="card-title">Detail Transaksi</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($main_order['detailtransaksi'] as $detail) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($detail['id_produk']); ?></td>
                                <td><?php echo htmlspecialchars($detail['nama_produk']); ?></td>
                                <td><?php echo htmlspecialchars($detail['jumlah']); ?></td>
                                <td><?php echo htmlspecialchars($detail['harga']); ?></td>
                                <td><?php echo htmlspecialchars($detail['subtotal']); ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="text-center">
                    <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>

</html>
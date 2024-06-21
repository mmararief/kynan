<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

$total_belanja = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f6f6f6;
        }

        .text-darkblue {
            color: #1d4f88;
        }

        .text-darkgray {
            color: #44444c;
        }

        .bg-aqua {
            background-color: #ecf0f9;
        }

        #qr-dana {
            display: none;
            margin-top: 15px;
        }

        .empty-cart {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
            font-size: 32px;
            color: #44444c;
            text-align: center;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <br>
    <section class="clean-block clean-cart dark">
        <div class="container">
            <?php
            if (empty($_SESSION['keranjang'])) {
                echo "<div class='empty-cart'><h2>Keranjang Belanja Kosong</h2></div>";
                include 'footer.php';
                exit;
            }

            $total_belanja = 0;
            ?>
            <p class="text-center my-4 fs-2 text-darkgray h1">Konfirmasi Pesanan</p>
            <p class="text-center my-4 fs-2 text-darkgray h6">Staf kami akan menghubungi Anda setelah mengisi data diri dibawah.</p>
            <div class="card mb-3 border-0 rounded-0 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="text-darkblue">Daftar Produk yang Dipesan</h2>
                            <hr>
                            <ul class="list-group">
                                <?php
                                foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                                    $stmt = $koneksi->prepare('SELECT * FROM produk WHERE id_produk = ?');
                                    $stmt->execute([$id_produk]);
                                    $produk = $stmt->fetch();

                                    $total_harga = $produk['harga'] * $jumlah;
                                    $total_belanja += $total_harga;
                                    $nama_produk_jumlah = $produk['nama_produk'] . ' x' . $jumlah;
                                ?>
                                    <li class="d-flex justify-content-between align-items-center h3">
                                        <?php echo $nama_produk_jumlah; ?>
                                        <span>Rp <?php echo number_format($total_harga); ?></span>
                                    </li>
                                    <input type="hidden" name="produk[]" value="<?php echo $nama_produk_jumlah; ?>">
                                <?php
                                }
                                ?>
                            </ul>
                            <hr>
                            <div class="mt-3 text-right">
                                <h2 class="text-darkblue">Total Harga Produk: Rp <?php echo number_format($total_belanja); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <h2 class="text-darkblue">Data Diri</h2>
                            <form id="orderForm" action="koneksi/proses.php?id=konfirmasi" method="POST">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="via" name="via" value="Online">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="whatsapp">Nomor WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="62" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat (Opsional)</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                </div>
                                <div class="form-group">
                                    <label for="pembayaran">Metode Pembayaran</label>
                                    <select class="form-control" id="pembayaran" name="pembayaran" required>
                                        <?php
                                        $stmt = $koneksi->query('SELECT * FROM rekening');
                                        while ($row = $stmt->fetch()) {
                                            echo "<option value='{$row['nama_bank']} - {$row['no_rekening']} - {$row['nama_pemilik']}'>{$row['nama_bank']} - {$row['no_rekening']} - {$row['nama_pemilik']}</option>";
                                        }
                                        ?>
                                        <option value="QR Dana">QR Dana</option>
                                    </select>
                                </div>
                                <input type="hidden" name="total_belanja" value="<?php echo $total_belanja; ?>">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="status" name="status" value="Proses">
                                </div>
                                <div id="qr-dana">
                                    <p>Silakan scan kode QR berikut untuk pembayaran melalui Dana:</p>
                                    <img src="assets/img/qrcode/qr.jpg" alt="QR Dana" class="img-fluid">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Konfirmasi Pesanan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('pembayaran').addEventListener('change', function() {
            var qrDana = document.getElementById('qr-dana');
            if (this.value === 'QR Dana') {
                qrDana.style.display = 'block';
            } else {
                qrDana.style.display = 'none';
            }
        });

        $(document).ready(function() {
            $('#whatsapp').on('input', function() {
                // Ensure input is numeric and starts with "62"
                this.value = this.value.replace(/[^0-9]/g, '');
                if (!this.value.startsWith('62')) {
                    this.value = '62';
                }
            });
        });
    </script>

</body>

</html>

<?php include 'footer.php'; ?>
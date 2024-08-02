<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';
$id = strip_tags($_GET['id']);
$hasil = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id'")->fetch();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .product-image {
            object-fit: cover;
            width: 100%;
            height: 400px;
        }

        .product-title {
            font-size: 2rem;
            font-weight: bold;
        }

        .product-price {
            font-size: 1.5rem;
            color: #007bff;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        .btn-container a {
            margin-left: 10px;
        }

        .product-description {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <br><br><br>


    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="admin/assets/image/<?php echo htmlspecialchars($hasil['gambar'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($hasil['merk'], ENT_QUOTES, 'UTF-8'); ?>" class="product-image img-thumbnail">
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="product-title"><?php echo htmlspecialchars($hasil['merk'], ENT_QUOTES, 'UTF-8'); ?></h4>
                        <p class="product-description">
                            <strong>Deskripsi:</strong>
                            <?php echo nl2br(htmlspecialchars($hasil['deskripsi'], ENT_QUOTES, 'UTF-8')); ?>
                        </p>
                        <ul class="list-group list-group-flush">
                            <?php if ($hasil['status'] == 'PO') { ?>
                                <li class="list-group-item bg-danger text-white">
                                    <i class="fa fa-clock"></i> Pre-Order
                                </li>
                            <?php } else { ?>
                                <li class="list-group-item bg-primary text-white">
                                    <i class="fa fa-check"></i> Tidak Pre-Order
                                </li>
                            <?php } ?>
                            <li class="list-group-item bg-dark text-white">
                                <i class="fa fa-money"></i> Rp. <?php echo number_format($hasil['harga_jual']); ?>
                            </li>
                        </ul>
                        <div class="btn-container mt-4">
                            <form id="form_<?php echo $hasil['id_produk']; ?>">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="jumlah_<?php echo $hasil['id_produk']; ?>" name="jumlah" value="1" min="1">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success tambah-ke-keranjang" data-id="<?php echo $hasil['id_produk']; ?>"><i class="fa fa-cart-plus"></i> Tambah ke Keranjang</button>
                                    </div>
                                </div>
                                <input type="hidden" name="id_produk" value="<?php echo $hasil['id_produk']; ?>">
                            </form>
                            <a href="produk.php" class="btn btn-info">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.tambah-ke-keranjang').forEach(button => {
            button.addEventListener('click', function() {
                const id_produk = this.getAttribute('data-id');
                const form = document.getElementById(`form_${id_produk}`);
                const formData = new FormData(form);
                formData.append('tambah_ke_keranjang', '1');

                fetch('tambah_keranjang.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            refreshHeader();
                            refreshFooter();
                        } else {
                            alert(data.pesan);
                        }
                    })
                    .catch(error => {
                        console.error('There has been a problem with your fetch operation:', error);
                    });
            });
        });

        function refreshHeader() {
            fetch('header.php')
                .then(response => response.text())
                .then(html => {
                    document.querySelector('header').innerHTML = html;
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }

        function refreshFooter() {
            fetch('mobile_popup.php', {
                    cache: 'no-store'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;

                    const newFloatingIcons = tempDiv.querySelector('.cart-float');
                    if (newFloatingIcons) {
                        const oldFloatingIcons = document.querySelector('.cart-float');
                        if (oldFloatingIcons) {
                            oldFloatingIcons.innerHTML = newFloatingIcons.innerHTML;
                        } else {
                            document.body.appendChild(newFloatingIcons);
                        }
                    } else {
                        console.error('No floating icons container found in the fetched HTML.');
                    }
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }
    </script>
</body>

</html>
<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

// Handle search query based on category
$categories = $koneksi->query('SELECT * FROM kategori')->fetchAll();

// Handle search query
if (isset($_GET['cari'])) {
    $cari = strip_tags($_GET['cari']);
    $kategori = isset($_GET['category']) ? $_GET['category'] : '';
    if (!empty($kategori)) {
        $query = $koneksi->query('SELECT p.*, k.nama_kategori 
                                  FROM produk p 
                                  JOIN kategori k ON p.id_kategori = k.id_kategori 
                                  WHERE (p.nama_produk LIKE "%' . $cari . '%" OR k.nama_kategori LIKE "%' . $cari . '%") 
                                  AND p.id_kategori = ' . $kategori . ' 
                                  ORDER BY p.id_produk DESC')->fetchAll();
    } else {
        $query = $koneksi->query('SELECT p.*, k.nama_kategori 
                                  FROM produk p 
                                  JOIN kategori k ON p.id_kategori = k.id_kategori 
                                  WHERE p.nama_produk LIKE "%' . $cari . '%" OR k.nama_kategori LIKE "%' . $cari . '%" 
                                  ORDER BY p.id_produk DESC')->fetchAll();
    }
} else {
    $kategori = isset($_GET['category']) ? $_GET['category'] : '';
    if (!empty($kategori)) {
        $query = $koneksi->query('SELECT p.*, k.nama_kategori 
                                  FROM produk p 
                                  JOIN kategori k ON p.id_kategori = k.id_kategori 
                                  WHERE p.id_kategori = ' . $kategori . ' 
                                  ORDER BY p.id_produk DESC')->fetchAll();
    } else {
        $query = $koneksi->query('SELECT p.*, k.nama_kategori 
                                  FROM produk p 
                                  JOIN kategori k ON p.id_kategori = k.id_kategori 
                                  ORDER BY p.id_produk DESC')->fetchAll();
    }
}

$per_page = 16;
$total_items = count($query);
$total_pages = ceil($total_items / $per_page);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $total_pages));
$start = ($page - 1) * $per_page;
$query_paginated = array_slice($query, $start, $per_page);

// Simpan nilai kategori dan harga dalam parameter URL saat mengganti halaman
$query_params = $_GET;
unset($query_params['page']); // Hapus parameter page jika ada

$pagination_link = 'produk.php?' . http_build_query($query_params);
$pagination_link_page = $pagination_link . (empty($query_params) ? '' : '&') . 'page=';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Produk</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .card {
            height: 400px;
            position: relative;
        }

        .card img {
            object-fit: cover;
            height: 200px;
        }

        .btn-container {
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .btn-outline-primary {
            font-size: 20px;
        }

        .form-control,
        .btn {
            font-size: 20px;
        }

        .form-control.rounded {
            font-size: 20px;
        }

        .custom-select {
            font-size: 20px;
        }

        .list-group-item.bg-outline-secondary {
            font-size: 15px;
        }

        .list-group-item.bg-outline-dark {
            font-size: 12px;
        }

        .card {
        position: relative;
        }

    .card img {
        width: 100%;
        height: auto;
        }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        font-size: 20px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        }

    .card:hover .overlay {
        opacity: 1;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="card-body">
            <div class="card-body" style="position: relative;">
                <img src="assets/img/iklan/kynnannn.png" alt="Daftar Produk" style="width: 100%; height: auto;">
                <h2 class="card-title" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; color: white; font-size: 60px; text-align: center; width: 100%; padding: 0 20px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Daftar Produk</h2>
            </div>
            <div class="card-body">
                <form action="" method="get" class="mb-3">
                    <div class="form-row align-items-center">
                        <!-- Form Cari -->
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="search" name="cari" class="form-control rounded" placeholder="Cari Produk.." aria-label="Search" aria-describedby="search-addon" />
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                                    <a href="produk.php" class="btn btn-outline-primary">Lihat Semua</a>
                                </div>
                            </div>
                        </div>
                        <!-- Form Pilih Kategori -->
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="custom-select" id="category" name="category">
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?php echo $category['id_kategori']; ?>" <?php if (isset($_GET['category']) && $_GET['category'] == $category['id_kategori']) echo 'selected'; ?>><?php echo $category['nama_kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row" id="produk">
                    <!-- Looping untuk Menampilkan Produk -->
                    <?php foreach ($query_paginated as $isi) : ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card h-100">
                                <a href="detail.php?id=<?php echo $isi['id_produk']; ?>" style="position: relative; display: block;">
                                    <img src="admin/assets/image/<?php echo $isi['gambar']; ?>" class="card-img-top" alt="...">
                                    <div class="overlay">Tap to see detail</div>
                                </a>
                                <div class="card-body">
                                    <div class="btn-container">
                                        <div class="btn <?= $isi['status'] == 'PO' ? 'btn-danger' : 'btn-primary' ?> btn-primary btn-sm mt-2 ml-2">
                                            <strong><?= $isi['status'] == 'PO' ? 'PO' : 'Tidak PO' ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-outline-secondary"><strong><?php echo $isi['nama_produk']; ?></strong></li>
                                </ul>
                                <hr>
                                <div class="card-body">
                                    <li class="list-group-item bg-outline-dark"><i class=""></i> Kategori: <?php echo $isi['nama_kategori']; ?></li>
                                    <li class="list-group-item bg-outline-dark">
                                        <i class=""></i> Harga: Rp. <?php echo number_format($isi['harga']); ?>
                                    </li>
                                </div>
                                <!-- Form untuk Menambahkan Produk ke Keranjang -->
                                <div class="card-body">
                                    <form id="form_<?php echo $isi['id_produk']; ?>">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="jumlah_<?php echo $isi['id_produk']; ?>" name="jumlah" value="1" min="1">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success tambah-ke-keranjang" data-id="<?php echo $isi['id_produk']; ?>"><i class="fa fa-opencart"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_produk" value="<?php echo $isi['id_produk']; ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1) : ?>
                            <li class="page-item"><a class="page-link" href="<?php echo $pagination_link_page . ($page - 1); ?>">&laquo;</a></li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="<?php echo $pagination_link_page . $i; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($page < $total_pages) : ?>
                            <li class="page-item"><a class="page-link" href="<?php echo $pagination_link_page . ($page + 1); ?>">&raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
    </script>
</body>

</html>
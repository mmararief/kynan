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
<html lang="id">

<head>
    <title>Daftar Produk</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            height: 200px;
            object-fit: cover;
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

        .pagination {
            margin-top: 20px;
        }

        .btn-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .form-control,
        .btn {
            font-size: 16px;
        }

        .form-control.rounded {
            font-size: 16px;
        }

        .custom-select {
            font-size: 16px;
        }

        .list-group-item {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <div class="card mb-4">
            <img src="assets/img/iklan/kynnannn.png" alt="Daftar Produk" class="card-img-top">
            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                <h2 class="card-title text-white font-weight-bold" style="font-size: 48px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Daftar Produk</h2>
            </div>
        </div>

        <form action="" method="get" class="mb-4">
            <div class="form-row align-items-center">
                <div class="col-md-6 mb-3">
                    <div class="input-group">
                        <input type="search" name="cari" class="form-control rounded" placeholder="Cari Produk.." aria-label="Search" aria-describedby="search-addon" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-primary">Cari</button>
                            <a href="produk.php" class="btn btn-outline-primary">Lihat Semua</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
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
            <?php foreach ($query_paginated as $isi) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <a href="detail.php?id=<?php echo $isi['id_produk']; ?>" class="position-relative d-block">
                            <img src="admin/assets/image/<?php echo $isi['gambar']; ?>" class="card-img-top" alt="<?php echo $isi['nama_produk']; ?>">
                            <div class="overlay">Tap to see detail</div>
                        </a>
                        <div class="card-body">
                            <div class="btn-container">
                                <div class="btn <?= $isi['status'] == 'PO' ? 'btn-danger' : 'btn-primary' ?> btn-sm">
                                    <strong><?= $isi['status'] == 'PO' ? 'PO' : 'Tidak PO' ?></strong>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush mt-2">
                                <li class="list-group-item"><strong><?php echo $isi['nama_produk']; ?></strong></li>
                                <li class="list-group-item">Kategori: <?php echo $isi['nama_kategori']; ?></li>
                                <li class="list-group-item">Harga: Rp. <?php echo number_format($isi['harga_jual']); ?></li>
                            </ul>
                            <form id="form_<?php echo $isi['id_produk']; ?>" class="mt-3">
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

                    // Extract the floating icons section from the fetched HTML
                    const newFloatingIcons = tempDiv.querySelector('.cart-float');

                    // Check if the new floating icons section exists
                    if (newFloatingIcons) {
                        const oldFloatingIcons = document.querySelector('.cart-float');
                        if (oldFloatingIcons) {
                            // Update the existing floating icons container
                            oldFloatingIcons.innerHTML = newFloatingIcons.innerHTML;
                        } else {
                            // Append the new icons container if the old one doesn't exist
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
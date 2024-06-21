<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file      : produk.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

// Handle search query based on category
$categories = $koneksi->query('SELECT * FROM kategori')->fetchAll();

// Handle search query
if (isset($_GET['cari'])) {
    $cari = strip_tags($_GET['cari']);
    $kategori = isset($_GET['category']) ? $_GET['category'] : ''; // Ambil nilai kategori yang dipilih
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
    $kategori = isset($_GET['category']) ? $_GET['category'] : ''; // Ambil nilai kategori yang dipilih
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

// Pagination
$per_page = 16;
$total_pages = ceil(count($query) / $per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $per_page;
$query = array_slice($query, $start, $per_page);

// Simpan nilai kategori dan harga dalam parameter URL saat mengganti halaman
$pagination_link = 'produk.php';
if (isset($_GET['category'])) {
    $pagination_link .= '?category=' . $_GET['category'];
}
if (isset($_GET['price'])) {
    $pagination_link .= isset($_GET['category']) ? '&' : '?';
    $pagination_link .= 'price=' . $_GET['price'];
}
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

        /* Perbesar tombol */
        .btn-outline-primary {
            font-size: 20px;
            /* Sesuaikan dengan ukuran yang diinginkan */
        }

        /* Perbesar input dan tombol */
        .form-control,
        .btn {
            font-size: 20px;
            /* Sesuaikan dengan ukuran yang diinginkan */
        }

        /* Perbesar bagian cari dan pilih kategori */
        .form-control.rounded {
            font-size: 20px;
            /* Sesuaikan dengan ukuran yang diinginkan */
        }

        .custom-select {
            font-size: 20px;
            /* Sesuaikan dengan ukuran yang diinginkan */
        }

        /* Perbesar huruf nama produk, kategori, dan harga */
        .list-group-item.bg-outline-secondary {
            font-size: 15px;
            /* Sesuaikan dengan ukuran yang diinginkan */
        }

        /* Perbesar huruf nama produk, kategori, dan harga */
        .list-group-item.bg-outline-dark {
            font-size: 12px;
            /* Sesuaikan dengan ukuran yang diinginkan */
        }
    </style>
</head>
<br>
<br>
<br>

<body>
    <br>
    <br>
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
                <br>
                <br>
                <br>
                <div class="row" id="produk">
                    <!-- Looping untuk Menampilkan Produk -->
                    <?php foreach ($query as $isi) : ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <a href="detail.php?id=<?php echo $isi['id_produk']; ?>">
                                        <img src="admin/assets/image/<?php echo $isi['gambar']; ?>" class="card-img-top" alt="...">
                                        <div class="btn-container">
                                            <div class="btn <?= $isi['status'] == 'PO' ? 'btn-danger' : 'btn-primary' ?> btn-primary btn-sm mt-2 ml-2"><strong><?= $isi['status'] == 'PO' ? 'PO' : 'Tidak PO' ?></strong></div>
                                        </div>
                                    </a>
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-outline-secondary"><strong><?php echo $isi['nama_produk']; ?></strong></li>
                                </ul>
                                <hr>
                                <div class="card-body">
                                    <li class="list-group-item bg-outline-dark"><i class=""></i> Kategory: <?php echo $isi['nama_kategori']; ?></li>
                                    <li class="list-group-item bg-outline-dark">
                                        <i class=""></i> Harga: Rp. <?php echo number_format($isi['harga']); ?>
                                    </li>
                                    <br>
                                </div>
                                <!-- Form untuk Menambahkan Produk ke Keranjang -->
                                <div class="card-body">
                                    <form action="keranjang.php" method="post">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="jumlah_<?php echo $isi['id_produk']; ?>" name="jumlah" value="1" min="1">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-success" name="tambah_ke_keranjang"><i class="fa fa-opencart"></i></button>
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
                            <li class="page-item"><a class="page-link" href="<?php echo $pagination_link . '&page=' . ($page - 1); ?>">
                                    &laquo; </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="<?php echo $pagination_link . '&page=' . $i; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($page < $total_pages) : ?>
                            <li class="page-item"><a class="page-link" href="<?php echo $pagination_link . '&page=' . ($page + 1); ?>">&raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>

    <?php include 'footer.php'; ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
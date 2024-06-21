<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

// Cek apakah produk perlu dihapus dari keranjang
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $id_produk = $_GET['id_produk'];
  if (isset($_SESSION['keranjang'][$id_produk])) {
    unset($_SESSION['keranjang'][$id_produk]);
    $_SESSION['pesan'] = "Produk berhasil dihapus dari keranjang.";
  } else {
    $_SESSION['pesan'] = "Produk tidak ditemukan di keranjang.";
  }
  header("Location: keranjang.php");
  exit;
}

// Cek apakah tombol "Add to Cart" diklik
if (isset($_POST['tambah_ke_keranjang'])) {
  if (isset($_POST['jumlah']) && isset($_POST['id_produk'])) {
    $jumlah = $_POST['jumlah'];
    $id_produk = $_POST['id_produk'];

    if ($jumlah > 0) {
      if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = array();
      }

      if (array_key_exists($id_produk, $_SESSION['keranjang'])) {
        $_SESSION['keranjang'][$id_produk] += $jumlah;
      } else {
        $_SESSION['keranjang'][$id_produk] = $jumlah;
      }

      $_SESSION['pesan'] = "Produk berhasil ditambahkan ke keranjang.";
    } else {
      $_SESSION['pesan'] = "Jumlah tidak valid.";
    }
  } else {
    $_SESSION['pesan'] = "Data tidak lengkap.";
  }

  header("Location: keranjang.php");
  exit;
}

// Cek apakah form update keranjang dikirim via AJAX
if (isset($_POST['update_keranjang'])) {
  $id_produk = $_POST['id_produk'];
  $jumlah = $_POST['jumlah'];

  if ($jumlah > 0) {
    $_SESSION['keranjang'][$id_produk] = $jumlah;
  } else {
    unset($_SESSION['keranjang'][$id_produk]);
  }

  // Menghitung total belanja setelah update
  $total_belanja = 0;
  foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
    $stmt = $koneksi->prepare('SELECT harga FROM produk WHERE id_produk = ?');
    $stmt->execute([$id_produk]);
    $produk = $stmt->fetch();
    $total_belanja += $produk['harga'] * $jumlah;
  }

  echo json_encode(['total_belanja' => number_format($total_belanja, 0, ',', '.')]);
  exit;
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
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
      <h2 class="text-center my-4 fs-2 text-darkgray">Keranjang</h2>
      <div class="card mb-3 border-0 rounded-0 shadow-sm">
        <div class="row g-0 align-items-center">
          <div class="col-md-8">
            <div class="card-body">
              <?php
              foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                $stmt = $koneksi->prepare('SELECT * FROM produk WHERE id_produk = ?');
                $stmt->execute([$id_produk]);
                $produk = $stmt->fetch();

                $total_harga = $produk['harga'] * $jumlah;
                $total_belanja += $total_harga;
              ?>
                <div class="row py-3 px-3 product" data-id="<?php echo $id_produk; ?>" data-harga="<?php echo $produk['harga']; ?>">
                  <div class="col-md-3">
                    <img class="img-thumbnail" width="170px" src="admin/assets/image/<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['nama_produk']; ?>" />
                  </div>
                  <div class="col-md-9 d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <div class="d-flex align-items-center">
                        <h5 class="text-darkblue"><?php echo $produk['nama_produk']; ?></h5>
                        <button class="btn btn-danger btn-sm mx-2 delete-product" data-id="<?php echo $id_produk; ?>">
                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div class="d-flex align-items-center">
                        <input type="number" class="form-control mx-5 quantity" value="<?php echo $jumlah; ?>" min="1" required style="width: 50px" />
                        <h5 class="text-darkgray fw-bold text-md-end harga">Rp <?php echo number_format($total_harga); ?></h5>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <p class="text-darkblue h3 my-5">RINGKASAN</p>
            <div class="px-4">
              <div class="d-flex justify-content-between align-items-center bg-light px-4 pt-3 border-top border-primary">
                <p class="text-start text-primary fw-bold h4">Total</p>
                <p class="text-end text-primary total-belanja h4">Rp <?php echo number_format($total_belanja); ?></p>
              </div>
              <div class="d-grid gap-2 col-12 mx-auto">
                <button class="btn btn-primary btn-lg my-4" id="pesan-button">Pesan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    function updateTotalBelanja() {
      let totalBelanja = 0;
      document.querySelectorAll('.product').forEach(productRow => {
        const hargaSatuan = parseFloat(productRow.getAttribute('data-harga'));
        const jumlah = parseInt(productRow.querySelector('.quantity').value);
        totalBelanja += hargaSatuan * jumlah;
      });
      document.querySelector('.total-belanja').textContent = 'Rp ' + totalBelanja.toLocaleString('id-ID');
    }

    document.querySelectorAll('.quantity').forEach(input => {
      input.addEventListener('change', function() {
        const productRow = this.closest('.product');
        const id_produk = productRow.getAttribute('data-id');
        const hargaSatuan = parseFloat(productRow.getAttribute('data-harga'));
        const jumlah = parseInt(this.value);
        const totalHarga = hargaSatuan * jumlah;

        productRow.querySelector('.harga').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');

        // Perbarui total belanja di sisi klien
        updateTotalBelanja();

        // Kirim perubahan jumlah ke server dengan AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'keranjang.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log(response); // Tambahkan log untuk memeriksa respons
          }
        };
        xhr.send('update_keranjang=1&id_produk=' + id_produk + '&jumlah=' + jumlah);
      });
    });

    document.querySelectorAll('.delete-product').forEach(button => {
      button.addEventListener('click', function() {
        const id_produk = this.getAttribute('data-id');
        if (confirm('Apakah Anda ingin menghapus produk ini dari keranjang?')) {
          window.location.href = `keranjang.php?action=delete&id_produk=${id_produk}`;
        }
      });
    });

    document.getElementById('pesan-button').addEventListener('click', function() {
      window.location.href = 'konfirmasi.php';
    });
  </script>

</body>

</html>

<?php include 'footer.php'; ?>
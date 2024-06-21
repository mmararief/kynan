<?php
session_start();

// Jika tombol Tambah ke Keranjang ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_ke_keranjang'])) {
    // Pastikan variabel jumlah dan id_produk terdefinisi
    if (isset($_POST['jumlah']) && isset($_POST['id_produk'])) {
        // Ambil nilai jumlah dan id_produk dari form
        $jumlah = $_POST['jumlah'];
        $id_produk = $_POST['id_produk'];

        // Pastikan nilai jumlah adalah angka positif
        if ($jumlah > 0) {
            // Inisialisasi keranjang belanja jika belum ada
            if (!isset($_SESSION['keranjang'])) {
                $_SESSION['keranjang'] = array();
            }

            // Cek apakah produk sudah ada di keranjang
            if (array_key_exists($id_produk, $_SESSION['keranjang'])) {
                // Jika sudah ada, tambahkan jumlahnya
                $_SESSION['keranjang'][$id_produk] += $jumlah;
            } else {
                // Jika belum ada, tambahkan produk ke keranjang dengan jumlah yang diminta
                $_SESSION['keranjang'][$id_produk] = $jumlah;
            }

            // Set pesan sukses
            $_SESSION['pesan'] = "Produk berhasil ditambahkan ke keranjang.";
        } else {
            // Set pesan error jika jumlah tidak valid
            $_SESSION['pesan'] = "Jumlah tidak valid.";
        }
    } else {
        // Set pesan error jika data tidak lengkap
        $_SESSION['pesan'] = "Data tidak lengkap.";
    }

    // Redirect ke halaman sebelumnya atau halaman produk
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
        header("Location: produk.php");
    }
} else {
    // Jika tidak ada permintaan untuk menambahkan ke keranjang, redirect ke halaman produk
    header("Location: produk.php");
}

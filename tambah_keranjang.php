<?php
session_start();
require 'koneksi/koneksi.php';

// Cek apakah permintaan datang dari fetch (AJAX)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_ke_keranjang'])) {
    // Pastikan variabel jumlah dan id_produk terdefinisi
    if (isset($_POST['jumlah']) && isset($_POST['id_produk'])) {
        // Ambil nilai jumlah dan id_produk dari form
        $jumlah = intval($_POST['jumlah']); // Pastikan jumlah adalah integer
        $id_produk = intval($_POST['id_produk']); // Pastikan id_produk adalah integer

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

            // Menghitung total belanja setelah update
            $total_belanja = 0;
            foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                $stmt = $koneksi->prepare('SELECT harga FROM produk WHERE id_produk = ?');
                $stmt->execute([$id_produk]);
                $produk = $stmt->fetch();
                $total_belanja += $produk['harga'] * $jumlah;
            }

            // Keluarkan respons JSON
            echo json_encode([
                'status' => 'success',
                'total_belanja' => number_format($total_belanja, 0, ',', '.'),
                'pesan' => 'Produk berhasil ditambahkan ke keranjang!'
            ]);

            header("refresh:0;url=header.php");
            exit;
        } else {
            // Keluarkan respons JSON untuk error jumlah tidak valid
            echo json_encode([
                'status' => 'error',
                'pesan' => 'Jumlah tidak valid.'
            ]);
        }
    } else {
        // Keluarkan respons JSON untuk data tidak lengkap
        echo json_encode([
            'status' => 'error',
            'pesan' => 'Data tidak lengkap.'
        ]);
    }
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah mengeluarkan JSON
} else {
    // Jika tidak ada permintaan untuk menambahkan ke keranjang, keluarkan pesan kesalahan
    echo json_encode([
        'status' => 'error',
        'pesan' => 'Permintaan tidak valid.'
    ]);
    exit; // Pastikan untuk menghentikan eksekusi skrip
}
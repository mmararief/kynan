<?php
session_start();
require 'koneksi/koneksi.php';

// Handle AJAX cart update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_keranjang'])) {
        $id_produk = intval($_POST['id_produk']);
        $jumlah = intval($_POST['jumlah']);

        if ($jumlah > 0) {
            $_SESSION['keranjang'][$id_produk] = $jumlah;
        } else {
            unset($_SESSION['keranjang'][$id_produk]);
        }

        // Calculate total cost
        $total_belanja = 0;
        foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
            $stmt = $koneksi->prepare('SELECT harga_jual FROM produk WHERE id_produk = ?');
            $stmt->execute([$id_produk]);
            $produk = $stmt->fetch();
            $total_belanja += $produk['harga_jual'] * $jumlah;
        }

        echo json_encode([
            'status' => 'success',
            'total_belanja' => number_format($total_belanja, 0, ',', '.')
        ]);
        exit;
    } elseif (isset($_POST['tambah_ke_keranjang'])) {
        $id_produk = intval($_POST['id_produk']);
        $jumlah = intval($_POST['jumlah']);

        if ($jumlah > 0) {
            $_SESSION['keranjang'][$id_produk] = $jumlah;
        } else {
            unset($_SESSION['keranjang'][$id_produk]);
        }

        // Calculate total cost
        $total_belanja = 0;
        foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
            $stmt = $koneksi->prepare('SELECT harga_jual FROM produk WHERE id_produk = ?');
            $stmt->execute([$id_produk]);
            $produk = $stmt->fetch();
            $total_belanja += $produk['harga_jual'] * $jumlah;
        }

        echo json_encode([
            'status' => 'success',
            'total_belanja' => number_format($total_belanja, 0, ',', '.')
        ]);
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_produk = intval($_GET['id_produk']);
    if (isset($_SESSION['keranjang'][$id_produk])) {
        unset($_SESSION['keranjang'][$id_produk]);
        $_SESSION['pesan'] = "Produk berhasil dihapus dari keranjang.";
    } else {
        $_SESSION['pesan'] = "Produk tidak ditemukan di keranjang.";
    }
    header("Location: keranjang.php");
    exit;
}

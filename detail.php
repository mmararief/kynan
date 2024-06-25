<?php
/*
  | Source Code Aplikasi Rental Mobil PHP & MySQL
  | 
  | @package   : rental_mobil
  | @file	   : detail.php 
  | @author    : faqoy@gmail.com
  | 
  | 
  | 
  | 
 */
session_start();
require 'koneksi/koneksi.php';
include 'header.php';
$id = strip_tags($_GET['id']);
$hasil = $koneksi->query("SELECT * FROM produk WHERE id_produk = '$id'")->fetch();
?>
<br>
<br>
<br>
 <div class="container mt-auto ">
    <div class="row">
        <div class="col-sm-6">
            <img class="card-img-top w-100" style="object-fit:cover;" src="admin\assets\image\<?php echo $hasil['gambar']; ?>" alt="">
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $hasil['merk']; ?></h4>
                    <p class="card-text">
                        Deskripsi :
                        <?php echo $hasil['deskripsi']; ?>
                    </p>
                    <ul class="list-group list-group-flush">
                        <?php if ($hasil['status'] == 'Tersedia') { ?>
                            <li class="list-group-item bg-primary text-white">
                                <i class="fa fa-check"></i> Available
                            </li>
                        <?php } else { ?>
                            <li class="list-group-item bg-danger text-white">
                                <i class="fa fa-close"></i> Not Available
                            </li>
                        <?php } ?>
                        <li class="list-group-item bg-info text-white"><i class="fa fa-check"></i> Free Snack & Drinks</li>
                        <li class="list-group-item bg-dark text-white">
                            <i class="fa fa-money"></i> Rp. <?php echo number_format($hasil['harga']); ?>/ day
                        </li>
                    </ul>
                    <hr />
                    <center>
                    <form id="form_<?php echo $isi['id_produk']; ?>">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="jumlah_<?php echo $hasil['id_produk']; ?>" name="jumlah" value="1" min="1">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success tambah-ke-keranjang" data-id="<?php echo $hasil['id_produk']; ?>"><i class="fa fa-opencart"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_produk" value="<?php echo $hasil['id_produk']; ?>">
                                    </form>
                    <a href="produk.php" class="btn btn-info">Back</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

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
                            alert(data.pesan);
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



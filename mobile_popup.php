<?php
session_start();
require 'koneksi/koneksi.php';

$jumlah_keranjang = isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-Type: text/html');

?>
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .whatsapp-float,
        .cart-float,
        .download-float {
            position: fixed;
            width: 60px;
            height: 60px;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
        }

        .whatsapp-float {
            background-color: #25d366;
            bottom: 140px;
            right: 20px;
        }

        .cart-float {
            bottom: 60px;
            right: 20px;
            background-color: #007bff;
        }

        .download-float {
            background-color: #ff5722;
            bottom: 220px;
            right: 20px;
        }

        .whatsapp-float .whatsapp-icon,
        .cart-float .cart-icon,
        .download-float .download-icon {
            margin-top: 16px;
        }

        .cart-float .cart-badge {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 12px;
            background-color: #dc3545;
        }

        .whatsapp-float:hover {
            background-color: #20b358;
        }

        .cart-float:hover {
            background-color: #007bff;
        }

        .download-float:hover {
            background-color: #e64a19;
        }
    </style>
</head>


<!-- Floating Icons -->
<a href="<?= $info_web->wa; ?>" class="whatsapp-float" data-toggle="tooltip" title="WhatsApp" target="_blank">
    <i class="fa fa-whatsapp whatsapp-icon"></i>
</a>

<a href="sertifikathalal.pdf" download class="download-float" data-toggle="tooltip" title="Unduh Sertifikat Halal">
    <i class="fa fa-download download-icon"></i>
</a>

<a href="keranjang.php" class="cart-float" data-toggle="tooltip" title="Keranjang Belanja">
    <i class="fa fa-shopping-cart cart-icon"></i>
    <span class="cart-badge badge badge-primary"><?= $jumlah_keranjang; ?></span>
</a>

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- SweetAlert -->
<link rel="stylesheet" type="text/css" href="assets/swal/sweetalert.css">
<link rel="stylesheet" href="sweetalert2.min.css">
<script type="text/javascript" src="assets/swal/sweetalert.min.js"></script>
<script src="assets/js/jquery-2.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!-- jQuery -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS -->
<script src="assets/assets2/js/scripts.js"></script>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="assets/vendor/venobox/venobox.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script src="https://cdn.statically.io/gh/lingganovandra/effect/88c3ae71/salju-2.js" type="text/javascript"></script>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
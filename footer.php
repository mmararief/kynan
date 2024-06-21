<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your existing head content -->
    <style>
        /* WhatsApp Icon Styles */
        .whatsapp-float,
        .cart-float {
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
            /* Adjust this value to position the WhatsApp icon higher */
            right: 20px;
        }

        .cart-float {
            bottom: 60px;
            /* Adjust this value to position the Cart icon higher */
            right: 20px;
            background-color: #007bff;
        }

        .whatsapp-float .whatsapp-icon,
        .cart-float .cart-icon {
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

        /* New style for the download icon */
        .download-float {
            position: fixed;
            width: 60px;
            height: 60px;
            background-color: #ff5722;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            bottom: 220px;
            right: 20px;
        }

        .download-float .download-icon {
            margin-top: 16px;
        }

        .download-float:hover {
            background-color: #e64a19;
        }
    </style>
</head>

<!-- Footer -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 footer-contact" data-aos="fade-up">
                    <h4>Alamat dan Rekening Pembayaran</h4>
                    <p>
                        <?= $info_web->alamat; ?><br>
                        <strong>Phone:</strong> <?= $info_web->hp; ?><br>
                        <strong>Email:</strong> <?= $info_web->email; ?><br>
                        <strong>Atas Nama :</strong> <?= $info_web->an; ?>
                    </p>
                    <!-- Download link in the footer -->
                    <p>
                        <a href="sertifikathalal.pdf" download>Unduh Sertifikat Halal</a>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 footer-links" data-aos="fade-up" data-aos-delay="300">
                    <h4>Tentang Kami</h4>
                    <p>Dapur Kynan adalah UMKM Kreatif yang berdiri sejak 2015 di Bekasi yang menyediakan cemilan homemade dengan bahan berkualitas tinggi.</p>
                    <div class="social-links mt-3">
                        <a target="_blank" href="<?= $info_web->wa; ?>" class="instagram"><i class="fa fa-whatsapp"></i></a>
                        <a target="_blank" href="<?= $info_web->ig; ?>" class="instagram"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container py-4">
        <div class="copyright">
            <strong><span></span></strong> Copyright <i class="fa fa-copyright"></i> <?php echo date("Y"); ?> | Aplikasi <?= $info_web->title; ?>.
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
            <?= $info_web->title; ?></a>
        </div>
    </div>
</footer><!-- End Footer -->

<!-- WhatsApp Icon -->
<a href="<?= $info_web->wa; ?>" class="whatsapp-float" data-toggle="tooltip" title="WhatsApp" target="_blank">
    <i class="fa fa-whatsapp whatsapp-icon"></i>
</a>

<!-- Download Icon -->
<a href="sertifikathalal.pdf" download class="download-float" data-toggle="tooltip" title="Unduh Sertifikat Halal">
    <i class="fa fa-download download-icon"></i>
</a>

<!-- Cart Icon -->
<a href="keranjang.php" class="cart-float" data-toggle="tooltip" title="Keranjang Belanja">
    <i class="fa fa-shopping-cart cart-icon"></i>
    <span class="cart-badge badge badge-primary"><?= $jumlah_item; ?></span>
</a>

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Sweetalert -->
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<!-- page script -->
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
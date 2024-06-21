<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : index.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
require 'koneksi/koneksi.php';
include 'header.php';

?>

<!DOCTYPE html>
<html>


<head>
    <title></title>
    <!-- Link CSS Swiper -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Link CSS Bootstrap (jika diperlukan) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        .carousel-item img {
            max-width: 100%;
            max-height: 500px;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <br>
    <br>
    <!-- ======= Hero Section ======= -->

    <main id="main">
        <section id="#beranda" class="beranda d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-left">
                        <div class="text-center text-xxl-start">
                            <?php
                            $sql = "SELECT * FROM landingpage WHERE id = 1";
                            $row = $koneksi->prepare($sql);
                            $row->execute();
                            $data = $row->fetch(PDO::FETCH_OBJ);
                            ?>
                            <div>
                                <h2 class="display-3 fw-bolder mb-5" style="color: black;text-shadow: 2px 2px 4px #222;"><?= $data->title; ?></h2>
                                <h4 style="color: blue;text-shadow: 0 0 3px #fff, 0 0 5px #fff;">
                                    <?= $data->subtitle; ?> <br> <?= $data->prom; ?>
                                </h4>
                                <a href="produk.php"><button class="btn btn-primary btn-lg px-3 py-3 me-sm-3 fs-6 fw-bolder" style="border-radius: 20px;border: 2px solid #eee;"><i class="fa fa-opencart"></i> Seluruh Produk</button></a>
                                <a type="submit" onclick="window.location.href='./#kontak'"><button class="btn btn-info btn-lg px-3 py-3 me-sm-3 fs-6 fw-bolder" style="border-radius: 20px;border: 2px solid #eee;"><i class="fa fa-phone-square faa-tada animated-hover"></i> Kontak Kami</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 d-lg-flex justify-content-center align-items-center order-1 order-lg-2" data-aos="fade-up">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="8"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="9"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="10"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="assets/img/slide/slide1.png" class="d-block w-100" alt="1">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide2.png" class="d-block w-100" alt="2">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide3.png" class="d-block w-100" alt="3">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide4.png" class="d-block w-100" alt="4">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide5.png" class="d-block w-100" alt="5">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide6.png" class="d-block w-100" alt="6">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide7.png" class="d-block w-100" alt="7">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide8.png" class="d-block w-100" alt="8">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide9.png" class="d-block w-100" alt="9">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide10.png" class="d-block w-100" alt="10">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/slide/slide11.png" class="d-block w-100" alt="11">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Hero -->
    </main>

    <hr>

    <!-- ======= produk Section ======= -->
    <section id="produk" class="produk" style="padding-bottom: 40px;">
        <div class="container">
            <div class="section-title" data-aos="fade-up" data-aos-delay="200">
                <h2>Produk Kami</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-left" data-aos-delay="300">
                    <a href="produk.php?cari=&category=1" title="Lihat Cake dan Roti">
                        <div class="card">
                            <img class="card-img-top" src="assets/img/iklan/1.jpg" alt="Cake dan Roti">
                            <div class="card-body icon-box" style="text-align: center;">
                                <h4 class="card-title"><a href="produk.php?cari=&category=1" title="Lihat Cake dan Roti">Cake dan Roti</a></h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-left" data-aos-delay="300">
                    <a href="produk.php?cari=&category=8" title="Lihat Cemilan">
                        <div class="card">
                            <img class="card-img-top" src="assets/img/iklan/2.jpg" alt="Cemilan">
                            <div class="card-body icon-box" style="text-align: center;">
                                <h4 class="card-title"><a href="produk.php?cari=&category=8" title="Lihat Cemilan">Cemilan</a></h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-left" data-aos-delay="300">
                    <a href="produk.php?cari=&category=9" title="Lihat Healthy Drink">
                        <div class="card">
                            <img class="card-img-top" src="assets/img/iklan/3.jpg" alt="Healthy Drink">
                            <div class="card-body icon-box" style="text-align: center;">
                                <h4 class="card-title"><a href="produk.php?cari=&category=9" title="Lihat Healthy Drink">Healthy Drink</a></h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-left" data-aos-delay="300">
                    <a href="produk.php?cari=&category=10" title="Lihat Sambal dan Bumbu">
                        <div class="card">
                            <img class="card-img-top" src="assets/img/iklan/4.jpg" alt="Sambal dan Bumbu">
                            <div class="card-body icon-box" style="text-align: center;">
                                <h4 class="card-title"><a href="produk.php?cari=&category=10" title="Lihat Sambal dan Bumbu">Sambal dan Bumbu</a></h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <br>
            <br>
            <div class="text-center" data-aos="fade-left">
                <a href="produk.php"><button class="btn btn-primary btn-lg px-3 py-3 me-sm-3 fs-6 fw-bolder" style="border-radius: 20px;border: 2px solid #eee;">Lihat Seluruh Produk</button></a>
            </div>
        </div>
    </section><!-- End Featured Section -->

    <hr>

    <!-- ======= Contact Section ======= -->
    <section id="kontak" class="kontak">
        <div class="container">
            <div class="section-title" data-aos="fade-down">
                <br>
                <h2><i class="fa fa-phone-square"></i> Kontak Kami</h2>
                <h4>Anda dapat menghubungi kami melalui kontak dibawah ini!</h4>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div style="background-color: #eee;border: 2px solid #fff;" class="col-lg-6 info" data-aos="fade-up">
                            <h2><i class="fa fa-map-marker"></i> Alamat</h2>
                            <p><?= $info_web->alamat; ?></p>
                        </div>
                        <div style="background-color: #eee;border: 2px solid #fff;" class="col-lg-6 info" data-aos="fade-up" data-aos-delay="100">
                            <h2><i class="fa fa-whatsapp"></i> Kontak HP/WA</h2>
                            <p><?= $info_web->hp; ?></p>
                        </div>
                        <div style="background-color: #eee;border: 2px solid #fff;" class="col-lg-6 info" data-aos="fade-up" data-aos-delay="200">
                            <h2><i class="fa fa-envelope"></i> Email</h2>
                            <p><?= $info_web->email; ?></p>
                        </div>
                        <div style="background-color: #eee;border: 2px solid #fff;" class="col-lg-6 info" data-aos="fade-up" data-aos-delay="300">
                            <h2><i class="fa fa-clock-o"></i> Jam Buka</h2>
                            <p>Setiap Hari: 07.00 - 18.00 WIB</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <?= $info_web->map; ?>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->

    <!-- Script JavaScript -->
    <!-- Link Script Swiper -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
</body>

</html>
<?php
include 'footer.php';
?>
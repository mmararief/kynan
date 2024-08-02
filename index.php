<?php
require 'koneksi/koneksi.php';
include 'header.php';

$sql_web = "SELECT * FROM identitas WHERE id = 1";
$row_web = $koneksi->prepare($sql_web);
$row_web->execute();
$identitas_web = $row_web->fetch();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .carousel-item img {
            max-width: 100%;
            max-height: 500px;
            height: auto;
            object-fit: cover;
        }

        .hero-section {
            background-color: #f8f9fa;
            padding: 50px 0;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .section-title h4 {
            font-size: 1.25rem;
            margin-bottom: 40px;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .info {
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 8px;
        }

        .info h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .info p {
            font-size: 1rem;
            margin-bottom: 0;
        }

        .btn-primary,
        .btn-info {
            border-radius: 20px;
            padding: 15px 30px;
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <main id="main">
        <section id="beranda" class="hero-section d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center align-items-stretch pt-5 order-2 order-lg-1" data-aos="fade-left">
                        <div class="text-center text-xxl-start">
                            <?php
                            $sql = "SELECT * FROM landingpage WHERE id = 1";
                            $row = $koneksi->prepare($sql);
                            $row->execute();
                            $data = $row->fetch(PDO::FETCH_OBJ);
                            ?>
                            <div>
                                <h2 class="display-3 fw-bolder mb-5" style="color: black;"><?= $data->title; ?></h2>
                                <h4 style="color: blue;">
                                    <?= $data->subtitle; ?> <br> <?= $data->prom; ?>
                                </h4>
                                <a href="produk.php"><button class="btn btn-primary btn-lg px-3 py-3 me-sm-3"><i class="fa fa-opencart"></i> Seluruh Produk</button></a>
                                <button class="btn btn-info btn-lg px-3 py-3 me-sm-3" onclick="window.location.href='./#kontak'"><i class="fa fa-phone-square"></i> Kontak Kami</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-center align-items-center order-1 order-lg-2" data-aos="fade-up">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
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
                                    <img src="assets/img/slide/slide1.png" class="d-block w-100" alt="Slide 1">
                                </div>
                                <?php for ($i = 2; $i <= 11; $i++) : ?>
                                    <div class="carousel-item">
                                        <img src="assets/img/slide/slide<?= $i; ?>.png" class="d-block w-100" alt="Slide <?= $i; ?>">
                                    </div>
                                <?php endfor; ?>
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
        </section>

        <section id="produk" class="produk py-5">
            <div class="container">
                <div class="section-title text-center mb-5" data-aos="fade-up" data-aos-delay="200">
                    <h2>Produk Kami</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-left" data-aos-delay="300">
                        <a href="produk.php?cari=&category=1" title="Lihat Cake dan Roti">
                            <div class="card">
                                <img class="card-img-top" src="assets/img/iklan/1.jpg" alt="Cake dan Roti">
                                <div class="card-body text-center">
                                    <h4 class="card-title">Cake dan Roti</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-left" data-aos-delay="300">
                        <a href="produk.php?cari=&category=8" title="Lihat Cemilan">
                            <div class="card">
                                <img class="card-img-top" src="assets/img/iklan/2.jpg" alt="Cemilan">
                                <div class="card-body text-center">
                                    <h4 class="card-title">Cemilan</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-left" data-aos-delay="300">
                        <a href="produk.php?cari=&category=9" title="Lihat Healthy Drink">
                            <div class="card">
                                <img class="card-img-top" src="assets/img/iklan/3.jpg" alt="Healthy Drink">
                                <div class="card-body text-center">
                                    <h4 class="card-title">Healthy Drink</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch mb-4" data-aos="fade-left" data-aos-delay="300">
                        <a href="produk.php?cari=&category=10" title="Lihat Sambal dan Bumbu">
                            <div class="card">
                                <img class="card-img-top" src="assets/img/iklan/4.jpg" alt="Sambal dan Bumbu">
                                <div class="card-body text-center">
                                    <h4 class="card-title">Sambal dan Bumbu</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="text-center mt-4" data-aos="fade-left">
                    <a href="produk.php"><button class="btn btn-primary btn-lg">Lihat Seluruh Produk</button></a>
                </div>
            </div>
        </section>

        <section id="kontak" class="kontak py-5">
            <div class="container">
                <div class="section-title text-center mb-5" data-aos="fade-down">
                    <h2><i class="fa fa-phone-square"></i> Kontak Kami</h2>
                    <h4>Anda dapat menghubungi kami melalui kontak di bawah ini!</h4>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6 info bg-light mb-4" data-aos="fade-up">
                                <h2><i class="fa fa-map-marker"></i> Alamat</h2>
                                <p><?= $identitas_web->alamat; ?></p>
                            </div>
                            <div class="col-lg-6 info bg-light mb-4" data-aos="fade-up" data-aos-delay="100">
                                <h2><i class="fa fa-whatsapp"></i> Kontak HP/WA</h2>
                                <p><?= $identitas_web->hp; ?></p>
                            </div>
                            <div class="col-lg-6 info bg-light mb-4" data-aos="fade-up" data-aos-delay="200">
                                <h2><i class="fa fa-envelope"></i> Email</h2>
                                <p><?= $identitas_web->email; ?></p>
                            </div>
                            <div class="col-lg-6 info bg-light mb-4" data-aos="fade-up" data-aos-delay="300">
                                <h2><i class="fa fa-clock-o"></i> Jam Buka</h2>
                                <p>Setiap Hari: 07.00 - 18.00 WIB</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <?= $identitas_web->map; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
<?php include 'footer.php'; ?>
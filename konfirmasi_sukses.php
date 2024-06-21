<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Sukses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f6f6f6;
        }

        .text-darkblue {
            color: #1d4f88;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <br>
    <section class="clean-block clean-cart dark">
        <div class="container">
            <h2 class="text-center my-4 fs-2 text-darkgray">Konfirmasi Sukses</h2>
            <div class="card mb-3 border-0 rounded-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-darkblue">Terima kasih, pesanan Anda telah berhasil dikonfirmasi!</h3>
                    <p>Anda akan segera dihubungi untuk proses lebih lanjut.</p>
                    <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>

<?php include 'footer.php'; ?>
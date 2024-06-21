<?php
require '../../koneksi/koneksi.php';
$title_web = 'Laporan Keuangan';
include '../header.php';

// Fungsi untuk mengambil data pemasukan berdasarkan bulan
function getPemasukanBySource($bulan, $tahun)
{
    global $koneksi;
    $sql = "SELECT sumber, SUM(jumlah) as total FROM pemasukan WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' GROUP BY sumber";
    $row = $koneksi->prepare($sql);
    $row->execute();
    return $row->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk mengambil data pengeluaran berdasarkan bulan
function getPengeluaranBySource($bulan, $tahun)
{
    global $koneksi;
    $sql = "SELECT sumber, SUM(jumlah) as total FROM pengeluaran WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' GROUP BY sumber";
    $row = $koneksi->prepare($sql);
    $row->execute();
    return $row->fetchAll(PDO::FETCH_ASSOC);
}

// Inisialisasi bulan dan tahun default ke bulan dan tahun saat ini
$bulan = date('m');
$tahun = date('Y');

// Jika ada filter bulan dan tahun yang dikirimkan
if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];
}

// Mengambil data pemasukan dan pengeluaran berdasarkan bulan dan tahun yang dipilih
$pemasukan_by_source = getPemasukanBySource($bulan, $tahun);
$pengeluaran_by_source = getPengeluaranBySource($bulan, $tahun);

// Menghitung total pemasukan dan pengeluaran
$total_pemasukan = array_sum(array_column($pemasukan_by_source, 'total'));
$total_pengeluaran = array_sum(array_column($pengeluaran_by_source, 'total'));
$selisih = $total_pemasukan - $total_pengeluaran;
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Keuangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Laporan Keuangan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Form untuk memilih bulan dan tahun -->
    <div class="row">
        <div class="col-lg-6">
            <form action="laporan.php" method="GET">
                <div class="form-group">
                    <label for="bulan">Pilih Bulan:</label>
                    <select class="form-control" id="bulan" name="bulan">
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Pilih Tahun:</label>
                    <select class="form-control" id="tahun" name="tahun">
                        <?php for ($i = date('Y'); $i >= 2000; $i--) : ?>
                            <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
            </form>
        </div>
    </div>

    <!-- Tabel laporan -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Total Pemasukan</th>
                        <th>Total Pengeluaran</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= date('F', mktime(0, 0, 0, $bulan, 10)) ?></td>
                        <td><?= $tahun ?></td>
                        <td><?= number_format($total_pemasukan, 0, ',', '.') ?></td>
                        <td><?= number_format($total_pengeluaran, 0, ',', '.') ?></td>
                        <td><?= number_format($selisih, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart section -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Pemasukan</h5>
            <div class="row">
                <div class="col-lg-8">
                    <canvas id="pemasukanBarChart"></canvas>
                </div>
                <div class="col-lg-4">
                    <canvas id="pemasukanDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title text-center">Pengeluaran</h5>
            <div class="row">
                <div class="col-lg-8">
                    <canvas id="pengeluaranBarChart"></canvas>
                </div>
                <div class="col-lg-4">
                    <canvas id="pengeluaranDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Data dari PHP untuk Pemasukan
            const pemasukanLabels = <?= json_encode(array_column($pemasukan_by_source, 'sumber')) ?>;
            const pemasukanData = <?= json_encode(array_column($pemasukan_by_source, 'total')) ?>;

            // Data dari PHP untuk Pengeluaran
            const pengeluaranLabels = <?= json_encode(array_column($pengeluaran_by_source, 'sumber')) ?>;
            const pengeluaranData = <?= json_encode(array_column($pengeluaran_by_source, 'total')) ?>;

            // Bar Chart Pemasukan
            new Chart(document.querySelector('#pemasukanBarChart'), {
                type: 'bar',
                data: {
                    labels: pemasukanLabels,
                    datasets: [{
                        label: 'Pemasukan',
                        data: pemasukanData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Doughnut Chart Pemasukan
            new Chart(document.querySelector('#pemasukanDoughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: pemasukanLabels,
                    datasets: [{
                        label: 'Pemasukan',
                        data: pemasukanData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Bar Chart Pengeluaran
            new Chart(document.querySelector('#pengeluaranBarChart'), {
                type: 'bar',
                data: {
                    labels: pengeluaranLabels,
                    datasets: [{
                        label: 'Pengeluaran',
                        data: pengeluaranData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Doughnut Chart Pengeluaran
            new Chart(document.querySelector('#pengeluaranDoughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: pengeluaranLabels,
                    datasets: [{
                        label: 'Pengeluaran',
                        data: pengeluaranData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 159, 64)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>

</main>

<?php include '../footer.php'; ?>
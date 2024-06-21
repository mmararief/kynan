<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : pemasukan.php 
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Daftar Pemasukan';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}

// Filter tanggal default ke hari ini
$today = date('Y-m-d');

// Jika ada filter tanggal yang dikirimkan
if (isset($_GET['tanggal'])) {
    $filter_tanggal = $_GET['tanggal'];
} else {
    $filter_tanggal = $today;
}

// Fungsi untuk mencari pemasukan berdasarkan keyword
function cariPemasukan($keyword, $filter_tanggal)
{
    global $koneksi;
    $sql = "SELECT * FROM pemasukan WHERE (keterangan LIKE '%$keyword%' OR sumber LIKE '%$keyword%')";
    if ($filter_tanggal) {
        $sql .= " AND tanggal = '$filter_tanggal'";
    }
    $sql .= " ORDER BY tanggal DESC";
    $row = $koneksi->prepare($sql);
    $row->execute();
    return $row->fetchAll();
}

// Ambil keyword pencarian jika ada
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
} else {
    $keyword = '';
}

// Ambil filter tanggal jika ada
if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
    $filter_tanggal = $_GET['tanggal'];
} else {
    $filter_tanggal = '';
}

// Ambil data berdasarkan keyword dan filter tanggal
if (!empty($keyword) && !empty($filter_tanggal)) {
    $hasil = cariPemasukan($keyword, $filter_tanggal);
} elseif (!empty($keyword)) {
    // Jika ada keyword pencarian, tetapi tidak ada filter tanggal
    $hasil = cariPemasukan($keyword, '');
} elseif (!empty($filter_tanggal)) {
    // Jika ada filter tanggal, tetapi tidak ada keyword pencarian
    $sql = "SELECT * FROM pemasukan WHERE tanggal = '$filter_tanggal' ORDER BY tanggal DESC";
    $row = $koneksi->prepare($sql);
    $row->execute();
    $hasil = $row->fetchAll();
} else {
    // Jika tidak ada keyword pencarian dan tidak ada filter tanggal
    $sql = "SELECT * FROM pemasukan ORDER BY tanggal DESC";
    $row = $koneksi->prepare($sql);
    $row->execute();
    $hasil = $row->fetchAll();
}

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Daftar Pemasukan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Daftar Pemasukan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- bagian filter dan pencarian -->
    <div class="row cari-filter">
        <div class="col-lg-5">
            <table class="tabel-data">
                <tr>
                    <td><label>Pilih tanggal</label></td>
                    <td style="width: 71%">
                        <input type="date" value="<?= $filter_tanggal ?>" class="form-control filter" id="filter">
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-lg-3">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control border-right-0 cari" id="keyword" placeholder="Search" autocomplete="off">
                    <div class="input-group-append">
                        <button class="input-group-text bg-white border-left-0 icone" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- bagian filter dan pencarian -->
    <hr>

    <section class="section dashboard">
        <div class="row">

            <section class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title text-white">
                            Daftar Pemasukan <br><br>
                            <a class="btn btn-light" href="tambah.php">Tambah Pemasukan</a>
                            <a class="btn btn-success" href="proses.php?aksi=exportExcel&tanggal=<?= $filter_tanggal ?>">Export to Excel</a>
                            <a class="btn btn-danger" href="proses.php?aksi=exportPDF&tanggal=<?= $filter_tanggal ?>">Export to PDF</a>
                        </h4>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">No. </th>
                                        <th style="text-align: left;">Tanggal</th>
                                        <th style="text-align: left;">Keterangan Pemasukan</th>
                                        <th style="text-align: left;">Sumber Pemasukan</th>
                                        <th style="text-align: right;">Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($hasil as $isi) {
                                    ?>
                                        <tr>
                                            <td style="text-align: left;"><?php echo $no; ?></td>
                                            <td style="text-align: left;"><?= $isi['tanggal']; ?></td>
                                            <td style="text-align: left;"><?= $isi['keterangan']; ?></td>
                                            <td style="text-align: left;"><?= $isi['sumber']; ?></td>
                                            <td style="text-align: right;"><?= number_format($isi['jumlah'], 0, ',', '.'); ?></td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit.php?id=<?php echo $isi['id_pemasukan']; ?>" role="button">Edit</a>
                                                <a class="btn btn-danger  btn-sm" href="#" role="button" onclick="hapusPemasukan(<?php echo $isi['id_pemasukan']; ?>)">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php $no++;
                                    } ?>
                                    <tr>
                                        <?php
                                        $total_pemasukan = 0;
                                        foreach ($hasil as $isi) {
                                            $total_pemasukan += $isi['jumlah'];
                                        } ?>
                                        <td colspan="4"><strong>Total Pemasukan:</strong></td>
                                        <td><strong><?= number_format($total_pemasukan, 0, ',', '.'); ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>

</main>

<?php include '../footer.php'; ?>

<!-- SweetAlert -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi untuk filter berdasarkan tanggal
    $('#filter').change(function() {
        var tanggal = $(this).val();
        window.location.href = 'pemasukan.php?tanggal=' + tanggal;
    });
    // Fungsi untuk melakukan pencarian saat input berubah
    $('#keyword').on('input', function() {
        var keyword = $(this).val();
        var filter_tanggal = $('#filter').val(); // Ambil nilai filter tanggal jika ada
        cariData(keyword, filter_tanggal);
    });

    // Fungsi untuk melakukan pencarian data
    function cariData(keyword, filter_tanggal) {
        $.ajax({
            url: 'pemasukan.php',
            type: 'GET',
            data: {
                keyword: keyword,
                tanggal: filter_tanggal
            },
            success: function(response) {
                // Replace tabel dengan hasil pencarian
                var hasilPencarian = $(response).find('.table-responsive').html();
                $('.table-responsive').html(hasilPencarian);
            }
        });
    }
</script>
<script>
    function hapusPemasukan(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan proses penghapusan di sini
                $.ajax({
                    url: 'proses.php?aksi=hapus&id=' + id,
                    type: 'GET',
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(() => {
                            window.location.href = 'pemasukan.php';
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }
</script>
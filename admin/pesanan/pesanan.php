<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file      : Pesanan.php 
  | @uthor     : kynan@gmail.com
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Pesanan Masuk';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}

// Set the number of items per page
$items_per_page = 10;

// Get the current page number from the query string
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $items_per_page;

// Get the total number of orders
$total_sql = "SELECT COUNT(*) FROM transaksi";
$total_result = $koneksi->query($total_sql);
$total_items = $total_result->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_items / $items_per_page);


$sql = "SELECT 
    t.id_transaksi AS transaksi_id, 
    t.tanggal,
    t.via, 
    t.nama, 
    GROUP_CONCAT(p.nama_produk SEPARATOR ', ') AS nama_produk, 
    t.whatsapp, 
    t.alamat, 
    t.metode_pembayaran,
    t.status,
    SUM(d.subtotal) AS total_belanja
FROM 
    transaksi t
LEFT JOIN 
    detailtransaksi d ON t.id_transaksi = d.id_transaksi
LEFT JOIN 
    produk p ON d.id_produk = p.id_produk
GROUP BY 
    t.id_transaksi
ORDER BY 
    t.id_transaksi DESC
LIMIT 0, 10;
";



?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Pesanan Masuk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Pesanan Masuk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-white">
                            Pesanan Masuk
                            <a class="btn btn-light float-right" href="tambah.php">Tambah Pesanan</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Via</th>
                                        <th>Nama</th>
                                        <th>Nama Produk</th>
                                        <th>WhatsApp</th>
                                        <th>Alamat</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status</th>
                                        <th>Total Belanja</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $row = $koneksi->prepare($sql);
                                    $row->execute();
                                    $hasil = $row->fetchAll();
                                    $no = $offset + 1;

                                    foreach ($hasil as $isi) {
                                    ?>
                                        <tr id="order-<?= $isi['transaksi_id']; ?>">
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $isi['tanggal']; ?></td>
                                            <td><?php echo $isi['via']; ?></td>
                                            <td><?php echo $isi['nama']; ?></td>
                                            <td><?php echo $isi['nama_produk']; ?></td>
                                            <td><?php echo $isi['whatsapp']; ?></td>
                                            <td><?php echo $isi['alamat']; ?></td>
                                            <td><?php echo $isi['metode_pembayaran']; ?></td>
                                            <td id="status-<?= $isi['transaksi_id']; ?>"><?php echo $isi['status']; ?></td>
                                            <td><?php echo number_format($isi['total_belanja'], 0, ',', '.'); ?></td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" role="button" onclick="prosesPesanan('<?php echo $isi['transaksi_id']; ?>', '<?php echo $isi['tanggal']; ?>', '<?php echo $isi['nama_produk']; ?>', '<?php echo $isi['total_belanja']; ?>', '<?php echo $isi['whatsapp']; ?>')">Proses</a>
                                                <a class="btn btn-danger btn-sm" role="button" onclick="hapusPesanan(<?php echo $isi['transaksi_id']; ?>)">Hapus</a>
                                                <a class="btn btn-success btn-sm" role="button" onclick="selesaiPesanan('<?php echo $isi['transaksi_id']; ?>', '<?php echo $isi['tanggal']; ?>', '<?php echo $isi['nama_produk']; ?>', '<?php echo $isi['total_belanja']; ?>', '<?php echo $isi['whatsapp']; ?>')">Selesai</a>
                                            </td>
                                        </tr>
                                    <?php $no++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php if ($current_page > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">Previous</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                    <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($current_page < $total_pages) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../footer.php'; ?>

<!-- SweetAlert -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function hapusPesanan(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

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
                $.ajax({
                    url: 'proses.php?aksi=hapus&id=' + id,
                    type: 'GET',
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(() => {
                            document.getElementById('order-' + id).remove();
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                );
            }
        });
    }

    // function prosesPesanan(whatsapp) {
    //     const message = "Pesanan Sedang di Proses";
    //     const url = `https://wa.me/${whatsapp}?text=${encodeURIComponent(message)}`;
    //     window.open(url, '_blank');
    // }

    function prosesPesanan(id, tanggal, nama_produk, jumlah, whatsapp) {
        $.ajax({
            url: 'proses.php?aksi=proses',
            type: 'POST',
            data: {
                id: id,
                tanggal: tanggal,
                nama_produk: nama_produk,
                jumlah: jumlah
            },
            success: function(response) {
                console.log('Server Response:', response);
                Swal.fire(
                    'Success',
                    'Pesanan telah diproses',
                    'success'
                ).then(() => {
                    document.getElementById('status-' + id).innerText = 'Proses';
                });
            },
            error: function(error) {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Terjadi kesalahan saat memproses pesanan',
                    'error'
                );
            }
        });
    }

    function selesaiPesanan(id, tanggal, nama_produk, jumlah, whatsapp) {
        $.ajax({
            url: 'proses.php?aksi=selesai',
            type: 'POST',
            data: {
                id: id,
                tanggal: tanggal,
                nama_produk: nama_produk,
                jumlah: jumlah
            },
            success: function(response) {
                console.log('Server Response:', response);
                Swal.fire(
                    'Success',
                    'Pesanan telah selesai',
                    'success'
                ).then(() => {
                    document.getElementById('status-' + id).innerText = 'Selesai';
                });
            },
            error: function(error) {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Terjadi kesalahan saat menyelesaikan pesanan',
                    'error'
                );
            }
        });
    }
</script>
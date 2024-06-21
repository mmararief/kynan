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
$total_sql = "SELECT COUNT(*) FROM konfirmasi";
$total_result = $koneksi->query($total_sql);
$total_items = $total_result->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_items / $items_per_page);
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
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title text-white">
                            Pesanan Masuk <br><br>
                            <a class="btn btn-light" href="tambah.php">Tambah Pesanan</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"><br>
                            <table class="table table-bordered">
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
                                    $sql = "SELECT * FROM konfirmasi ORDER BY id DESC LIMIT $offset, $items_per_page";
                                    $row = $koneksi->prepare($sql);
                                    $row->execute();
                                    $hasil = $row->fetchAll();
                                    $no = $offset + 1;

                                    foreach ($hasil as $isi) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $isi['tanggal']; ?></td>
                                            <td><?php echo $isi['via']; ?></td>
                                            <td><?php echo $isi['nama']; ?></td>
                                            <td><?php echo $isi['nama_produk']; ?></td>
                                            <td><?php echo $isi['whatsapp']; ?></td>
                                            <td><?php echo $isi['alamat']; ?></td>
                                            <td><?php echo $isi['metode_pembayaran']; ?></td>
                                            <td><?php echo $isi['status']; ?></td>
                                            <td><?php echo number_format($isi['jumlah'], 0, ',', '.'); ?></td>
                                            <td>
                                                <!-- Tambahkan tombol-tombol aksi sesuai kebutuhan -->
                                                <a class="btn btn-primary btn-sm" href="#" role="button" onclick="prosesPesanan('<?php echo $isi['whatsapp']; ?>')">Proses</a>
                                                <a class="btn btn-danger btn-sm" href="#" role="button" onclick="hapusPesanan(<?php echo $isi['id']; ?>)">Hapus</a>
                                                <a class="btn btn-primary btn-sm" href="#" role="button" onclick="selesaiPesanan('<?php echo $isi['id']; ?>', '<?php echo $isi['tanggal']; ?>', '<?php echo $isi['nama_produk']; ?>', '<?php echo $isi['jumlah']; ?>', '<?php echo $isi['whatsapp']; ?>')">Selesai</a>
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
                            window.location.href = 'pesanan.php';
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

    function prosesPesanan(whatsapp) {
        const message = "Pesanan Sedang di Proses";
        const url = `https://wa.me/${whatsapp}?text=${encodeURIComponent(message)}`;
        window.open(url, '_blank');
    }

    function selesaiPesanan(id, tanggal, nama_produk, jumlah, whatsapp) {
        const message = "Pesanan Anda Telah Selesai";
        const url = `https://wa.me/${whatsapp}?text=${encodeURIComponent(message)}`;
        window.open(url, '_blank');

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
                const res = JSON.parse(response);
                if (res.success) {
                    Swal.fire(
                        'Success',
                        'Pesanan telah selesai',
                        'success'
                    ).then(() => {
                        window.location.href = 'pesanan.php';
                    });
                } else {
                    Swal.fire(
                        'Error',
                        res.message,
                        'error'
                    );
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                Swal.fire(
                    'Error',
                    'Gagal menyelesaikan pesanan',
                    'error'
                );
            }
        });
    }
</script>
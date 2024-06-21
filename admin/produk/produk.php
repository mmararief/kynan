<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : produk.php 
  | @author    : kynan@gmail.com
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Daftar Produk';
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

// Get the total number of products
$total_sql = "SELECT COUNT(*) FROM produk";
$total_result = $koneksi->query($total_sql);
$total_items = $total_result->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_items / $items_per_page);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Produk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Daftar Produk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title text-white">
                            Daftar Produk <br><br>
                            <a class="btn btn-light" href="tambah.php">Tambah Produk</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"><br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Gambar</th>
                                        <th>Kategori</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT produk.*, kategori.nama_kategori 
                                            FROM produk 
                                            JOIN kategori ON produk.id_kategori = kategori.id_kategori 
                                            ORDER BY produk.id_produk ASC
                                            LIMIT $offset, $items_per_page";
                                    $row = $koneksi->prepare($sql);
                                    $row->execute();
                                    $hasil = $row->fetchAll();
                                    $no = $offset + 1;

                                    foreach ($hasil as $isi) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><img src="../assets/image/<?php echo $isi['gambar']; ?>" class="img-fluid" style="max-width: 200px;"></td>
                                            <td><?php echo $isi['nama_kategori']; ?></td>
                                            <td><?php echo $isi['nama_produk']; ?></td>
                                            <td><?php echo $isi['harga']; ?></td>
                                            <td><?php echo $isi['status']; ?></td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit.php?id=<?php echo $isi['id_produk']; ?>" role="button">Edit</a>
                                                <a class="btn btn-danger btn-sm" href="#" role="button" onclick="hapusProduk(<?php echo $isi['id_produk']; ?>, '<?php echo $isi['gambar']; ?>')">Hapus</a>
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
    function hapusProduk(id, gambar) {
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
                    url: 'proses.php?aksi=hapus&id=' + id + '&gambar=' + gambar,
                    type: 'GET',
                    success: function(response) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(() => {
                            window.location.href = 'produk.php';
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
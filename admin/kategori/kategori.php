<?php
require '../../koneksi/koneksi.php';
$title_web = 'Daftar Kategori'; // Ubah judul halaman menjadi "Daftar Kategori"
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Daftar Kategori</h1> <!-- Ubah judul halaman menjadi "Daftar Kategori" -->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Daftar Kategori</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="container">
                <div class="card">
                    <div class="card-header text-white bg-primary">
                        <h4 class="card-title text-white">
                            Daftar Kategori <br><br> <!-- Ubah teks menjadi "Daftar Kategori" -->
                            <a class="btn btn-light" href="tambah.php">Tambah Kategori</a> <!-- Ubah teks menjadi "Tambah Kategori" -->
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"><br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Kategori</th> <!-- Ubah teks menjadi "Nama Kategori" -->
                                        <th>Tanggal Input</th> <!-- Ubah teks menjadi "Tanggal Input" -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM kategori ORDER BY id_kategori ASC"; // Ubah query SQL
                                    $row = $koneksi->prepare($sql);
                                    $row->execute();
                                    $hasil = $row->fetchAll();
                                    $no = 1;

                                    foreach ($hasil as $isi) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $isi['nama_kategori']; ?></td> <!-- Ubah nama kolom menjadi "nama_kategori" -->
                                            <td><?php echo $isi['tgl_input']; ?></td> <!-- Ubah nama kolom menjadi "tgl_input" -->
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="edit.php?id=<?php echo $isi['id_kategori']; ?>" role="button">Edit</a>
                                                <a class="btn btn-danger  btn-sm" href="#" role="button" onclick="hapusKategori(<?php echo $isi['id_kategori']; ?>)">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php $no++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
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
    function hapusKategori(id) {
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
                            window.location.href = 'kategori.php';
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
<?php
/*
  | Source Code Aplikasi Toko PHP & MySQL
  | 
  | @package   : kynan
  | @file	   : proses.php
  | @author    : kynan@gmail.com
  | 
  | 
  | 
  | 
 */
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
</body>

</html>

<?php
require '../../koneksi/koneksi.php';
$title_web = 'Tambah produk';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}

if ($_GET['aksi'] == 'tambah') {
    $dir = '../assets/image/';
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $temp = explode(".", $_FILES["gambar"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $target_path = $dir . basename($newfilename);
    $allowedImageType = array("image/gif",   "image/JPG",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png");

    if ($_FILES['gambar']["error"] > 0) {
        echo '
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            
            Toast.fire({
                icon: "error",
                title: "Harap Upload Gambar !",
            }).then(() => {
                history.go(-1);
            });
        </script>';
        exit();
    } elseif (!in_array($_FILES['gambar']["type"], $allowedImageType)) {
        echo '
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            
            Toast.fire({
                icon: "warning",
                title: "Hanya dapat mengunggah JPG, PNG & GIF",
            }).then(() => {
                history.go(-1);
            });
        </script>';
        exit();
    } elseif (round($_FILES['gambar']["size"] / 1024) > 4096) {
        echo '
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            
            Toast.fire({
                icon: "warning",
                title: "Besar Gambar tidak boleh lebih dari 4MB !",
            }).then(() => {
                history.go(-1);
            });
        </script>';
        exit();
    } else {

        if (move_uploaded_file($tmp_name, $target_path)) {
            $data[] = $_POST['nama_produk'];
            $data[] = $_POST['id_kategori'];
            $data[] = $_POST['harga'];
            $data[] = $_POST['status'];
            $data[] = $newfilename;

            $sql = "INSERT INTO `produk`(`nama_produk`, `id_kategori`, `harga`, `status`, `gambar`) 
                VALUES (?,?,?,?,?)";
            $row = $koneksi->prepare($sql);
            $row->execute($data);
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Sukses Tambah Produk",
                }).then(() => {
                    window.location = "produk.php";
                });
            </script>';
        } else {
            echo '
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                
                Toast.fire({
                    icon: "error",
                    title: "Harap Upload Gambar !",
                }).then(() => {
                    history.go(-1);
                });
            </script>';
        }
    }
}

if ($_GET['aksi'] == 'edit') {
    $dir = '../assets/image/';
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $temp = explode(".", $_FILES["gambar"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $target_path = $dir . basename($newfilename);
    $allowedImageType = array("image/gif",   "image/JPG",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png");

    $gambar = $_POST['gambar_cek'];

    $id = $_GET['id'];

    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    // Check if a new image is uploaded
    if ($_FILES['gambar']["size"] > 0) {
        // Check for errors in uploaded image
        if ($_FILES['gambar']["error"] > 0) {
            // Handling error if no image is uploaded
            echo '
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                
                Toast.fire({
                    icon: "error",
                    title: "Harap Upload Gambar !",
                }).then(() => {
                    history.go(-1);
                });
            </script>';
            exit();
        } elseif (!in_array($_FILES['gambar']["type"], $allowedImageType)) {
            // Handling error if uploaded image type is not allowed
            echo '
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                
                Toast.fire({
                    icon: "warning",
                    title: "Hanya dapat mengunggah JPG, PNG & GIF",
                }).then(() => {
                    history.go(-1);
                });
            </script>';
            exit();
        } elseif (round($_FILES['gambar']["size"] / 1024) > 4096) {
            // Handling error if uploaded image size exceeds the limit
            echo '
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                
                Toast.fire({
                    icon: "warning",
                    title: "Besar Gambar tidak boleh lebih dari 4MB !",
                }).then(() => {
                    history.go(-1);
                });
            </script>';
            exit();
        } else {
            // If the upload process is successful
            if (move_uploaded_file($tmp_name, $target_path)) {
                // Delete old image
                if (file_exists('../assets/image/' . $gambar)) {
                    unlink('../assets/image/' . $gambar);
                }
                // New image filename
                $new_gambar_name = $newfilename;
            } else {
                // Handling error if image upload fails
                echo '
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener("mouseenter", Swal.stopTimer);
                            toast.addEventListener("mouseleave", Swal.resumeTimer);
                        },
                    });
                    
                    Toast.fire({
                        icon: "error",
                        title: "Harap Upload Gambar !",
                    }).then(() => {
                        history.go(-1);
                    });
                </script>';
                exit();
            }
        }
    } else {
        // If no new image is uploaded, use the old image filename
        $new_gambar_name = $gambar;
    }

    // Update product details in the database
    $sql = "UPDATE produk SET nama_produk = ?, id_kategori = ?, harga = ?, status = ?, gambar = ? 
            WHERE id_produk = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$nama_produk, $id_kategori, $harga, $status, $new_gambar_name, $id]);

    // Success message after editing product
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Sukses Edit Produk",
        }).then(() => {
            window.location = "produk.php";
        });
    </script>';
}

if (!empty($_GET['aksi'] == 'hapus')) {
    $id = $_GET['id'];
    $gambar = $_GET['gambar'];

    // Delete the image file
    unlink('../assets/image/' . $gambar);

    // Delete product from the database
    $sql = "DELETE FROM produk WHERE id_produk = ?";
    $row = $koneksi->prepare($sql);
    $row->execute(array($id));

    // Success message after deleting product
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Sukses Hapus Produk",
        }).then(() => {
            window.location = "produk.php";
        });
    </script>';
}

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

// Include PhpSpreadsheet library
require '../../koneksi/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

// Include TCPDF library
require '../../koneksi/vendor/tecnickcom/tcpdf/tcpdf.php';

if (isset($_GET['aksi'])) {
  $aksi = $_GET['aksi'];

  switch ($aksi) {
    case 'exportExcel':
      exportToExcel();
      break;

    case 'exportPDF':
      exportToPDF();
      break;
  }
}

function getFilteredData($tanggal = null)
{
  global $koneksi;
  if ($tanggal) {
    $sql = "SELECT * FROM pemasukan WHERE tanggal = :tanggal ORDER BY tanggal DESC";
    $row = $koneksi->prepare($sql);
    $row->execute([':tanggal' => $tanggal]);
  } else {
    $sql = "SELECT * FROM pemasukan ORDER BY tanggal DESC";
    $row = $koneksi->prepare($sql);
    $row->execute();
  }
  return $row->fetchAll();
}

function exportToExcel()
{
  global $koneksi;

  $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;
  $hasil = getFilteredData($tanggal);

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setTitle('Pemasukan');

  // Set header
  $sheet->setCellValue('A1', 'No');
  $sheet->setCellValue('B1', 'Tanggal');
  $sheet->setCellValue('C1', 'Keterangan Pemasukan');
  $sheet->setCellValue('D1', 'Sumber Pemasukan');
  $sheet->setCellValue('E1', 'Jumlah');

  // Set columns to auto size
  $sheet->getColumnDimension('A')->setAutoSize(true);
  $sheet->getColumnDimension('B')->setAutoSize(true);
  $sheet->getColumnDimension('C')->setAutoSize(true);
  $sheet->getColumnDimension('D')->setAutoSize(true);
  $sheet->getColumnDimension('E')->setAutoSize(true);

  // Fill data
  $no = 1;
  $rowIndex = 2;
  foreach ($hasil as $isi) {
    $sheet->setCellValue('A' . $rowIndex, $no);
    $sheet->setCellValue('B' . $rowIndex, $isi['tanggal']);
    $sheet->setCellValue('C' . $rowIndex, $isi['keterangan']);
    $sheet->setCellValue('D' . $rowIndex, $isi['sumber']);
    $sheet->setCellValue('E' . $rowIndex, $isi['jumlah']);

    // Set number format for 'Jumlah' column
    $sheet->getStyle('E' . $rowIndex)->getNumberFormat()->setFormatCode('#,##0');
    $no++;
    $rowIndex++;
  }

  // Define the table range
  $tableRange = 'A1:E' . ($rowIndex - 1);

  // Create table
  $table = new Table($tableRange);
  $table->setName('PemasukanTable');

  // Create a new table style and apply it
  $tableStyle = new TableStyle();
  $tableStyle->setTheme(TableStyle::TABLE_STYLE_MEDIUM9);
  $table->setStyle($tableStyle);

  $sheet->addTable($table);

  // Create Excel file
  $writer = new Xlsx($spreadsheet);
  $filename = 'Daftar_Pemasukan.xlsx';

  // Clear output buffer
  if (ob_get_length() > 0) {
    ob_end_clean();
  }

  // Set headers
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="' . $filename . '"');

  // Save file to output
  $writer->save('php://output');
  exit;
}

function exportToPDF()
{
  global $koneksi;

  $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;
  $hasil = getFilteredData($tanggal);

  // Create new PDF document
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // Set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Your Name');
  $pdf->SetTitle('Daftar Pemasukan');
  $pdf->SetSubject('Pemasukan');
  $pdf->SetKeywords('TCPDF, PDF, Pemasukan');

  // Set header and footer fonts
  $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // Set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // Set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // Set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // Set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // Add a page
  $pdf->AddPage();

  // Set content
  $html = '<h1>Daftar Pemasukan</h1>';
  $html .= '<table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Keterangan Pemasukan</th>
                        <th>Sumber Pemasukan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>';

  // Fill data
  $no = 1;
  foreach ($hasil as $isi) {
    $html .= '<tr>
                    <td>' . $no . '</td>
                    <td>' . $isi['tanggal'] . '</td>
                    <td>' . $isi['keterangan'] . '</td>
                    <td>' . $isi['sumber'] . '</td>
                    <td>' . number_format($isi['jumlah'], 0, ',', '.') . '</td>
                  </tr>';
    $no++;
  }

  $html .= '</tbody></table>';

  // Print text using writeHTMLCell()
  $pdf->writeHTML($html, true, false, true, false, '');

  // Clear the output buffer before sending headers
  ob_end_clean();

  // Close and output PDF document
  $pdf->Output('Daftar_Pemasukan.pdf', 'D');
  exit;
}

if ($_GET['aksi'] == 'tambah') {
  // Periksa apakah data id, tanggal, keterangan, sumber, dan jumlah sudah dikirim melalui metode POST
  if (isset($_POST['tanggal']) && isset($_POST['keterangan']) && isset($_POST['sumber']) && isset($_POST['jumlah'])) {
    // Ambil nilai-nilai yang diperlukan dari form
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $sumber = $_POST['sumber'];
    $jumlah = $_POST['jumlah'];

    // Buat data yang akan dimasukkan ke database
    $data = array($tanggal, $keterangan, $sumber, $jumlah);

    // Buat query SQL untuk menambahkan data ke dalam tabel pemasukan
    $sql = 'INSERT INTO pemasukan (tanggal, keterangan, sumber, jumlah) VALUES (?, ?, ?, ?)';

    // Persiapkan statement SQL
    $row = $koneksi->prepare($sql);

    // Jalankan statement SQL dengan menggunakan data yang sudah disiapkan
    if ($row->execute($data)) {
      // Jika penambahan data berhasil, tampilkan pesan sukses menggunakan SweetAlert2
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
      echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Sukses Tambah Pemasukkan",
                    }).then(() => {
                        window.location = "pemasukan.php?success=tambah";
                    });
                </script>';
      exit; // Penting untuk menghentikan eksekusi skrip setelah menampilkan alert
    } else {
      // Jika terjadi kesalahan saat menambah data, tampilkan pesan error menggunakan SweetAlert2
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
      echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Gagal Tambah Pemasukkan",
                        text: "Terjadi kesalahan saat menambah data.",
                    }).then(() => {
                        window.location = "tambah.php";
                    });
                </script>';
      exit; // Penting untuk menghentikan eksekusi skrip setelah menampilkan alert
    }
  } else {
    // Jika data yang dibutuhkan tidak ditemukan, redirect kembali ke halaman tambah.php
    header('Location: tambah.php');
    exit;
  }
}


if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
  // Jika permintaan adalah untuk mengedit pemasukan
  $id = $_GET['id'];
  $tanggal = $_POST['tanggal']; // Ambil data nama pemasukan yang baru dari form
  $keterangan = $_POST['keterangan'];
  $sumber = $_POST['sumber'];
  $jumlah = $_POST['jumlah'];

  $sql = "UPDATE pemasukan SET tanggal = ?, keterangan = ?, sumber = ?, jumlah = ?
          WHERE id_pemasukan = ?";
  $row = $koneksi->prepare($sql);
  $row->execute(array($tanggal, $keterangan, $sumber, $jumlah, $id));

  // Tampilkan alert setelah mengedit pemasukan
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo '<script>
        Swal.fire({
            icon: "success",
            title: "Sukses Edit Pemasukan",
        }).then(() => {
            window.location = "pemasukan.php";
        });
    </script>';
}

if (!empty($_GET['aksi'] == 'hapus')) {
  $id = $_GET['id'];

  // Delete product from the database
  $sql = "DELETE FROM pemasukan WHERE id_pemasukan = ?";
  $row = $koneksi->prepare($sql);
  $row->execute(array($id));

  // Success message after deleting product
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo '<script>
      Swal.fire({
          icon: "success",
          title: "Sukses Hapus Pemasukan",
      }).then(() => {
          window.location = "pemasukan.php";
      });
  </script>';
}

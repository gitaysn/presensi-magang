<?php 
session_start();
ob_start();

// Validasi login dan role
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login"); 
  exit;
} else if ($_SESSION["role"] != 'admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
  exit;
}

$judul = "Tambah Data Jurusan";
include('../layout/header.php');
require_once('../../config.php');

if (isset($_POST['submit'])) {
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $pesan_kesalahan = '';

    // Cek method request
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Validasi input kosong
        if (empty($jurusan)) {
            $pesan_kesalahan = "Nama jurusan wajib diisi";
        }

        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = $pesan_kesalahan;
            header("Location: tambah.php"); // Redirect kembali ke halaman form
            exit;
        } else {
            // Escape string sebelum query
            $jurusan = mysqli_real_escape_string($connection, $jurusan);

            // Insert data ke database
            $result = mysqli_query($connection, "INSERT INTO jurusan(jurusan) VALUES ('$jurusan')");
            $_SESSION['berhasil'] = "Data berhasil disimpan";
            header("Location: jurusan.php");
            exit;
        }
    }
}
?>
        
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
          
            <div class="card col-md-6">
                <div class="card-body">

                <form action="<?= base_url('admin/data_jurusan/tambah.php') ?>" method="POST">

                    <div class="mb-3">
                        <label for="">Nama Jurusan</label>
                        <input type="text" class="form-control" name="jurusan">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </form>

                </div>
            </div>
          </div>
        </div>

<?php include('../layout/footer.php') ?> 
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

$judul = "Tambah Data Bidang Penempatan";
include('../layout/header.php');
require_once('../../config.php');

if (isset($_POST['submit'])) {
    $bidang = htmlspecialchars($_POST['bidang']);
    $pesan_kesalahan = '';

    // Cek method request
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Validasi input kosong
        if (empty($bidang)) {
            $pesan_kesalahan = "Bidang jurusan wajib diisi";
        }

        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = $pesan_kesalahan;
        } else {
            $result = mysqli_query($connection, "INSERT INTO bidang(bidang) VALUES ('$bidang')");
            $_SESSION['berhasil'] = "Data berhasil disimpan";
            header("Location: bidang_penempatan.php");
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

                <form action="<?= base_url('admin/data_bidang_penempatan/tambah.php') ?>" method="POST">

                    <div class="mb-3">
                        <label for="">Bidang Penempatan</label>
                        <input type="text" class="form-control" name="bidang">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </form>

                </div>
            </div>
          </div>
        </div>

<?php include('../layout/footer.php') ?> 
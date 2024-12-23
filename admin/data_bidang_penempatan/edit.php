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

$judul = "Edit Data Bidang Penempatan";
include('../layout/header.php');
require_once('../../config.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $bidang = htmlspecialchars($_POST['bidang']);

    // Cek method request
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Validasi input kosong
        if (empty($bidang)) {
            $pesan_kesalahan = "Bidang penempatan wajib diisi";
        }

        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = $pesan_kesalahan;
        } else {
            $result = mysqli_query($connection, "UPDATE bidang SET bidang='$bidang' WHERE id=$id");
            $_SESSION['berhasil'] = "Data berhasil diupdate";
            header("Location: bidang_penempatan.php");
            exit;
        }
    }
}

//$id = $_GET['id'];
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = mysqli_query($connection, "SELECT * FROM bidang WHERE id=$id");

while($bidang = mysqli_fetch_array($result)) {
    $bidang_penempatan = $bidang['bidang'];
}
?>
        
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
          
            <div class="card col-md-6">
                <div class="card-body">

                <form action="<?= base_url('admin/data_bidang_penempatan/edit.php') ?>" method="POST">

                    <div class="mb-3">
                        <label for="">Bidang Penempatan</label>
                        <input type="text" class="form-control" name="bidang" value="<?= $bidang_penempatan ?>"> 
                    </div>
                    <input type="hidden" value="<?= $id ?>" name="id">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>

                </div>
            </div>
          </div>
        </div>

<?php include('../layout/footer.php') ?> 
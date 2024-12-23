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

$judul = "Edit Data Jurusan";
include('../layout/header.php');
require_once('../../config.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $jurusan = htmlspecialchars($_POST['jurusan']);

    // Cek method request
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Validasi input kosong
        if (empty($jurusan)) {
            $pesan_kesalahan = "Nama jurusan wajib diisi";
        }

        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = $pesan_kesalahan;
        } else {
            $result = mysqli_query($connection, "UPDATE jurusan SET jurusan='$jurusan' WHERE id=$id");
            $_SESSION['berhasil'] = "Data berhasil diupdate";
            header("Location: jurusan.php");
            exit;
        }
    }
}

//$id = $_GET['id'];
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = mysqli_query($connection, "SELECT * FROM jurusan WHERE id=$id");

while($jurusan = mysqli_fetch_array($result)) {
    $nama_jurusan = $jurusan['jurusan'];
}
?>
        
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
          
            <div class="card col-md-6">
                <div class="card-body">

                <form action="<?= base_url('admin/data_jurusan/edit.php') ?>" method="POST">

                    <div class="mb-3">
                        <label for="">Nama Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" value="<?= $nama_jurusan ?>"> 
                    </div>
                    <input type="hidden" value="<?= $id ?>" name="id">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>

                </div>
            </div>
          </div>
        </div>

<?php include('../layout/footer.php') ?> 
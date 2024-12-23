<?php 
session_start();
if(!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login"); 
} else if($_SESSION["role"] != 'admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Detail Mahasiswa";
include('../layout/header.php');
require_once('../../config.php');

$id = $_GET['id'];
$result = mysqli_query($connection, "SELECT users.id_mahasiswa, users.username, users.password, users.
status, users.role, mahasiswa.* FROM users JOIN mahasiswa ON users.id_mahasiswa = mahasiswa.id WHERE mahasiswa.id=$id");
?> 

<?php while($mahasiswa= mysqli_fetch_array($result)) : ?>

        <!-- Page body -->
<div class="page-body d-flex align-items-center justify-content-center">
  <div class="container-xl">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

                    <table class="table">
                        <tr>
                            <td>Nama</td>
                            <td>: <?= $mahasiswa['nama'] ?></td>
                        </tr>

                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>: <?= $mahasiswa['jenis_kelamin'] ?></td>
                        </tr>

                        <tr>
                            <td>No. Handphone</td>
                            <td>: <?= $mahasiswa['no_handphone'] ?></td>
                        </tr>

                        <tr>
                            <td>Jurusan</td>
                            <td>: <?= $mahasiswa['jurusan'] ?></td>
                        </tr>

                        <tr>
                            <td>Bidang</td>
                            <td>: <?= $mahasiswa['bidang'] ?></td>
                        </tr>

                        <tr>
                            <td>Username</td>
                            <td>: <?= $mahasiswa['username'] ?></td>
                        </tr>

                        <tr>
                            <td>Role</td>
                            <td>: <?= $mahasiswa['role'] ?></td>
                        </tr>

                        <tr>
                            <td>Lokasi Presensi</td>
                            <td>: <?= $mahasiswa['lokasi_presensi'] ?></td>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <td>: <?= $mahasiswa['status'] ?></td>
                        </tr>
                    </table>
        
                    </div>
                </div>
            </div>
          </div>

            </div>
        </div>

    <?php endwhile; ?>

    <?php include('../layout/footer.php') ?>
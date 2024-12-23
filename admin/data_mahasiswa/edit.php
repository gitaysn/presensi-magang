<?php 
session_start();
ob_start();
if(!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login"); 
} else if($_SESSION["role"] != 'admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Edit Mahasiswa";
include('../layout/header.php');
require_once('../../config.php');

if(isset($_POST['edit'])) {

    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $no_handphone = htmlspecialchars($_POST['no_handphone']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $bidang = htmlspecialchars($_POST['bidang']);
    $username = htmlspecialchars($_POST['username']);
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);
    $lokasi_presensi = htmlspecialchars($_POST['lokasi_presensi']);

    // Cek password, jika kosong pakai password lama
    if(empty($_POST['password'])) {
        $password = $_POST['password_lama'];
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty($nama)) {
            $pesan_kesalahan[]= "<i class='fa-solid fa-check'></i> Nama wajib diisi";
        }
        if(empty($jenis_kelamin)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jenis kelamin wajib diisi";
        }
        if(empty($no_handphone)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> No. handphone wajib diisi";
        }
        if(empty($jurusan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jurusan wajib diisi";
        }
        if(empty($bidang)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Bidang wajib diisi";
        }
        if(empty($username)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Username wajib diisi";
        }
        if(empty($role)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Role wajib diisi";
        }
        if(empty($status)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Status wajib diisi";
        }
        if(empty($lokasi_presensi)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Lokasi presensi wajib diisi";
        }
        if ($_POST['password'] != $_POST['ulangi_password']) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password tidak cocok";
        }        
        
        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            // Update data mahasiswa
            $mahasiswa = mysqli_query($connection, "UPDATE mahasiswa SET
                nama = '$nama',
                jenis_kelamin = '$jenis_kelamin',
                no_handphone = '$no_handphone',
                jurusan = '$jurusan',
                bidang = '$bidang',
                lokasi_presensi = '$lokasi_presensi'
            WHERE id = '$id'");

            // Cek jika update mahasiswa berhasil
            if (!$mahasiswa) {
                $_SESSION['error'] = "Terjadi kesalahan saat mengupdate data mahasiswa: " . mysqli_error($connection);
                exit;
            }

            // Update data user (username, password, status, role)
            $user = mysqli_query($connection, "UPDATE users SET
                username = '$username',
                password = '$password',
                status = '$status',
                role = '$role'
            WHERE id_mahasiswa = '$id'");

            // Cek jika update user berhasil
            if (!$user) {
                $_SESSION['error'] = "Terjadi kesalahan saat mengupdate data user: " . mysqli_error($connection);
                exit;
            }

            $_SESSION['berhasil'] = 'Data berhasil diupdate';
            header("Location: mahasiswa.php");
            exit; 
        }
    } 
}

$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = mysqli_query($connection, "SELECT users.id_mahasiswa, users.username, users.password, users.status, users.role, mahasiswa.* FROM users JOIN mahasiswa ON users.id_mahasiswa = mahasiswa.id WHERE mahasiswa.id = $id");

while($mahasiswa = mysqli_fetch_array($result)) {
    $nama = $mahasiswa['nama'];
    $jenis_kelamin = $mahasiswa['jenis_kelamin'];
    $no_handphone = $mahasiswa['no_handphone'];
    $jurusan = $mahasiswa['jurusan'];
    $bidang = $mahasiswa['bidang'];
    $username = $mahasiswa['username'];
    $password = $mahasiswa['password'];
    $status = $mahasiswa['status'];
    $lokasi_presensi = $mahasiswa['lokasi_presensi'];
    $role = $mahasiswa['role'];
}

?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <form action="<?= base_url('admin/data_mahasiswa/edit.php') ?>" method="POST" enctype="multipart/form-data">

            <div class="row">
                <!-- Kiri: Data Mahasiswa -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?= $nama ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">---Pilih Jenis Kelamin---</option>
                                    <option <?php if ($jenis_kelamin == 'Laki-laki') echo 'selected'; ?> value="Laki-laki">Laki-laki</option>
                                    <option <?php if ($jenis_kelamin == 'Perempuan') echo 'selected'; ?> value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">No Handphone</label>
                                <input type="text" class="form-control" name="no_handphone" value="<?= $no_handphone ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Jurusan</label>
                                <select name="jurusan" class="form-control">
                                    <option value="">---Pilih Jurusan---</option>
                                    <?php  
                                    $ambil_jurusan = mysqli_query($connection, "SELECT * FROM jurusan ORDER BY jurusan ASC");
                                    
                                    while ($row = mysqli_fetch_assoc($ambil_jurusan)) {
                                        $nama_jurusan = $row['jurusan'];
                                        
                                        if ($jurusan == $nama_jurusan) {
                                            echo '<option value="' . $nama_jurusan . '" selected>' . $nama_jurusan . '</option>';
                                        } else {
                                            echo '<option value="' . $nama_jurusan . '">' . $nama_jurusan . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Bidang</label>
                                <select name="bidang" class="form-control">
                                    <option value="">---Pilih Bidang Penempatan---</option>
                                    <?php  
                                    $ambil_bidang = mysqli_query($connection, "SELECT * FROM bidang ORDER BY bidang ASC");
                                    
                                    while ($row = mysqli_fetch_assoc($ambil_bidang)) {
                                        $nama_bidang = $row['bidang'];
                                        
                                        if ($bidang == $nama_bidang) {
                                            echo '<option value="' . $nama_bidang . '" selected>' . $nama_bidang . '</option>';
                                        } else {
                                            echo '<option value="' . $nama_bidang . '">' . $nama_bidang . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">---Pilih Status---</option>
                                    <option <?php if ($status == 'Aktif') echo 'selected'; ?> value="Aktif">Aktif</option>
                                    <option <?php if ($status == 'Tidak Aktif') echo 'selected'; ?> value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Data Login dan Presensi -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Username</label>
                                <input type="text" class="form-control" name="username" value="<?= $username ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="hidden" value="<?= $password; ?>" name="password_lama">
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="">Ulangi Password</label>
                                <input type="password" class="form-control" name="ulangi_password">
                            </div>

                            <div class="mb-3">
                                <label for="">Role</label>
                                <select name="role" class="form-control">
                                    <option value="">---Pilih Role---</option>
                                    <option <?php if ($role == 'admin') echo 'selected'; ?> value="admin">Admin</option>
                                    <option <?php if ($role == 'mahasiswa') echo 'selected'; ?> value="mahasiswa">Mahasiswa</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Lokasi Presensi</label>
                                <select name="lokasi_presensi" class="form-control">
                                    <option value="">---Pilih Lokasi Presensi---</option>
                                    <?php  
                                    $ambil_lok_presensi = mysqli_query($connection, "SELECT * FROM lokasi_presensi ORDER BY nama_lokasi ASC");
                                    
                                    while ($lokasi = mysqli_fetch_assoc($ambil_lok_presensi)) {
                                        $nama_lokasi = $lokasi['nama_lokasi'];
                                        
                                        if ($lokasi_presensi == $nama_lokasi) {
                                            echo '<option value="' . $nama_lokasi . '" selected>' . $nama_lokasi . '</option>';
                                        } else {
                                            echo '<option value="' . $nama_lokasi . '">' . $nama_lokasi . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <input type="hidden" value="<?= $id ?>" name="id">

                            <button type="submit" class="btn btn-primary" name="edit">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include('../layout/footer.php') ?>
<?php 
session_start();
ob_start();
if(!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login"); 
} else if($_SESSION["role"] != 'admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Tambah Mahasiswa";
include('../layout/header.php');
require_once('../../config.php');

if(isset($_POST['submit'])) {
 
    $ambil_kode = mysqli_query($connection, "SELECT kode FROM mahasiswa ORDER BY kode DESC LIMIT 1");
    if (mysqli_num_rows($ambil_kode) > 0) {
        $row = mysqli_fetch_assoc($ambil_kode);
        $kode_db = $row['kode'];
        $kode_db = explode("-", $kode_db);
        $no_baru = (int)$kode_db[1] + 1;
        $kode_baru = "MAH-" . str_pad($no_baru, 4, 0, STR_PAD_LEFT);
    } else {
        $kode_baru = "MAH-0001";
    }
    
    $kode = $kode_baru;
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $no_handphone = htmlspecialchars($_POST['no_handphone']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $bidang = htmlspecialchars($_POST['bidang']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);
    $lokasi_presensi = htmlspecialchars($_POST['lokasi_presensi']);

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
        if(empty($password)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password wajib diisi";
        }
        if($_POST['password'] != $_POST['ulangi_password']) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password tidak cocok";
        }
        
        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $mahasiswa = mysqli_query($connection, "INSERT INTO mahasiswa(kode, nama, jenis_kelamin, no_handphone, jurusan, bidang, lokasi_presensi) VALUES ('$kode', '$nama', '$jenis_kelamin', '$no_handphone', '$jurusan', '$bidang', '$lokasi_presensi')");

            $id_mahasiswa = mysqli_insert_id($connection);
            $user = mysqli_query($connection, "INSERT INTO users(id_mahasiswa, username, password, status, role) VALUES ('$id_mahasiswa', '$username ', '$password', '$status', '$role')");

            $_SESSION['berhasil'] = 'Data berhasil disimpan';
            header("Location: mahasiswa.php");
            exit; 
        }
    } 
}

?>

        <!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <form action="<?= base_url('admin/data_mahasiswa/tambah.php') ?>" method="POST" enctype="multipart/form-data">

            <div class="row">
                <!-- Kiri: Data Mahasiswa -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?php if (isset($_POST['nama'])) echo $_POST['nama'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">---Pilih Jenis Kelamin---</option>
                                    <option <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?> value="Laki-laki">Laki-laki</option>
                                    <option <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?> value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">No Handphone</label>
                                <input type="text" class="form-control" name="no_handphone" value="<?php if (isset($_POST['no_handphone'])) echo $_POST['no_handphone'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Jurusan</label>
                                <select name="jurusan" class="form-control">
                                    <option value="">---Pilih Jurusan---</option>
                                    <?php  
                                    $ambil_jurusan = mysqli_query($connection, "SELECT * FROM jurusan ORDER BY jurusan ASC");
                                    while ($jurusan = mysqli_fetch_assoc($ambil_jurusan)) {
                                        $nama_jurusan = $jurusan['jurusan'];
                                        if (isset($_POST['jurusan']) && $_POST['jurusan'] == $nama_jurusan) {
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
                                    while ($bidang = mysqli_fetch_assoc($ambil_bidang)) {
                                        $nama_bidang = $bidang['bidang'];
                                        if (isset($_POST['bidang']) && $_POST['bidang'] == $nama_bidang) {
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
                                    <option <?php if (isset($_POST['status']) && $_POST['status'] == 'Aktif') echo 'selected'; ?> value="Aktif">Aktif</option>
                                    <option <?php if (isset($_POST['status']) && $_POST['status'] == 'Tidak Aktif') echo 'selected'; ?> value="Tidak Aktif">Tidak Aktif</option>
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
                                <input type="text" class="form-control" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Password</label>
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
                                    <option <?php if (isset($_POST['role']) && $_POST['role'] == 'admin') echo 'selected'; ?> value="admin">Admin</option>
                                    <option <?php if (isset($_POST['role']) && $_POST['role'] == 'mahasiswa') echo 'selected'; ?> value="mahasiswa">Mahasiswa</option>
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
                                        if (isset($_POST['lokasi_presensi']) && $_POST['lokasi_presensi'] == $nama_lokasi) {
                                            echo '<option value="' . $nama_lokasi . '" selected>' . $nama_lokasi . '</option>';
                                        } else {
                                            echo '<option value="' . $nama_lokasi . '">' . $nama_lokasi . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


    <?php include('../layout/footer.php') ?>
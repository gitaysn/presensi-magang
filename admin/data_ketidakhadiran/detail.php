<?php 
session_start();
ob_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login"); 
    exit;
} elseif ($_SESSION["role"] != 'admin') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
    exit;
}

$judul = "Detail Ketidakhadiran";
include('../layout/header.php');
require_once('../../config.php');

// Validasi jika ID tidak ditemukan
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $connection->prepare("SELECT k.id, k.keterangan, k.status_pengajuan, k.tanggal, m.nama AS nama_mahasiswa 
                                  FROM ketidakhadiran k
                                  JOIN mahasiswa m ON k.id_mahasiswa = m.id
                                  WHERE k.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $keterangan = $data['keterangan'];
        $status_pengajuan = $data['status_pengajuan'];
        $tanggal = $data['tanggal'];
        $nama_mahasiswa = $data['nama_mahasiswa'];
    } else {
        // Jika ID tidak ditemukan
        header("Location: ketidakhadiran.php");
        exit;
    }
} else {
    // Jika ID tidak ada
    header("Location: ketidakhadiran.php");
    exit;
}

// Proses update status pengajuan
if (isset($_POST['update'])) {
    $status_pengajuan = $_POST['status_pengajuan'];

    // Update status pengajuan menggunakan prepared statement
    $stmt = $connection->prepare("UPDATE ketidakhadiran SET status_pengajuan = ? WHERE id = ?");
    $stmt->bind_param("si", $status_pengajuan, $id);
    $stmt->execute();

    $_SESSION['berhasil'] = 'Status pengajuan berhasil diupdate';
    header("Location: ketidakhadiran.php");
    exit; 
}

?>

<div class="page-body">
    <div class="container-xl">
        <form action="" method="POST">
            <div class="card col-md-6">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= $tanggal; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="">Nama Mahasiswa</label>
                        <input type="text" class="form-control" name="nama_mahasiswa" value="<?= $nama_mahasiswa; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" value="<?= $keterangan; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="">Status Pengajuan</label>
                        <select name="status_pengajuan" class="form-control">
                            <option value="">---Pilih Status---</option>
                            <option <?= ($status_pengajuan == 'PENDING') ? 'selected' : ''; ?> value="PENDING">PENDING</option>
                            <option <?= ($status_pengajuan == 'REJECTED') ? 'selected' : ''; ?> value="REJECTED">REJECTED</option>
                            <option <?= ($status_pengajuan == 'APPROVED') ? 'selected' : ''; ?> value="APPROVED">APPROVED</option>
                        </select>
                    </div>

                    <input type="hidden" name="id" value="<?= $id ?>">

                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include('../layout/footer.php'); ?>

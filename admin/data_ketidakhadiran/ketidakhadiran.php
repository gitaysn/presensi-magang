<?php 
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login"); 
    exit;
} elseif ($_SESSION["role"] != 'admin') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
    exit;
}

$judul = "Data Ketidakhadiran";
include('../layout/header.php');
require_once('../../config.php');

// Query dengan JOIN
$result = mysqli_query($connection, "
    SELECT 
        ketidakhadiran.id,
        ketidakhadiran.tanggal,
        ketidakhadiran.keterangan,
        ketidakhadiran.deskripsi,
        ketidakhadiran.file,
        ketidakhadiran.status_pengajuan,
        mahasiswa.nama AS nama_mahasiswa
    FROM ketidakhadiran
    JOIN mahasiswa ON ketidakhadiran.id_mahasiswa = mahasiswa.id
    ORDER BY ketidakhadiran.id DESC
");

?>

<div class="page-body">
    <div class="container-xl">
        
    <table class="table table-bordered mt-2">
        <tr class="text-center">
            <th>No.</th>
            <th>Tanggal</th>
            <th>Nama Mahasiswa</th>
            <th>Keterangan</th>
            <th>Deskripsi</th>
            <th>File</th>
            <th>Status Pengajuan</th>
        </tr>

        <?php if (mysqli_num_rows($result) == 0) : ?>
            <tr>
                <td colspan="7">Data ketidakhadiran masih kosong</td>
            </tr>
        <?php else : ?>
            <?php $no = 1; ?>
            <?php while ($data = mysqli_fetch_array($result)) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d F Y', strtotime($data['tanggal'])) ?></td>
                    <td><?= $data['nama_mahasiswa'] ?></td>
                    <td><?= $data['keterangan'] ?></td>
                    <td><?= $data['deskripsi'] ?></td>
                    <td class="text-center">
                        <a target="_blank" href="<?= base_url('assets/file_ketidakhadiran/'.$data['file'])?>" class="badge bg-primary">Download</a>
                    </td>
                    <td class="text-center">
                        <?php
                        $status_class = [
                            'PENDING' => 'bg-warning',
                            'REJECTED' => 'bg-danger',
                            'APPROVED' => 'bg-success',
                        ];
                        ?>
                        <a class="badge <?= $status_class[$data['status_pengajuan']] ?>" href="<?= base_url('admin/data_ketidakhadiran/detail.php?id='.$data['id']) ?>">
                            <?= $data['status_pengajuan'] ?>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>

    </div>
</div>

<?php include('../layout/footer.php'); ?>

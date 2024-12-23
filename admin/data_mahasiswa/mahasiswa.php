<?php 
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Data Mahasiswa";
include('../layout/header.php');
require_once('../../config.php');

// Cek apakah ada parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Cek jumlah data per halaman (default 10)
$entries = isset($_GET['entries']) ? (int)$_GET['entries'] : 10;
$entries = in_array($entries, [10, 25, 50, 100]) ? $entries : 10;

// Cek halaman aktif (default 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = $page > 0 ? $page : 1;

// Hitung offset untuk query
$offset = ($page - 1) * $entries;

// Query dasar
$query = "SELECT users.id_mahasiswa, users.username, users.password, users.status, users.role, mahasiswa.* 
          FROM users 
          JOIN mahasiswa ON users.id_mahasiswa = mahasiswa.id";

// Tambahkan klausa WHERE jika ada pencarian
if ($search != '') {
    $query .= " WHERE mahasiswa.nama LIKE '%$search%' 
                OR mahasiswa.jurusan LIKE '%$search%' 
                OR mahasiswa.bidang LIKE '%$search%' 
                OR users.username LIKE '%$search%'";
}

// Tambahkan ORDER BY untuk memastikan 'admin' tetap di atas, kemudian urutkan mahasiswa berdasarkan nama A-Z
$query .= " ORDER BY 
            CASE 
                WHEN users.role = 'admin' THEN 0 
                ELSE 1 
            END, 
            mahasiswa.nama ASC"; // Mengurutkan nama mahasiswa A-Z setelah admin

// Tambahkan LIMIT untuk pagination
$query .= " LIMIT $offset, $entries";

// Eksekusi query
$result = mysqli_query($connection, $query);

// Hitung total data untuk pagination
$total_query = "SELECT COUNT(*) as total FROM users JOIN mahasiswa ON users.id_mahasiswa = mahasiswa.id";
if ($search != '') {
    $total_query .= " WHERE mahasiswa.nama LIKE '%$search%' 
                      OR mahasiswa.jurusan LIKE '%$search%' 
                      OR mahasiswa.bidang LIKE '%$search%' 
                      OR users.username LIKE '%$search%'";
}
$total_result = mysqli_query($connection, $total_query);
$total_data = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_data / $entries);

if (!$result) {
    die("Query gagal: " . mysqli_error($connection));
}
?> 

<style>
    /* Form Pencarian */
    .search-form {
        max-width: 300px;
    }

    .search-input {
        width: 100%;
    }

    /* Container untuk tombol, dropdown, dan form pencarian */
    .action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between; /* Menjaga elemen berada di posisi kiri dan kanan */
        margin-bottom: 1rem;
    }

    .entries-dropdown {
        display: flex;
        align-items: center;
        margin-right: 10px; /* Menambahkan jarak antara dropdown dan pencarian */
        border-radius: 5px;
        background-color: #f8f9fa; /* Warna latar belakang untuk dropdown */
        padding: 5px 15px;
    }

    .entries-dropdown select {
        width: 100px; /* Mengatur dropdown menjadi lebih kecil */
        padding: 8px 12px; /* Padding dalam dropdown */
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #ffffff; /* Warna latar belakang dropdown */
        transition: border-color 0.2s ease-in-out;
    }

    /* Gaya saat dropdown dipilih */
    .entries-dropdown select:focus {
        border-color: #007bff; /* Border berubah saat fokus */
        outline: none;
    }

    /* Menambahkan style untuk label */
    .entries-dropdown label {
        margin-right: 10px;
        font-size: 14px;
    }
</style>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">

        <!-- Tombol Tambah Data, Dropdown, dan Form Pencarian -->
        <div class="action-bar">
            <a href="<?= base_url('admin/data_mahasiswa/tambah.php') ?>" class="btn btn-primary">
                <span class="text"><i class="fa-solid fa-circle-plus"></i> Tambah Data</span>
            </a>

            <div class="entries-dropdown">
                <form method="GET" action="">
                    <label for="entries">Tampilkan</label>
                    <select id="entries" name="entries" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="10" <?= $entries == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= $entries == 25 ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= $entries == 50 ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= $entries == 100 ? 'selected' : '' ?>>100</option>
                    </select>
                    <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                </form>
            </div>

            <form action="" method="GET" class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control search-input" placeholder="Cari mahasiswa..." value="<?= htmlspecialchars($search) ?>" aria-label="Cari mahasiswa...">
                    <input type="hidden" name="entries" value="<?= $entries ?>">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i> Cari</button>
                </div>
            </form>
        </div>

        <table class="table table-bordered mt-3">
            <tr class="text-center">
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Jurusan</th>
                <th>Bidang Penempatan</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>

            <?php if (mysqli_num_rows($result) === 0) { ?>
                <tr>
                    <td colspan="8">Data kosong, silahkan tambahkan data baru</td>
                </tr>
            <?php } else { ?>
                <?php 
                $no = $offset + 1;
                while ($mahasiswa = mysqli_fetch_array($result)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $mahasiswa['kode'] ?></td>
                        <td><?= $mahasiswa['nama'] ?></td>
                        <td><?= $mahasiswa['username'] ?></td>
                        <td><?= $mahasiswa['jurusan'] ?></td>
                        <td><?= $mahasiswa['bidang'] ?></td>
                        <td><?= ucwords($mahasiswa['role']) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/data_mahasiswa/detail.php?id=' . $mahasiswa['id']) ?>" class="badge bg-primary">Detail</a>
                            <a href="<?= base_url('admin/data_mahasiswa/edit.php?id=' . $mahasiswa['id']) ?>" class="badge bg-primary">Edit</a>
                            <a href="<?= base_url('admin/data_mahasiswa/hapus.php?id=' . $mahasiswa['id']) ?>" class="badge bg-danger tombol-hapus">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile ?>
            <?php } ?>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-3">
            <nav>
                <ul class="pagination">
                    <!-- Tombol Sebelumnya -->
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>" style="margin-right: 3px;">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&entries=<?= $entries ?>&search=<?= htmlspecialchars($search) ?>" 
                           style="border: 1px solid #0056b3; padding: 5px 15px; border-radius: 5px; background-color: #0056b3; color: white; font-weight: bold;">
                            Sebelumnya
                        </a>
                    </li>

                    <!-- Halaman -->
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>" style="margin-right: 3px;">
                            <a class="page-link" href="?page=<?= $i ?>&entries=<?= $entries ?>&search=<?= htmlspecialchars($search) ?>" 
                               style="border: 1px solid #0056b3; padding: 5px 15px; border-radius: 5px; background-color: #ffffff; color: #0056b3; font-weight: bold;">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Tombol Selanjutnya -->
                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>" style="margin-left: 3px;">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&entries=<?= $entries ?>&search=<?= htmlspecialchars($search) ?>" 
                           style="border: 1px solid #0056b3; padding: 5px 15px; border-radius: 5px; background-color: #0056b3; color: white; font-weight: bold;">
                            Selanjutnya
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>

<?php include('../layout/footer.php') ?>

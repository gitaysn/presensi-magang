<?php 
session_start();

if(!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
  exit(); // Tambahkan exit untuk memastikan script berhenti setelah header
}

// Cek apakah peran pengguna adalah 'admin'
if($_SESSION["role"] !== 'admin') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
  exit(); // Tambahkan exit untuk memastikan script berhenti setelah header
}

$judul = "Home";
include('../layout/header.php');

// Query untuk total mahasiswa aktif
$mahasiswa = mysqli_query($connection, "
    SELECT mahasiswa.*, users.status 
    FROM mahasiswa 
    JOIN users ON mahasiswa.id = users.id_mahasiswa 
    WHERE users.status = 'Aktif' AND users.role = 'mahasiswa'
");
$total_mahasiswa_aktif = mysqli_num_rows($mahasiswa);

// Query untuk total mahasiswa hadir
$mahasiswa_hadir = mysqli_query($connection, "SELECT COUNT(*) AS total_hadir FROM presensi WHERE tanggal_masuk = CURDATE()");
$data_hadir = mysqli_fetch_assoc($mahasiswa_hadir);
$total_mahasiswa_hadir = $data_hadir['total_hadir'];

// Query untuk total mahasiswa alfa (absen)
$mahasiswa_alfa = mysqli_query($connection, "
    SELECT COUNT(*) AS total_alfa 
    FROM mahasiswa 
    JOIN users ON mahasiswa.id = users.id_mahasiswa 
    WHERE users.status = 'Aktif' 
    AND users.role = 'mahasiswa'  -- Pastikan role adalah 'mahasiswa'
    AND mahasiswa.id NOT IN (
        SELECT id_mahasiswa 
        FROM presensi 
        WHERE tanggal_masuk = CURDATE()
    )
");

$data_alfa = mysqli_fetch_assoc($mahasiswa_alfa);
$total_mahasiswa_alfa = $data_alfa['total_alfa'];

// Query for total mahasiswa with izin, sakit, and dinas luar statuses
$mahasiswa_izin_sakit_dinas_luar = mysqli_query($connection, "
    SELECT COUNT(*) AS total_izin_sakit_dinas_luar
    FROM mahasiswa 
    JOIN users ON mahasiswa.id = users.id_mahasiswa 
    WHERE users.status IN ('Izin', 'Sakit', 'Dinas Luar')  -- Use IN to match multiple values
    AND users.role = 'mahasiswa'  -- Ensure role is 'mahasiswa'
    AND mahasiswa.id NOT IN (
        SELECT id_mahasiswa 
        FROM presensi 
        WHERE tanggal_masuk = CURDATE()
    )
");

$data_izin_sakit_dinas_luar = mysqli_fetch_assoc($mahasiswa_izin_sakit_dinas_luar);
$total_mahasiswa_izin_sakit_dinas_luar = $data_izin_sakit_dinas_luar['total_izin_sakit_dinas_luar'];

?> 
        
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-12">
                <div class="row row-cards">
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Total Mahasiswa Aktif
                            </div>
                            <div class="text-secondary">
                              <?= $total_mahasiswa_aktif . ' Mahasiswa' ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M15 19l2 2l4 -4" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Jumlah Hadir
                            </div>
                            <div class="text-secondary">
                              <?= $total_mahasiswa_hadir . ' Mahasiswa' ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-question"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" /><path d="M19 22v.01" /><path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Jumlah Alpa
                            </div>
                            <div class="text-secondary">
                              <?= $total_mahasiswa_alfa . ' Mahasiswa' ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Jumlah Sakit, Izin & DL
                            </div>
                            <div class="text-secondary">
                              <?= $total_mahasiswa_izin_sakit_dinas_luar . ' Mahasiswa' ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php include('../layout/footer.php') ?> 
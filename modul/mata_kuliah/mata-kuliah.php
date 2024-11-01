<?php
    session_start();

    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    }
    
    require '../../koneksi.php';
    $nim = $_SESSION['nim_mahasiswa'];
    if ($_SESSION['level'] == 'admin'){
    $query = "SELECT 
            jadwal.id,
            kelas.nama_kelas,
            matkul.kode_mk,
            matkul.nama_matkul,
            dosen.nama AS nama_dosen,
            ruang.nama_ruang,
            CONCAT(jadwal.jam_mulai, ' - ', jadwal.jam_selesai) AS waktu,
            CONCAT(jadwal.prodi, ' - ', kelas.nama_kelas) AS kelas,
            jadwal.hari
          FROM 
            jadwal 
          JOIN 
            kelas ON jadwal.id_kelas = kelas.id
          JOIN 
            matkul ON jadwal.kode_mk = matkul.kode_mk
          JOIN 
            dosen ON matkul.id_dosen = dosen.id
          JOIN 
            ruang ON matkul.id_ruang = ruang.id";
    }else{
      $query = "SELECT 
            jadwal.id,
            kelas.nama_kelas,
            matkul.kode_mk,
            matkul.nama_matkul,
            dosen.nama AS nama_dosen,
            ruang.nama_ruang,
            CONCAT(jadwal.jam_mulai, ' - ', jadwal.jam_selesai) AS waktu,
            CONCAT(jadwal.prodi, ' - ', kelas.nama_kelas) AS kelas,
            jadwal.hari
          FROM 
            jadwal 
          JOIN 
            kelas ON jadwal.id_kelas = kelas.id
          JOIN 
            matkul ON jadwal.kode_mk = matkul.kode_mk
          JOIN 
            dosen ON matkul.id_dosen = dosen.id
          JOIN 
            ruang ON matkul.id_ruang = ruang.id
          JOIN
            mahasiswa ON jadwal.id_kelas = mahasiswa.id_kelas
          WHERE mahasiswa.nim = '$nim' ORDER BY jadwal.hari";
    }
    $result = $db->query($query);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>

    <!-- Favicons -->
  <link href="../assets/img/Logo Ti.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>


<body>
    
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="#" class="logo d-flex align-items-center">
    <img src="../assets/img/Logo Ti.png" alt="">
    <span class="d-none d-lg-block">Tekinfo</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number"></span>
      </a><!-- End Notification Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
          Kamu tidak memiliki notifikasi 
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat semua</span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

      </ul><!-- End Notification Dropdown Items -->

    </li><!-- End Notification Nav -->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-chat-left-text"></i>
        <span class="badge bg-success badge-number"></span>
      </a><!-- End Messages Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
        <li class="dropdown-header">
          Kamu belum memiliki pesan
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat semua</span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        

      </ul><!-- End Messages Dropdown Items -->

    </li><!-- End Messages Nav -->

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="../assets/img/icon.jpg" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2"><?=   $_SESSION['nama']?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6><?=   $_SESSION['nama']?></h6>
          <span><?=   $_SESSION['level']?></span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="../../profil.php">
            <i class="bi bi-person"></i>
            <span>Profil saya</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <i class="bi bi-gear"></i>
            <span>Pengaturan Akun</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <i class="bi bi-question-circle"></i>
            <span>Butuh bantuan?</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="../../logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link collapsed" href="../../index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Mahasiswa</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <?php
      if ($_SESSION['level'] == 'admin') {
      ?>
      <li>
        <a href="../mahasiswa/data-mahasiswa.php" >
          <i class="bi bi-circle"></i><span>Data Mahasiswa</span>
        </a>
      </li>
      <li>
        <a href="../mahasiswa/input-mahasiswa.php">
          <i class="bi bi-circle"></i><span>Input Data</span>
        </a>
      </li>
      <?php
      } elseif ($_SESSION['level'] == 'user') { 
      ?>
      <!-- Jika pengguna adalah user, tampilkan item menu berikut -->
      <li>
        <a href="../absensi/halaman-presensi.php">
          <i class="bi bi-circle"></i><span>Presensi</span>
        </a>
      </li>
    <?php
      } // akhir if
    ?>
    </ul>
  </li><!-- End Mahasiswa Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Dosen</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="../dosen/data-dosen.php" >
          <i class="bi bi-circle"></i><span>Data Dosen</span>
        </a>
      </li>
      <?php
      if ($_SESSION['level']=='admin'){
      ?>
      <li>
        <a href="../dosen/input-dosen.php">
          <i class="bi bi-circle"></i><span>Input Data</span>
        </a>
      </li>
      <?php } ?>
    </ul>
  </li><!-- End Dosen Nav -->

  <li class="nav-item">
    <a class="nav-link " data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Mata Kuliah</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
      <li>
        <a href="#" class="active">
          <i class="bi bi-circle"></i><span>Jadwal Mata Kuliah</span>
        </a>
      </li>
      <?php
      if ($_SESSION['level']=='admin'){
      ?>
      <li>
        <a href="input-matakuliah.php">
          <i class="bi bi-circle"></i><span>Input mata kuliah</span>
        </a>
      </li>
      <li>
        <a href="../jadwal/input_jadwal.php" >
          <i class="bi bi-circle"></i><span>Input Jadwal</span>
        </a>
      </li>
      <?php } ?>
    </ul>
  </li><!-- End Mata Kuliah Nav -->

  <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Laporan Kehadiran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../kehadiran/catatan-harian.php">
              <i class="bi bi-circle"></i><span>Catatan Harian</span>
            </a>
          </li>
          <li>
            <a href="../kehadiran/kompensasi.php">
              <i class="bi bi-circle"></i><span>Kompensasi</span>
            </a>
          </li>
        </ul>
      </li><!-- End Laporan kehadrian Nav -->

  <li class="nav-heading">Pages</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="../../profil.php">
      <i class="bi bi-person"></i>
      <span>Profil</span>
    </a>
  </li><!-- End Profile Page Nav -->


  <li class="nav-item">
    <a class="nav-link collapsed" href="#">
      <i class="bi bi-envelope"></i>
      <span>Kontak</span>
    </a>
  </li><!-- End Contact Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="../../buat-akun.php">
      <i class="bi bi-card-list"></i>
      <span>Register</span>
    </a>
  </li><!-- End Register Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="../../login.php">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Login</span>
    </a>
  </li><!-- End Login Page Nav -->


</ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
      <h1 text-align="center">Daftar Mata Kuliah</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../../index.php">Home</a></li>
          <li class="breadcrumb-item ">Mata Kuliah</li>
          <li class="breadcrumb-item active">Jadwal Mata Kuliah</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

      <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Daftar Mata Kuliah</h5>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Kelas</th>
                    <th>Kode Matkul</th>
                    <th>Mata Kuliah</th>
                    <th>Waktu</th>
                    <th>Dosen</th>
                    <th>Ruangan</th>
                    <?php
                    if ($_SESSION['level']=='admin'){
                    ?>
                    <th></th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $nomor = 1;
                  foreach ($result as $row): ?>
                    <tr>
                      <td><?= $nomor++ ?></td>
                      <td><?= $row['hari'] ?></td>
                      <td><?= $row['kelas'] ?></td>
                      <td><?= $row['kode_mk'] ?></td>
                      <td><?= $row['nama_matkul'] ?></td>
                      <td><?= $row['waktu'] ?></td>
                      <td><?= $row['nama_dosen'] ?></td>
                      <td><?= $row['nama_ruang'] ?></td>
                      <?php
                      if ($_SESSION['level']=='admin'){
                      ?>
                      <td>
                        <!-- Tambahkan link Edit dan Hapus sesuai kebutuhan -->
                        <a class="badge bg-warning" href="edit_jadwal.php?id=<?php echo $row['id']?>">Edit</a>
                      </td>
                      <?php } ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

</main>

<!-- --------------------- -->

    <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
</body>

</html>
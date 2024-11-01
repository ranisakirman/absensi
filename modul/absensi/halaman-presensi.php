<?php
    session_start();

    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    }
    include '../../koneksi.php';
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sistem = time();
    $hari_sekarang = strftime('%A');
    $nim = $_SESSION['nim_mahasiswa'];
    
    

    $hari_sekarang = translateDayToIndonesian($hari_sekarang);
    $sql = "SELECT j.*
        FROM jadwal j
        INNER JOIN mahasiswa m ON j.id_kelas = m.id_kelas
        WHERE m.nim = ? AND j.hari = ? AND j.jam_mulai <= FROM_UNIXTIME(?) AND j.jam_selesai >= FROM_UNIXTIME(?)";
        
        $statement = $db->prepare($sql);
        $statement->bind_param("ssii", $nim, $hari_sekarang, $waktu_sistem, $waktu_sistem);
        $statement->execute();

        
        $result = $statement->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        
        $jam_mulai = date('Y-m-d H:i:s',strtotime($row['jam_mulai']));
        $jam_selesai = date('Y-m-d H:i:s',strtotime($row['jam_selesai']));

        //echo "Waktu Database Mulai: $jam_mulai<br>";
        //echo "Waktu Database Selesai: $jam_selesai<br>";
        //echo "Waktu Database Sistem: $waktu_sistem<br>";

        if ($waktu_sistem >= strtotime($jam_mulai) && $waktu_sistem <= strtotime($jam_selesai)) {
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
            <link href="style.css" rel="stylesheet">


            <script>
              function getLocationAndSubmit() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            // Mengisi nilai latitude dan longitude pada input tersembunyi
                            document.getElementById("latitude").value = position.coords.latitude;
                            document.getElementById("longitude").value = position.coords.longitude;

                            // Mengirim formulir setelah mendapatkan lokasi
                            document.getElementById("presensiForm").submit();
                        },
                        function (error) {
                            handleLocationError(error);
                        }
                    );
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
              }
              function handleLocationError(error) {
                  switch(error.code) {
                      case error.PERMISSION_DENIED:
                          alert("User denied the request for Geolocation.");
                          break;
                      case error.POSITION_UNAVAILABLE:
                          alert("Location information is unavailable.");
                          break;
                      case error.TIMEOUT:
                          alert("The request to get user location timed out.");
                          break;
                      case error.UNKNOWN_ERROR:
                          alert("An unknown error occurred.");
                          break;
                  }
              }
          </script>
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
                <a class="nav-link " data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>Mahasiswa</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <?php
                  if ($_SESSION['level'] == 'admin') {
                  ?>
                  <!-- Jika pengguna adalah admin, tampilkan item menu berikut -->
                  <li>
                    <a href="../mahasiswa/data-mahasiswa.php">
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
                    <a href="#" class="active">
                      <i class="bi bi-circle" class="active"></i><span>Presensi</span>
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
                    <a href="../dosen/data-dosen.php">
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
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-layout-text-window-reverse"></i><span>Mata Kuliah</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                    <a href="../mata_kuliah/mata-kuliah.php">
                      <i class="bi bi-circle"></i><span>Jadwal Mata Kuliah</span>
                    </a>
                  </li>
                  <?php
                  if ($_SESSION['level']=='admin'){
                  ?>
                  <li>
                    <a href="../mata_kuliah/input-matakuliah.php">
                      <i class="bi bi-circle"></i><span>Input mata kuliah</span>
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
                <a class="nav-link collapsed" href="buat-akun.php">
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
                  <h1 text-align="center">Presensi</h1>
                  <nav>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="../../index.php">Home</a></li>
                      <li class="breadcrumb-item ">Mahasiswa</li>
                      <li class="breadcrumb-item active">Pengisian Presensi</li>
                    </ol>
                  </nav>
                </div><!-- End Page Title -->

                <section class="section">
                  <div class="row">
                    <div class="col-lg-12">

                      <div class="card">
                        <div class="card-body">
                          <form method='post' action=''>
                          <h5 class="card-title">Pengambilan Presensi</h5>
                          <?php
                            $idMahasiswa = $_SESSION['nim_mahasiswa'];

                            $data = "SELECT m.nama, m.prodi, k.nama_kelas FROM mahasiswa m JOIN kelas k ON m.id_kelas = k.id WHERE nim=?";
                            $jadwal = "SELECT j.id, j.kode_mk, mk.nama_matkul, j.hari, j.jam_mulai, j.jam_selesai 
                                        FROM jadwal j LEFT JOIN mahasiswa m ON j.id_kelas = m.id_kelas LEFT JOIN matkul mk ON j.kode_mk = mk.kode_mk 
                                        WHERE m.nim = ? AND j.hari = '$hari_sekarang' AND j.jam_mulai <= NOW() AND j.jam_selesai >= NOW()";

                            $statementData = $db->prepare($data);
                            $statementJadwal = $db->prepare($jadwal);

                            $statementData->bind_param("s", $idMahasiswa);
                            $statementJadwal->bind_param("s", $idMahasiswa);

                            $statementData->execute();
                            $hasil = $statementData->get_result();

                            while ($row = $hasil->fetch_assoc()) {
                                echo "<div class='record'>";
                                echo "<p>Nama Mahasiswa = " . $row["nama"] . "</p>";
                                echo "<p>Prodi = " . $row["prodi"] . "</p>";
                                echo "<p>Kelas = " . $row["nama_kelas"] . "</p>";
                                echo "</div>";
                            }

                            $statementData->close();

                            echo "<form method='post' action='' id='presensiForm'>";

                            $statementJadwal->execute();
                            $hasilJadwal = $statementJadwal->get_result();

                            while ($row = $hasilJadwal->fetch_assoc()) {
                                $idJadwal = $row["id"];
                                $cekStatusQuery = "SELECT * FROM kehadiran WHERE id_mhs = ? AND id_jadwal = ?";
                                $statementCekStatus = $db->prepare($cekStatusQuery);
                                $statementCekStatus->bind_param("ss", $idMahasiswa, $idJadwal);
                                $statementCekStatus->execute();

                                $hasilCekStatus = $statementCekStatus->get_result();

                                if ($hasilCekStatus->num_rows > 0) {
                                    echo "<div class='record'>";
                                    echo "<p>Anda sudah mengirim kehadiran untuk mata kuliah saat ini.</p>";
                                    echo "</div>";
                                } else {
                                  
                                    echo "<div class='record'>";
                                    echo "<p>Nama Mata Kuliah = " . $row["nama_matkul"] . "</p>";
                                    echo "<p>Hari = " . $row["hari"] . "</p>";
                                    echo "<p>Jam Mulai = " . $row["jam_mulai"] . "</p>";
                                    echo "<p>Jam Selesai = " . $row["jam_selesai"] . "</p>";
                                    echo "<input type='hidden' name='id_jadwal' value='" . $idJadwal . "'>";
                                    echo "</div>";

                                    $statementCekStatus->close();

                                    // Periksa apakah waktu sudah melewati jam_selesai
                                    $jamSelesai = strtotime($row["jam_selesai"]);
                                    if (time() > $jamSelesai) {
                                        $keterangan = 'Alfa';

                                        $kehadiran = "INSERT INTO kehadiran (id_mhs, id_jadwal, tanggal, keterangan) VALUES (?, ?, CURDATE(), ?)";
                                        $statementKehadiran = $db->prepare($kehadiran);
                                        $statementKehadiran->bind_param("sss", $idMahasiswa, $idJadwal, $keterangan);
                                        $statementKehadiran->execute();

                                        if ($statementKehadiran->affected_rows > 0) {
                                            echo "<script>alert('Kehadiran berhasil diinputkan dengan keterangan Alfa');location.href='../kehadiran/catatan-harian.php';</script>";
                                        } else {
                                            echo "Gagal menambahkan data kehadiran: " . $statementKehadiran->error;
                                        }

                                        $statementKehadiran->close();
                                    } else {
                                        // Formulir untuk jenis kehadiran jika waktu masih di dalam rentang jam_mulai dan jam_selesai
                                        echo "<div class='status-radio'>
                                                <input type='radio' id='hadir' name='keterangan' value='Hadir'>
                                                <label for='hadir'><span>Hadir</span></label>

                                                <input type='radio' id='izin' name='keterangan' value='Izin'>
                                                <label for='izin'><span>Izin</span></label>

                                                <input type='radio' id='sakit' name='keterangan' value='Sakit'>
                                                <label for='sakit'><span>Sakit</span></label>

                                                
                                                <input type='hidden' name='latitude' id='latitude' value=''>
                                                <input type='hidden' name='longitude' id='longitude' value=''>
                                                <div class='submit-button-container'>
                                                <button type='button' name='submit' class='submit-button' id='submitButton'>Kirim</button>
                                                </div>
                                              </div>";
                                              ?>
                                              <script>
                                                  document.getElementById('submitButton').addEventListener('click', function() {
                                                      getLocationAndSubmit();
                                                  });
                                              </script>
                                              <?php
                                              if (isset($_POST['submit'])) {
                                                $idJadwal = $_POST["id_jadwal"];
                                                $tanggal = date("Y-m-d");
                                                $keterangan = $_POST['keterangan'];
                                                $latitude = $_POST['latitude'];
                                                $longitude = $_POST['longitude'];
                
                                                $kehadiran = "INSERT INTO kehadiran (id_mhs, id_jadwal, tanggal, keterangan, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)";
                                                $statementKehadiran = $db->prepare($kehadiran);
                                                $statementKehadiran->bind_param("ssssdd", $idMahasiswa, $idJadwal, $tanggal, $keterangan, $latitude, $longitude);
                                                $statementKehadiran->execute();
                
                                                if ($statementKehadiran->affected_rows > 0) {
                                                    echo "<script>alert('Data berhasil diinputkan');location.href='../kehadiran/catatan-harian.php';</script>";
                                                } else {
                                                    echo "Gagal menambahkan data kehadiran: " . $statementKehadiran->error;
                                                }
                
                                                $statementKehadiran->close();
                                            } 
                                    }
                                }
                            }

                            $statementJadwal->close();

                            
                            ?>


                          </form>  
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
        <?php 
          
        }
      }
    }else {
      header("Location: ../../offline.php");
    }
      
  $db->close();
?>



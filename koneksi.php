<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "presensi8";

    $db = new mysqli($host,$username,$password,$database);

    if ($db->connect_error){
        die ("Koneksi gagal!".$db->connect_error);
    }

    function translateDayToIndonesian($englishDay) {
        $dayTranslations = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];
  
        return isset($dayTranslations[$englishDay]) ? $dayTranslations[$englishDay] : $englishDay;
      }
?>
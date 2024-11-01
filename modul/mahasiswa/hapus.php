<?php
    include '../../koneksi.php';


    if (isset($_GET['nim'])) {
        $nim_to_delete = $_GET['nim'];

        // Mulai transaksi
        $db->begin_transaction();

        // Hapus data dari tabel mahasiswa
        $delete_mahasiswa_query = "DELETE FROM mahasiswa WHERE nim = '$nim_to_delete'";
        $result_mahasiswa = $db->query($delete_mahasiswa_query);

        // Hapus data dari tabel user
        $delete_user_query = "DELETE FROM user WHERE nama = (SELECT nama FROM mahasiswa WHERE nim = '$nim_to_delete')";
        $result_user = $db->query($delete_user_query);

        if ($result_mahasiswa && $result_user) {
            header ("Location: data-mahasiswa.php");
            $db->commit(); // Commit transaksi jika keduanya berhasil
        } else  {
            echo "Data gagal dihapus: " . $db->error;
            $db->rollback(); // Rollback transaksi jika salah satunya gagal
        }
     } else {
        echo "NIM tidak ditemukan.";
     }
?>

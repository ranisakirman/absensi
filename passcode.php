<?php

function changePassword($db, $nim, $currentPassword, $newPassword, $renewPassword) {
    // Mengambil password saat ini dari database
    $sql = "SELECT password FROM user WHERE nim_mahasiswa=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $currentPasswordFromDB = $row['password'];

        // Memeriksa apakah password saat ini sesuai (dengan MD5)
        if (md5($currentPassword) === $currentPasswordFromDB) {
            // Memeriksa apakah password baru dan konfirmasi sesuai
            if ($newPassword === $renewPassword) {
                // MD5 hashing untuk password baru
                $md5NewPassword = md5($newPassword);

                // Memperbarui password di dalam database
                $updateSql = "UPDATE user SET password=? WHERE nim_mahasiswa=?";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bind_param("si", $md5NewPassword, $nim);
                $updateStmt->execute();

                // Password berhasil diperbarui
                return "<script>alert('Password berhasil diubah');</script>";
            } else {
                return "<script>alert('Password baru dan konfirmasi tidak sesuai');</script>";
            }
        } else {
            return "<script>alert('Password tidak sesuai');</script>";
        }
    } else {
        return "<script>alert('User tidak ditemukan');</script>";
    }
}
?>

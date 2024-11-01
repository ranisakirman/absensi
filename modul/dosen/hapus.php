<?php

    require '../../koneksi.php';

    $id = $_GET['id'];

    $sql = "DELETE FROM dosen WHERE id='$id'";

    if ($db->query($sql) === TRUE) {
        header ("Location: data-dosen.php");
    }else {
        echo "Gagal menghapus data".$db->error;
    }
?>
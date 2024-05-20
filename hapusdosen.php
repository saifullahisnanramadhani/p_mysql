<?php
// Buka koneksi dengan MySQL
include("koneksi.php");

// Mengecek apakah di URL ada GET idDosen
if (isset($_GET["idDosen"])) {

    // Menyimpan variabel id dari URL ke dalam variabel $idDosen
    $id = $_GET["idDosen"];

    // Jalankan query DELETE untuk menghapus data
    $query = "DELETE FROM t_dosen WHERE idDosen='$id'";
    $hasil_query = mysqli_query($link, $query);

    // Periksa query, apakah ada kesalahan
    if (!$hasil_query) {
        die("Gagal menghapus data: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }

    // Melakukan redirect ke halaman viewdosen.php
    header("location:viewdosen.php");
}
?>
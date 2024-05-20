<?php
// Memanggil file koneksi.php untuk membuat koneksi
include 'koneksi.php';

// Mengecek apakah form telah disubmit
if (isset($_POST['edit'])) {
    // Mengambil data dari form
    $idDosen = $_POST['idDosen'];
    $namaDosen = $_POST['namaDosen'];
    $noHP = $_POST['noHP'];

    // Menjalankan query untuk mengupdate data dosen
    $query = "UPDATE t_dosen SET namaDosen='$namaDosen', noHP='$noHP' WHERE idDosen='$idDosen'";
    $result = mysqli_query($link, $query);

    // Mengecek apakah query berhasil
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    } else {
        // Redirect ke halaman viewdosen.php
        header("location:viewdosen.php");
    }
}
?>
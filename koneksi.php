<?php
  //variabel koneksi dengan database mysql
  $host = "localhost";
  $user = "root";
  $paswd = "";
  $name = "db_pratikum";

  //proses koneksi
  $link = mysqli_connect ($host, $user, $paswd, $name) ;

  //periksa koneksi, jika gagal akan menampilkan pesan error
  if(!$link) {
    die ("Koneksi dengan database gagal: ".mysqli_connect_errno ().
    " - ".mysqli_connect_error()) ;
 }
?>
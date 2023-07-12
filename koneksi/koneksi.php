<?php
  // Informasi koneksi database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "diary";

  // Membuat koneksi ke database
  $koneksi = mysqli_connect($servername, $username, $password, $dbname);

  // Memeriksa koneksi
  if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
  }
?>

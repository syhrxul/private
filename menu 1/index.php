<?php
session_start();
include "../koneksi/koneksi.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Diary App</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      font-family: sans-serif;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="#" onclick="history.back();" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Kembali</a>
    <h1 style="display: inline-block; margin-left: 10px;">Diary App</h1>
    <hr>
    <a href="add_diary.php" class="btn btn-primary">Tambah Diary Baru</a>
    <br><br>
    <?php
      // Mengambil data diary dari database
      $query = "SELECT * FROM diary";
      $result = mysqli_query($koneksi, $query);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<h3>' . $row['title'] . '</h3>';
          echo '<p>Waktu Unggah: ' . $row['upload_time'] . '</p>';
          echo '<p>' . $row['content'] . '</p>';
          echo '<hr>';
        }
      } else {
        echo '<p>Belum ada diary yang ditambahkan.</p>';
      }

      // Menutup koneksi ke database
      mysqli_close($koneksi);
    ?>
  </div>
</body>
</html>

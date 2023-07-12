<?php
  // Menghubungkan dengan database
  include '../koneksi/koneksi.php';

  // Mendapatkan data dari form
  $title = $_POST['title'];
  $content = $_POST['content'];

  // Menggunakan prepared statement untuk mencegah SQL injection
  $query = "INSERT INTO diary (title, content, upload_time) VALUES (?, ?, NOW())";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, "ss", $title, $content);
  mysqli_stmt_execute($stmt);

  // Menutup prepared statement dan koneksi ke database
  mysqli_stmt_close($stmt);
  mysqli_close($koneksi);

  // Mengarahkan kembali ke halaman utama setelah penyimpanan berhasil
  header("Location: index.php");
  exit();
?>

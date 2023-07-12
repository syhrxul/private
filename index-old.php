<?php
// Cek apakah pengguna sudah mengunjungi landing page
$visited_landing = isset($_COOKIE['visited_landing']);

if (!$visited_landing) {
  // Set cookie untuk menandai pengguna telah mengunjungi landing page
  setcookie('visited_landing', true, time() + (86400 * 30), '/'); // Cookie berlaku selama 30 hari
  header("Location: index.html");
  exit(); // Menghentikan eksekusi kode selanjutnya
}
?>
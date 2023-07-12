

<?php
session_start();
include "../koneksi/koneksi.php";

// Jika form edit tabungan di-submit, lakukan validasi dan perbarui data tabungan
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $jumlahTabungan = $_POST["jumlah_tabungan"];
    $namaKeperluan = $_POST["nama_keperluan"];

    // Update data tabungan di database
    $query = "UPDATE tabungan SET jumlah_tabungan = '$jumlahTabungan', nama_keperluan = '$namaKeperluan' WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: lihat_tabungan.php");
        exit();
    } else {
        echo "Terjadi kesalahan. Gagal memperbarui data tabungan.";
    }
} else {
    // Jika parameter id tidak ada, arahkan kembali ke halaman Lihat Tabungan
    if (!isset($_GET['id'])) {
        header("Location: lihat_tabungan.php");
        exit();
    }

    $id = $_GET['id'];

    // Mendapatkan data tabungan berdasarkan id dari database
    $query = "SELECT * FROM tabungan WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    // Memeriksa apakah data tabungan ditemukan
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $jumlahTabungan = $row['jumlah_tabungan'];
        $namaKeperluan = $row['nama_keperluan'];
    } else {
        // Jika data tabungan tidak ditemukan, arahkan kembali ke halaman Lihat Tabungan
        header("Location: lihat_tabungan.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tabungan - Diary App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Tabungan</h1>
        <hr>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="jumlah_tabungan">Jumlah Tabungan</label>
                <input type="number" class="form-control" id="jumlah_tabungan" name="jumlah_tabungan" value="<?php echo $jumlahTabungan; ?>" required>
            </div>
            <div class="form-group">
                <label for="nama_keperluan">Nama Keperluan</label>
                <input type="text" class="form-control" id="nama_keperluan" name="nama_keperluan" value="<?php echo $namaKeperluan; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>

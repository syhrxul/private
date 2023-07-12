<?php
session_start();
include "../koneksi/koneksi.php";

// Mendapatkan data tabungan dari database
$query = "SELECT * FROM tabungan";
$result = mysqli_query($koneksi, $query);

// Inisialisasi variabel untuk menampilkan jumlah total tabungan
$totalTabungan = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lihat Tabungan - Diary App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">

        <a href="../index.html" class="btn btn-secondary">Kembali </a>
        <hr>
        
        <h2>Tambah Tabungan</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="jumlah_tabungan">Jumlah Tabungan</label>
                <input type="number" class="form-control" id="jumlah_tabungan" name="jumlah_tabungan" required>
            </div>
            <div class="form-group">
                <label for="nama_keperluan">Nama Keperluan</label>
                <input type="text" class="form-control" id="nama_keperluan" name="nama_keperluan" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
        
        <?php
        // Jika form penambahan tabungan di-submit, lakukan validasi dan tambahkan data tabungan ke database
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $jumlahTabungan = $_POST["jumlah_tabungan"];
            $namaKeperluan = $_POST["nama_keperluan"];

            // Insert data tabungan ke database
            $insertQuery = "INSERT INTO tabungan (jumlah_tabungan, nama_keperluan) VALUES ('$jumlahTabungan', '$namaKeperluan')";
            $insertResult = mysqli_query($koneksi, $insertQuery);

            if ($insertResult) {
                // Refresh halaman setelah penambahan berhasil
                header("Location: lihat_tabungan.php");
                exit();
            } else {
                echo "Terjadi kesalahan. Gagal menambahkan data tabungan.";
            }
        }
        ?>

        <hr>

        <h1>Lihat Tabungan</h1>
        
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Keperluan</th>
                        <th>Jumlah Tabungan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $row['nama_keperluan']; ?></td>
                            <td><?php echo $row['jumlah_tabungan']; ?></td>
                            <td>
                                <a href="edit_tabungan.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                        <?php $totalTabungan += $row['jumlah_tabungan']; ?>
                        <?php $counter++; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Belum ada tabungan yang tersedia.</p>
        <?php endif; ?>

        <h4>Total Tabungan: <?php echo $totalTabungan; ?></h4>
    </div>
</body>
</html>

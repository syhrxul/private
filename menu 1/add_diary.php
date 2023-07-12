<!DOCTYPE html>
<html>
<head>
  <title>Tambah Diary - Diary App</title>
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
    <h1 style="display: inline-block; margin-left: 10px;">Tambah Diary</h1>
    <hr>
    <form action="save_diary.php" method="POST">
      <div class="form-group">
        <label for="title">Judul</label>
        <input type="text" class="form-control" id="title" name="title" required>
      </div>
      <div class="form-group">
        <label for="content">Isi Diary</label>
        <textarea class="form-control" id="content" name="content" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</body>
</html>

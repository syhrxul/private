<?php
include "../koneksi/koneksi.php";

// Kode untuk menghandle proses upload foto dan video
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "mp4") {
        if ($imageFileType == "heic") {
            // Convert HEIC to JPEG
            $convertedFile = $targetDir . uniqid() . ".jpg";
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $convertedFile)) {
                $filePath = $convertedFile;
                $fileType = "image/jpeg";
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been converted and uploaded as JPEG.";
            } else {
                echo "Sorry, there was an error converting and uploading your file.";
                $uploadOk = 0;
            }
        } elseif ($imageFileType == "mov") {
            // Convert MOV to MP4
            $convertedFile = $targetDir . uniqid() . ".mp4";
            $command = "ffmpeg -i " . $_FILES["fileToUpload"]["tmp_name"] . " " . $convertedFile;
            exec($command);
            if (file_exists($convertedFile)) {
                $filePath = $convertedFile;
                $fileType = "video/mp4";
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been converted and uploaded as MP4.";
            } else {
                echo "Sorry, there was an error converting and uploading your file.";
                $uploadOk = 0;
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, GIF, HEIC, and MOV files are allowed.";
            $uploadOk = 0;
        }
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $filePath = $targetFile;
            $fileType = $_FILES["fileToUpload"]["type"];

            // Simpan informasi file ke database
            $query = "INSERT INTO uploads (file_path, file_type) VALUES ('$filePath', '$fileType')";
            if (mysqli_query($koneksi, $query)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded and saved to the database.";
            } else {
                echo "Sorry, there was an error saving file information to the database.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Ambil daftar file yang diunggah dari database
$query = "SELECT * FROM uploads";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Photos and Videos - My Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: sans-serif;
            margin-top: 20px;
            margin-left: 20px;
        }
        .upload-container {
            margin-bottom: 20px;
        }
        .upload-container img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <a href="../index.html" class="btn btn-secondary">Kembali</a>
    <h1>Upload Photos and Videos</h1>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileToUpload">Select File</label>
            <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload" required>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Upload</button>
    </form>

    <hr>

    <?php if (mysqli_num_rows($result) > 0) : ?>
        <div class="upload-container">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php if ($row['file_type'] === 'image/jpeg' || $row['file_type'] === 'image/png' || $row['file_type'] === 'image/jpg' || $row['file_type'] === 'image/gif') : ?>
                    <img src="<?php echo $row['file_path']; ?>" alt="Uploaded Image">
                <?php elseif ($row['file_type'] === 'video/mp4') : ?>
                    <video width="320" height="240" controls>
                        <source src="<?php echo $row['file_path']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
                <hr>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>No uploads available.</p>
    <?php endif; ?>
</body>
</html>

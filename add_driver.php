<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $plate_number = $_POST['plate_number'];
    $profile_picture = null;

    // Proses upload gambar jika ada
    if (!empty($_FILES['profile_picture']['name'])) {
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
            $profile_picture = $upload_file;
        } else {
            $error = "Gagal mengunggah foto profil!";
        }
    }

    if (!empty($name) && !empty($plate_number)) {
        $query = $pdo->prepare("INSERT INTO drivers (name, plate_number, profile_picture) VALUES (?, ?, ?)");
        $query->execute([$name, $plate_number, $profile_picture]);

        header('Location: index.php');
        exit();
    } else {
        $error = "Nama dan plat nomor tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Driver</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="main-heading">Tambah Driver Baru</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form action="add_driver.php" method="post" enctype="multipart/form-data" class="add-driver-form">
            <label for="name">Nama Driver:</label>
            <input type="text" name="name" id="name" required>

            <label for="plate_number">Plat Nomor:</label>
            <input type="text" name="plate_number" id="plate_number" required>

            <label for="profile_picture">Foto Profil:</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">

            <button type="submit" class="submit-button">Tambah Driver</button>
        </form>

        
    </div>
</body>
</html>

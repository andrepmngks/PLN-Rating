<?php
session_start();
include 'db.php';

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

$error = '';
$success = '';

// Ambil ID driver dari query string
$driver_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data driver dari database
if ($driver_id) {
    $query = $pdo->prepare("SELECT * FROM drivers WHERE id = ?");
    $query->execute([$driver_id]);
    $driver = $query->fetch(PDO::FETCH_ASSOC);

    if (!$driver) {
        header('Location: admin_dashboard.php');
        exit;
    }
} else {
    header('Location: admin_dashboard.php');
    exit;
}

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $plate_number = $_POST['plate_number'];
    $profile_picture = $driver['profile_picture'];

    // Cek apakah file foto profil diupload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['profile_picture']['type'];
        if (in_array($file_type, $allowed_types)) {
            $upload_dir = 'img/';
            $file_name = time() . '_' . $_FILES['profile_picture']['name'];
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
                $profile_picture = $file_name;
            } else {
                $error = 'Gagal mengupload gambar.';
            }
        } else {
            $error = 'Jenis file tidak diperbolehkan.';
        }
    }

    if (!$error) {
        // Update data driver di database
        $query = $pdo->prepare("UPDATE drivers SET name = ?, plate_number = ?, profile_picture = ? WHERE id = ?");
        $query->execute([$name, $plate_number, $profile_picture, $driver_id]);

        $success = 'Driver berhasil diperbarui!';
        echo '<script>
            setTimeout(function() {
                window.location.href = "admin_dashboard.php";
            }, 1000);
        </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Driver - Rating Driver</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="edit-driver-container">
        <h1>Edit Driver</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form action="edit_driver.php?id=<?= $driver_id ?>" method="POST" enctype="multipart/form-data" class="edit-driver-form">
            <div class="form-group">
                <label for="name">Nama Driver:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($driver['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="plate_number">Plat Nomor:</label>
                <input type="text" id="plate_number" name="plate_number" value="<?= htmlspecialchars($driver['plate_number']) ?>" required>
            </div>

            <div class="form-group">
                <label for="profile_picture">Foto Profil:</label>
                <?php if ($driver['profile_picture']): ?>
                    <img src="img/<?= htmlspecialchars($driver['profile_picture']) ?>" alt="Foto Profil" class="driver-profile-small">
                <?php else: ?>
                    <img src="img/default-profile.png" alt="Foto Profil" class="driver-profile-small">
                <?php endif; ?>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg, image/png, image/gif">
            </div>

            <button type="submit" class="submit-button">Perbarui Driver</button>
        </form>

      
    </div>
</body>
</html>

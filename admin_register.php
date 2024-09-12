<?php
session_start();
include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Semua kolom harus diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password tidak cocok!';
    } else {
        // Cek apakah username sudah ada
        $query = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $query->execute([$username]);
        $existingAdmin = $query->fetch(PDO::FETCH_ASSOC);

        if ($existingAdmin) {
            $error = 'Username sudah digunakan!';
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Simpan admin baru ke database
            $query = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $query->execute([$username, $hashedPassword]);

            $success = 'Admin berhasil didaftarkan!';
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Rating Driver</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="registration-container">
        <h1>Admin Registration</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form action="admin_register.php" method="POST" class="registration-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="register-button">Daftar</button>
        </form>
    </div>
</body>
</html>

<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (!empty($username) && !empty($password) && $password === $confirm_password) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        if ($query->rowCount() == 0) {
            // Insert pengguna baru
            $query = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $query->execute([$username, $hashed_password]);

            // Redirect ke halaman login setelah registrasi berhasil
            header('Location: login.php');
            exit();
        } else {
            $error = "Username sudah digunakan!";
        }
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="main-heading">Registrasi</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form action="register.php" method="post" class="register-form">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Konfirmasi Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit" class="submit-button">Daftar</button>
        </form>

        <a class="back-link" href="login.php">Kembali ke Login</a>
    </div>
</body>
</html>

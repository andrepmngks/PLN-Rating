<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Cek apakah username ada di database
    $query = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $query->execute([$username]);
    $admin = $query->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // Jika user ditemukan, cek password
        if (password_verify($password, $admin['password'])) {
            // Jika password benar, set session dan redirect ke dashboard
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: admin_dashboard.php');
            exit;
        } else {
            // Password salah
            $error = 'Username atau password salah!';
        }
    } else {
        // Username tidak ditemukan
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Rating Driver</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="admin_login.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>

        <!-- Tombol Registrasi Admin -->
        <div class="register-link">
            <p><a href="admin_register.php" class="register-button">Registrasi</a></p>
            <a href="index.php" class="back-button" >Kembali</a>
        </div>
    </div>
</body>
</html>

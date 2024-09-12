<?php
session_start();
include 'db.php';

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Ambil data semua driver
$query = $pdo->query("SELECT * FROM drivers");
$drivers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rating Driver</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="admin-dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
        
            <h2>Admin Dashboard</h2>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="ratings.php">Ratings</a></li>
                <li><a href="presentase_driver.php">presentase Driver</a></li>
                <li><a href="komentar_user.php">Hasil Komentar</a></li>
               <li><a href="admin_logout.php">Logout</a></li>
                
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">

            <h2>Daftar Driver</h2>
            <a href="add_driver.php" class="add-button">Tambah Driver Baru</a>
            <table class="driver-table">
                <thead>
                    <tr>
                        <th>Nama Driver</th>
                        <th>Plat Nomor</th>
                        <th>Foto Profil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($drivers as $driver): ?>
                    <tr>
                        <td><?= htmlspecialchars($driver['name']) ?></td>
                        <td><?= htmlspecialchars($driver['plate_number']) ?></td>
                        <td>
                            <?php if ($driver['profile_picture']): ?>
                                <img src="img/<?= htmlspecialchars($driver['profile_picture']) ?>" alt="Foto Profil" class="driver-profile-small">
                            <?php else: ?>
                                <img src="img/1.jpg" alt="Foto Profil" class="driver-profile-small">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_driver.php?id=<?= $driver['id'] ?>" class="edit-button">Edit</a>
                            <a href="delete_driver.php?id=<?= $driver['id'] ?>" class="delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus driver ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                
            </table>
            
        </div>
    </div>
</body>
</html>

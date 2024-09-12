<?php
include 'db.php'; // File koneksi ke database

// Query untuk mengambil komentar dan data terkait
$query = $pdo->query("SELECT drivers.name, ratings.rating, ratings.comment, ratings.created_at 
                      FROM ratings 
                      JOIN drivers ON ratings.driver_id = drivers.id
                      ORDER BY ratings.created_at DESC");

$ratings = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Komentar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Dashboard - Komentar Pengguna</h1>
            <a class="back-button" href="admin_dashboard.php">Kembali ke Dashboard</a>
        </header>
        
        <table class="ratings-table">
            <thead>
                <tr>
                    <th>Nama Driver</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ratings as $rating): ?>
                    <tr>
                        <td><?= htmlspecialchars($rating['name']); ?></td>
                        <td><?= htmlspecialchars($rating['rating']); ?></td>
                        <td><?= htmlspecialchars($rating['comment']); ?></td>
                        <td><?= htmlspecialchars($rating['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

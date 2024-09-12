<?php
include 'db.php';

// Query untuk menghitung total bintang (rata-rata rating) tiap driver
$query = $pdo->query("SELECT drivers.id, drivers.name, AVG(ratings.rating) as average_rating, COUNT(ratings.id) as total_ratings
FROM drivers
LEFT JOIN ratings ON drivers.id = ratings.driver_id
GROUP BY drivers.id");
$drivers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="main-heading">Admin Dashboard</h1>
        
        <!-- Bagian Total Bintang per Driver -->
        <div class="driver-ratings">
            <h2>Total Bintang Tiap Driver</h2>
            <table class="driver-rating-table">
                <thead>
                    <tr>
                        <th>Nama Driver</th>
                        <th>Total Rating</th>
                        <th>Total Bintang (Rata-rata)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($drivers as $driver): ?>
                        <tr>
                            <td><?= htmlspecialchars($driver['name']); ?></td>
                            <td><?= htmlspecialchars($driver['total_ratings']); ?></td>
                            <td>
                                <?php 
                                    $average_rating = number_format($driver['average_rating'], 1); // Format 1 desimal
                                    for ($i = 0; $i < floor($average_rating); $i++): 
                                ?>
                                    ★
                                <?php endfor; ?>
                                <?php if ($average_rating - floor($average_rating) >= 0.5): ?>
                                    ☆
                                <?php endif; ?>
                                (<?= $average_rating; ?>)
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tampilkan fitur lain di dashboard -->
        <a href="admin_dashboard.php" class="btn">Kembali ke Halaman Dashboard</a>
       
    </div>
</body>
</html>

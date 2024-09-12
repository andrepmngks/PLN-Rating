<?php
include 'db.php';
session_start();

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query SQL yang telah diperbarui
$query = $pdo->prepare("SELECT ratings.*, drivers.name, drivers.plate_number, drivers.profile_picture 
    FROM ratings 
    JOIN drivers ON ratings.driver_id = drivers.id 
    WHERE drivers.name LIKE ? OR drivers.plate_number LIKE ?");
$query->execute(["%$search%", "%$search%"]);
$ratings = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Rating - Rating Driver</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="main-heading">Daftar Rating</h1>

        <form action="ratings.php" method="GET" class="search-form">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari driver atau plat nomor...">
            <button type="submit">Cari</button>
            <a class="back-link" href="admin_dashboard.php">Kembali ke Dashboard</a>
        </form>
    
        <ul class="rating-list">
            <?php foreach ($ratings as $rating): ?>
                <li class="rating-item">
                    <?php if ($rating['profile_picture']): ?>
                        <img src="img/<?= htmlspecialchars($rating['profile_picture']) ?>" alt="Foto Profil" class="rating-profile-picture">
                    <?php else: ?>
                        <img src="img/1.jpg" alt="Foto Profil" class="rating-profile-picture">
                    <?php endif; ?>
                    <div class="rating-info">
                        <span class="driver-name"><?= htmlspecialchars($rating['name']) ?></span><br>
                        <span class="driver-plate">Plat Nomor: <?= htmlspecialchars($rating['plate_number']) ?></span><br>
                        <span class="rating-score">Rating: <?= htmlspecialchars($rating['rating']) ?>/5</span><br>
                        
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        
        
    </div>
</body>
</html>

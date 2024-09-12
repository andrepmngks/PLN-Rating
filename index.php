<?php
include 'db.php';

$query = $pdo->query("SELECT * FROM drivers");
$drivers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Driver - Rating Driver</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Background Video -->
    <div class="video-background">
        <video autoplay muted loop id="bg-video">
            <source src="video/3d logo.mp4" type="video/mp4">
           
        </video>
    </div>

    <div class="container">
        
    <h1 class="main-heading">Daftar Driver</h1>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a class="logout-link" href="logout.php">Logout</a>
        <?php endif; ?>

        <ul class="driver-list">
            <?php foreach ($drivers as $driver): ?>
                <li class="driver-item">
                    <?php if ($driver['profile_picture']): ?>
                        <img src="img/<?= htmlspecialchars($driver['profile_picture']) ?>" alt="Foto Profil" class="driver-profile-picture">
                    <?php else: ?>
                        <img src="img/1.jpg" alt="Foto Profil" class="driver-profile-picture">
                    <?php endif; ?>
                    <div class="driver-info">
                        <span class="driver-name"><?= htmlspecialchars($driver['name']) ?></span><br>
                        <span class="driver-plate">Plat Nomor: <?= htmlspecialchars($driver['plate_number']) ?></span>
                        <a class="rate-button" href="rate.php?driver_id=<?= $driver['id'] ?>">Beri Rating</a>
                    </div>
                   
                  
                </li>
                
            <?php endforeach; ?>
        </ul>

        <a class="add-driver-link" href="admin_login.php">Admin</a>
        
        
        </div>
    </div>
</body>
</html>

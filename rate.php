<?php
include 'db.php';

// Mendapatkan ID driver dari URL
$driver_id = $_GET['driver_id'];

// Mendapatkan informasi driver dari database
$query = $pdo->prepare("SELECT * FROM drivers WHERE id = ?");
$query->execute([$driver_id]);
$driver = $query->fetch(PDO::FETCH_ASSOC);

// Memproses form jika di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comfort_rating = $_POST['comfort_rating'];
    $cleanliness_rating = $_POST['cleanliness_rating'];
    $service_rating = $_POST['service_rating'];
    $comment = $_POST['comment'];

    // Simpan data rating ke database
    $query = $pdo->prepare("INSERT INTO ratings (driver_id, rating, comfort_rating, cleanliness_rating, service_rating, comment, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $query->execute([$driver_id, $rating, $comfort_rating, $cleanliness_rating, $service_rating, $comment]);

    // Redirect ke halaman utama setelah submit
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Rating</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="container">
        <center>
        <h2>Beri Rating untuk <?= htmlspecialchars($driver['name']); ?></h2>
</center>
        <form action="" method="POST">
    <!-- Rating Umum -->
    <div class="rating-row">
        <label for="rating">Rating Driver:</label>
        <div class="rating">
            <input type="radio" name="rating" value="5" id="rating-5" required><label for="rating-5">★</label>
            <input type="radio" name="rating" value="4" id="rating-4"><label for="rating-4">★</label>
            <input type="radio" name="rating" value="3" id="rating-3"><label for="rating-3">★</label>
            <input type="radio" name="rating" value="2" id="rating-2"><label for="rating-2">★</label>
            <input type="radio" name="rating" value="1" id="rating-1"><label for="rating-1">★</label>
        </div>
    </div>

    <!-- Rating Kenyamanan -->
    <div class="rating-row">
        <label for="comfort_rating">Kenyamanan:</label>
        <div class="rating">
            <input type="radio" name="comfort_rating" value="5" id="comfort-5" required><label for="comfort-5">★</label>
            <input type="radio" name="comfort_rating" value="4" id="comfort-4"><label for="comfort-4">★</label>
            <input type="radio" name="comfort_rating" value="3" id="comfort-3"><label for="comfort-3">★</label>
            <input type="radio" name="comfort_rating" value="2" id="comfort-2"><label for="comfort-2">★</label>
            <input type="radio" name="comfort_rating" value="1" id="comfort-1"><label for="comfort-1">★</label>
        </div>
    </div>

    <!-- Rating Kebersihan -->
    <div class="rating-row">
        <label for="cleanliness_rating">Kebersihan:</label>
        <div class="rating">
            <input type="radio" name="cleanliness_rating" value="5" id="cleanliness-5" required><label for="cleanliness-5">★</label>
            <input type="radio" name="cleanliness_rating" value="4" id="cleanliness-4"><label for="cleanliness-4">★</label>
            <input type="radio" name="cleanliness_rating" value="3" id="cleanliness-3"><label for="cleanliness-3">★</label>
            <input type="radio" name="cleanliness_rating" value="2" id="cleanliness-2"><label for="cleanliness-2">★</label>
            <input type="radio" name="cleanliness_rating" value="1" id="cleanliness-1"><label for="cleanliness-1">★</label>
        </div>
    </div>

    <!-- Rating Pelayanan -->
    <div class="rating-row">
        <label for="service_rating">Pelayanan:</label>
        <div class="rating">
            <input type="radio" name="service_rating" value="5" id="service-5" required><label for="service-5">★</label>
            <input type="radio" name="service_rating" value="4" id="service-4"><label for="service-4">★</label>
            <input type="radio" name="service_rating" value="3" id="service-3"><label for="service-3">★</label>
            <input type="radio" name="service_rating" value="2" id="service-2"><label for="service-2">★</label>
            <input type="radio" name="service_rating" value="1" id="service-1"><label for="service-1">★</label>
        </div>
    </div>

    <!-- Komentar -->
    <div class="rating-row">
        <label for="comment">Ulasan:</label>
        <textarea name="comment" rows="4" cols="50"></textarea>
    </div>

    <input type="submit" class= "back-button" value="Submit">
    <a href="index.php" class="back-button" >Kembali</a>
</form>
    </div>

   
</body>
</html>

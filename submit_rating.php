<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $driver_id = $_POST['driver_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $query = $pdo->prepare("INSERT INTO ratings (driver_id, rating, review) VALUES (?, ?, ?)");
    $query->execute([$driver_id, $rating, $review]);

    header("Location: ratings.php");
    exit();
}
?>

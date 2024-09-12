<?php
session_start();
include 'db.php';

// Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Ambil ID driver dari parameter URL
$driver_id = $_GET['id'];

// Hapus driver dari database
$query = $pdo->prepare("DELETE FROM drivers WHERE id = ?");
$query->execute([$driver_id]);

// Redirect kembali ke dashboard setelah dihapus
header('Location: admin_dashboard.php');
exit;
?>

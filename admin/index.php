<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<h1>Admin Panel</h1>
<p>Selamat datang, <?= $_SESSION['admin'] ?></p>
<a href="products.php">Kelola Produk</a> | 
<a href="logout.php">Logout</a>

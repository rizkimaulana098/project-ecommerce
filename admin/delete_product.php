<?php
include '../db.php';
session_start();

// Cek login admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Pastikan ada ID produk yang dikirim
if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

// Ambil data produk untuk mendapatkan nama file gambar
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Produk tidak ditemukan!";
    exit;
}

// Hapus gambar dari folder uploads (jika ada)
if ($product['image'] != '' && file_exists("../uploads/" . $product['image'])) {
    unlink("../uploads/" . $product['image']);
}

// Hapus data produk dari database
$delete = mysqli_query($conn, "DELETE FROM products WHERE id=$id");

if ($delete) {
    header("Location: products.php");
    exit;
} else {
    echo "Gagal menghapus produk: " . mysqli_error($conn);
}
?>

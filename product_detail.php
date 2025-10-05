<?php
include 'db.php';
session_start();

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Produk tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $product['name'] ?> - Detail Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">← Kembali</a>
    <h2><?= $product['name'] ?></h2>
    <img src="uploads/<?= $product['image'] ?>" width="200"><br>
    <p>Harga: Rp <?= number_format($product['price'],0,',','.') ?></p>

    <form method="post" action="cart.php?action=add&id=<?= $product['id'] ?>">
        <label>Jumlah:</label>
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit">Tambah ke Keranjang</button>
    </form>
</body>
</html>

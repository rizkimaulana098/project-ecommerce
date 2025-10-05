<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Toko RUNGKAD</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Toko RUNGKAD</h1>
    <a href="cart.php">🛒 Lihat Keranjang</a>
    <a href="admin/login.php">LOGIN</a>
    <div class="product-list">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='product'>
                <img src='uploads/{$row['image']}' width='150'><br>
                <b>{$row['name']}</b><br>
                Rp " . number_format($row['price'], 0, ',', '.') . "<br>
                <a href='product_detail.php?id={$row['id']}'>Detail</a>
            </div>";
        }
        ?>
    </div>
</body>

</html>
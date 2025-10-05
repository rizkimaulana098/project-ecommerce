<?php
session_start();
include 'db.php';

if (empty($_SESSION['cart'])) {
    echo "<p>Keranjang masih kosong. <a href='index.php'>Belanja dulu</a></p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Hitung total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Simpan ke tabel orders
    mysqli_query($conn, "INSERT INTO orders (customer_name, customer_email, customer_phone, total)
                         VALUES ('$name', '$email', '$phone', '$total')");
    $order_id = mysqli_insert_id($conn);

    // Simpan item ke tabel order_items
    foreach ($_SESSION['cart'] as $item) {
        $pid = $item['id'];
        $qty = $item['quantity'];
        $price = $item['price'];
        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price)
                             VALUES ('$order_id', '$pid', '$qty', '$price')");
    }

    // Kosongkan keranjang
    unset($_SESSION['cart']);

    echo "<h2>Checkout berhasil!</h2>";
    echo "<p>Terima kasih sudah berbelanja, <b>$name</b>.</p>";
    echo "<p>ID Pesanan Anda: <b>#$order_id</b></p>";
    echo "<a href='index.php'>Kembali ke Beranda</a>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Checkout</h1>
    <form method="post">
        <label>Nama:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>No. Telepon:</label><br>
        <input type="text" name="phone" required><br><br>

        <button type="submit">Konfirmasi Pesanan</button>
    </form>
</body>
</html>

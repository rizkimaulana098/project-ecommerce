<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id=$id"));
$items = mysqli_query($conn, "SELECT oi.*, p.name FROM order_items oi 
                              JOIN products p ON oi.product_id = p.id
                              WHERE oi.order_id=$id");
?>
<h2>Detail Pesanan #<?= $id ?></h2>
<p><b>Nama:</b> <?= $order['customer_name'] ?></p>
<p><b>Email:</b> <?= $order['customer_email'] ?></p>
<p><b>Telepon:</b> <?= $order['customer_phone'] ?></p>
<p><b>Total:</b> Rp <?= number_format($order['total'], 0, ',', '.') ?></p>
<p><b>Tanggal:</b> <?= $order['created_at'] ?></p>

<table border="1" cellpadding="8">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
    <?php while ($item = mysqli_fetch_assoc($items)) { ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
        </tr>
    <?php } ?>
</table>
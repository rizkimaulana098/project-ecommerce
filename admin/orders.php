<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>
<h2>Daftar Pesanan</h2>
<a href="index.php">← Kembali ke Dashboard</a><br><br>
<table border="1" cellpadding="8">
<tr>
    <th>ID Pesanan</th>
    <th>Nama Pelanggan</th>
    <th>Email</th>
    <th>Telepon</th>
    <th>Total</th>
    <th>Tanggal</th>
    <th>Detail</th>
</tr>
<?php while ($o = mysqli_fetch_assoc($orders)) { ?>
<tr>
    <td>#<?= $o['id'] ?></td>
    <td><?= $o['customer_name'] ?></td>
    <td><?= $o['customer_email'] ?></td>
    <td><?= $o['customer_phone'] ?></td>
    <td>Rp <?= number_format($o['total'],0,',','.') ?></td>
    <td><?= $o['created_at'] ?></td>
    <td><a href="order_detail.php?id=<?= $o['id'] ?>">Lihat</a></td>
</tr>
<?php } ?>
</table>

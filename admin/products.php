<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>
<h2>Daftar Produk</h2>
<a href="add_product.php">Tambah Produk</a>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Gambar</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
            <td><img src="../uploads/<?= $row['image'] ?>" width="70"></td>
            <td>
            <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> |
<a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>

            </td>
        </tr>
    <?php } ?>
</table>
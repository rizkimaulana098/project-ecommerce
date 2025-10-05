<?php
include '../db.php';
if ($_POST) {
    $name  = $_POST['name'];
    $price = $_POST['price'];

    $file = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $file);

    mysqli_query($conn, "INSERT INTO products (name, price, image) VALUES ('$name','$price','$file')");
    header("Location: products.php");
}
?>
<form method="post" enctype="multipart/form-data">
    <h2>Tambah Produk</h2>
    <a href="products.php">KEMBALI</a>
    <br>
    <input type="text" name="name" placeholder="Nama Produk"><br>
    <input type="number" name="price" placeholder="Harga"><br>
    <input type="file" name="image"><br>
    <button type="submit">Simpan</button>
</form>

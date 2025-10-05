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
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Produk tidak ditemukan!";
    exit;
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $price = $_POST['price'];

    // Jika admin tidak mengganti gambar
    if ($_FILES['image']['name'] == '') {
        $file = $product['image'];
    } else {
        // Upload gambar baru
        $file = $_FILES['image']['name'];
        $tmp  = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/" . $file);

        // Hapus gambar lama (opsional)
        if (file_exists("../uploads/" . $product['image']) && $product['image'] != '') {
            unlink("../uploads/" . $product['image']);
        }
    }

    // Update ke database
    $update = mysqli_query($conn, "UPDATE products 
                                   SET name='$name', price='$price', image='$file'
                                   WHERE id=$id");

    if ($update) {
        header("Location: products.php");
        exit;
    } else {
        echo "Gagal mengupdate produk: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Edit Produk</h2>
    <a href="products.php">← Kembali</a>
    <form method="post" enctype="multipart/form-data">
        <label>Nama Produk:</label><br>
        <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="price" value="<?= $product['price'] ?>" required><br><br>

        <label>Gambar Sekarang:</label><br>
        <img src="../uploads/<?= $product['image'] ?>" width="120"><br><br>

        <label>Ganti Gambar (opsional):</label><br>
        <input type="file" name="image"><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>

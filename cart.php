<?php
session_start();
include 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';

if ($action == 'add' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $qty = $_POST['quantity'];

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $item = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $qty,
            'image' => $product['image']
        ];

        // Cek apakah produk sudah ada di keranjang
        $found = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $id) {
                $cart_item['quantity'] += $qty;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item;
        }

        header("Location: cart.php");
        exit;
    }
}

if ($action == 'remove' && isset($_GET['id'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $_GET['id']) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Keranjang Belanja</h1>
    <a href="index.php">← Lanjut Belanja</a>
    <br><br>

    <?php if (empty($_SESSION['cart'])) { ?>
        <p>Keranjang belanja kosong.</p>
    <?php } else { ?>
        <table border="1" cellpadding="8" align="center">
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td>Rp <?= number_format($item['price'],0,',','.') ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>Rp <?= number_format($subtotal,0,',','.') ?></td>
                <td><a href="cart.php?action=remove&id=<?= $item['id'] ?>">Hapus</a></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><b>Total Bayar</b></td>
                <td colspan="2"><b>Rp <?= number_format($total,0,',','.') ?></b></td>
            </tr>
        </table>
        <br>
        <a href="checkout.php"><button>🧾 Lanjut ke Checkout</button></a>
        <button onclick="alert('Checkout berhasil!')">Checkout</button>
    <?php } ?>
</body>
</html>

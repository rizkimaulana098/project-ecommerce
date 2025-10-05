<?php
session_start();
if ($_POST) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user == "admin" && $pass == "1234") {
        $_SESSION['admin'] = $user;
        header("Location: index.php");
        exit;
    } else {
        echo "<p style='color:red;'>Username atau password salah!</p>";
    }
}
?>
<form method="post">
    <h2>Login Admin</h2>
    <input type="text" name="username" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <button type="submit">Login</button>
</form>
s
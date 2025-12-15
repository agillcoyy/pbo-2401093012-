<?php
session_start();
include "koneksi.php";

if (isset($_SESSION["role"]) && ($_SESSION["role"] == "super" || $_SESSION["role"] == "sekolah")) {
    header("location: dashboard_admin.php");
    exit();
}

$login_message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role']; 
            $_SESSION['id_sekolah'] = $data['id_sekolah'];
            
            header("location: dashboard_admin.php");
            exit();
        } else {
            $login_message = "Password Salah.";
        }
    } else {
        $login_message = "Username Tidak Ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-page">
        <div class="form-login" style="border-top: 5px solid #2e7d32;">
             <?php if (!empty($login_message)): ?>
                 <div style="padding: 10px; background-color: #ffe0b2; color: #e65100; margin-bottom: 15px;">
                     <?= $login_message; ?>
                 </div>
             <?php endif; ?>
            
            <form class="login-form" method="post">
                <h2>Login Admin</h2>
                <input type="text" placeholder="Username" name="username" required />
                <input type="password" placeholder="Password" name="password" required/>
                <button type="submit" name="login">Masuk Admin</button>
                <p class="message"><a href="index.php">Kembali ke Home</a></p>
            </form>
        </div>
    </div>
</body>
</html>
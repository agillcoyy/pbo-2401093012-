<?php
session_start();
include "koneksi.php";

// Jika sudah login, lempar ke dashboard
if (isset($_SESSION["role"]) && $_SESSION["role"] == "siswa") {
    header("location: dashboard.php");
    exit();
}

$login_message = "";

if (isset($_POST['login'])) {
    $nisn = $_POST['nisn'];
    $password = $_POST['password'];

    // Cek Siswa
    $stmt = $db->prepare("SELECT * FROM siswa WHERE nisn = ?");
    $stmt->bind_param("s", $nisn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        if (password_verify($password, $data['password'])) {
            // Set Session Lengkap
            $_SESSION['nisn'] = $data['nisn'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['lat'] = $data['lat'];
            $_SESSION['lng'] = $data['lng'];
            $_SESSION['nilai'] = $data['nilai_rata_rata'];
            $_SESSION['role'] = "siswa";
            
            header("location: dashboard.php");
            exit();
        } else {
            $login_message = "Password Salah.";
        }
    } else {
        $login_message = "NISN Tidak Ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-page">
        <div class="form-login">
             <?php if (!empty($login_message)): ?>
                <div style="padding: 10px; background-color: #ffe0b2; color: #e65100; margin-bottom: 15px; border-radius: 5px;">
                    <?= $login_message; ?>
                </div>
            <?php endif; ?>
            
            <form class="login-form" method="post">
                <h2>Login Siswa</h2>
                <input type="text" placeholder="NISN" name="nisn" required />
                <input type="password" placeholder="Password" name="password" required/>
                <button type="submit" name="login">Masuk</button>
                <p class="message">Belum Punya Akun? <a href="register.php">Daftar</a></p>
                <p class="message"><a href="index.php">Kembali ke Home</a></p>
            </form>
        </div>
    </div>
</body>
</html>
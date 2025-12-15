<?php
session_start();
require 'koneksi.php'; // Pastikan $db adalah objek koneksi yang valid (mysqli atau PDO)
$register_message = ""; 

if (isset($_SESSION["is_login"])) {
    // Jika sudah login, arahkan ke dashboard dan hentikan eksekusi script
    // header("location: dashboard.php");
    exit(); 
}

if (isset($_POST['register'])) {
    
    // 1. Ambil dan bersihkan data input (Menggunakan mysqli_real_escape_string untuk mencegah SQL Injection dasar)
    // Asumsi: $db adalah objek koneksi mysqli
    $username= mysqli_real_escape_string($db, $_POST['username']);  
    $password_input = $_POST['password']; // Password mentah dari form
    // 2. Hashing Password untuk keamanan (Wajib) 🔒
    $hash_password = password_hash($password_input, PASSWORD_DEFAULT);

    // 3. Pengecekan Duplikasi NISN (NISN diasumsikan sebagai identifier unik)
    $check_username_query = "SELECT username FROM admin WHERE username = '$username'";
    $check_result = $db->query($check_username_query);

    if ($check_result && $check_result->num_rows > 0) {
        // usernmae sudah terdaftar
        $register_message = "Username sudah terdaftar, silakan login atau gunakan NISN lain!";
    } else {
        // 4. Query INSERT yang Benar dan Aman
        $sql = "INSERT INTO admin (username, password)
                VALUES ('$username', '$hash_password')";

        if ($db->query($sql)) {
            $register_message = "Daftar Akun Berhasil! Silakan <a href='login_admin.php'>Login</a>.";
        } else {
            // Pendaftaran gagal karena alasan database lainnya
            $register_message = "Daftar Akun Gagal: " . $db->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        
        <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
<div class="register-page">
    <div class="form-register">
        <?php if (!empty($register_message)): ?>
            <div class="status-message">
                <?php echo $register_message; ?>
            </div>
        <?php endif; ?>
        
        <form class="register-form" method="POST">
            <h2>Register</h2>
            <input type="text" placeholder="Username *" name="username" required/>
            <input type="password" placeholder="Password *" name="password" required/>

            <button type="submit" name="register">Buat Akun</button>
            <p class="message">Sudah Punya Akun?<a href="login_admin.php"> Login</a></p>
        </form>
    </div>
</div>
</body>
</html>


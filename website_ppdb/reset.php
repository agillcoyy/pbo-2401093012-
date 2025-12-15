<?php
include "koneksi.php";

// 1. Matikan Foreign Key Check (Agar bisa mengosongkan tabel yang saling berelasi)
$db->query("SET FOREIGN_KEY_CHECKS = 0");

// 2. KOSONGKAN TABEL (Reset Data)
// Menghapus semua data siswa
if($db->query("TRUNCATE TABLE siswa")) {
    echo "<p>✅ Tabel Siswa berhasil dikosongkan.</p>";
}

// Menghapus semua data pendaftaran (karena siswa dihapus, pendaftaran juga wajib hapus)
if($db->query("TRUNCATE TABLE pendaftaran")) {
    echo "<p>✅ Tabel Pendaftaran berhasil dikosongkan.</p>";
}

// Menghapus semua akun admin (Super & Sekolah)
if($db->query("TRUNCATE TABLE admin")) {
    echo "<p>✅ Tabel Admin berhasil dikosongkan.</p>";
}

// 3. Hidupkan kembali Foreign Key Check
$db->query("SET FOREIGN_KEY_CHECKS = 1");

// 4. BUAT AKUN SUPER ADMIN BARU
$username = "superadmin";
$password_raw = "superadmin";
$password_hash = password_hash($password_raw, PASSWORD_DEFAULT);

// Query Insert (Role: super, id_sekolah: NULL)
$sql_insert = "INSERT INTO admin (username, password, role, id_sekolah) 
               VALUES ('$username', '$password_hash', 'super', NULL)";

echo "<hr>";

if($db->query($sql_insert)) {
    echo "<h1 style='color:green;'>RESET TOTAL BERHASIL!</h1>";
    echo "<p>Semua akun lama telah dihapus.</p>";
    echo "<div style='border:1px solid #ccc; padding:20px; width:300px; background:#f9f9f9;'>";
    echo "<h3>Akun Super Admin Baru:</h3>";
    echo "Username: <b>$username</b><br>";
    echo "Password: <b>$password_raw</b>";
    echo "</div>";
    echo "<br><a href='login_admin.php' style='padding:10px 20px; background:blue; color:white; text-decoration:none; border-radius:5px;'>Login Admin Sekarang</a>";
} else {
    echo "<h1 style='color:red;'>GAGAL MEMBUAT AKUN:</h1>";
    echo $db->error;
}
?>
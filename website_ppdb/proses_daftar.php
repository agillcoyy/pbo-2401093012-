<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("location: login.php");
    exit();
}

$nisn = $_SESSION['nisn'];
$id_mapping = $_GET['id']; // ID dari tabel sekolah_jurusan
$jarak = $_GET['jarak'];

// Cek duplikat
$cek = $db->query("SELECT id FROM pendaftaran WHERE nisn='$nisn'");
if($cek->num_rows > 0){
    echo "<script>alert('Anda sudah mendaftar!'); window.location='dashboard.php';</script>";
    exit();
}

// Insert awal (Nilai Tes masih 0, Nilai Akhir belum final)
$sql = "INSERT INTO pendaftaran (nisn, id_sekolah_jurusan, jarak_meter, status) 
        VALUES ('$nisn', '$id_mapping', '$jarak', 'pending')";

if($db->query($sql)){
    echo "<script>alert('Berhasil Mendaftar! Segera datang ke sekolah untuk Tes Minat Bakat.'); window.location='dashboard.php';</script>";
} else {
    echo "Error: " . $db->error;
}
?>
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sig";

$db = mysqli_connect($hostname, $username, $password, $database);

if ($db->connect_error) {
    die("Koneksi Gagal: " . $db->connect_error);
}

// Rumus Jarak (Haversine) - Tetap dipakai untuk tie-breaker (nilai sama) & kuota prioritas 10%
function hitungJarak($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371000; 
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}
?>
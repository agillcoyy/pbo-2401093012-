<?php
session_start();
require 'koneksi.php';
$msg = "";

if (isset($_POST['register'])) {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $alamat = $_POST['alamat']; // Menggunakan input teks alamat baru
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $rapor = $_POST['nilai_rapor'];

    $cek = $db->query("SELECT nisn FROM siswa WHERE nisn = '$nisn'");
    if ($cek->num_rows > 0) {
        $msg = "NISN Sudah Terdaftar!";
    } else {
        $sql = "INSERT INTO siswa (nisn, nama, password, alamat, lat, lng, nilai_rapor) 
                VALUES ('$nisn', '$nama', '$pass', '$alamat', '$lat', '$lng', '$rapor')";
        if ($db->query($sql)) {
            echo "<script>alert('Berhasil! Silakan Login.'); window.location='login.php';</script>";
        } else {
            $msg = "Error: " . $db->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register Siswa SMK</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <style> 
        #mapPicker { height: 250px; width: 100%; border-radius: 8px; margin-bottom: 10px; } 
        /* Gaya baru untuk tombol lokasi */
        .btn-location {
            padding: 8px 15px;
            background: #1976d2; /* Warna Biru */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="register-page">
        <div class="form-register">
            <?php if($msg): ?><p style="color:red;"><?= $msg ?></p><?php endif; ?>
            <form method="POST">
                <h2>Daftar Akun Siswa</h2>
                <input type="text" name="nisn" placeholder="NISN" required>
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <input type="text" name="alamat" placeholder="Alamat Sesuai KK (Input Teks)" required>

                <label style="font-size:0.8rem; display:block; text-align:left;">Rerata Nilai Rapor (Sem 1-5):</label>
                <input type="number" step="0.01" name="nilai_rapor" placeholder="Contoh: 85.50" required>

                <p style="text-align:left; font-size:0.8rem; margin-bottom: 5px;">Tentukan Lokasi Rumah (Klik Peta):</p>
                
                <button type="button" class="btn-location" onclick="getLocation()">
                    <i data-feather="crosshair" style="width: 16px; height: 16px;"></i> Gunakan Lokasi Saya
                </button>

                <div id="mapPicker"></div>
                <input type="hidden" name="lat" id="lat" required>
                <input type="hidden" name="lng" id="lng" required>

                <button type="submit" name="register">Daftar</button>
                <p class="message">Sudah punya akun? <a href="login.php">Login</a></p>
                <p class="message"><a href="index.php">Kembali ke Home</a></p>
            </form>
        </div>
    </div>
    <script>
        feather.replace();

        var map = L.map('mapPicker').setView([-0.9400, 100.3550], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker;

        function setMarker(latlng) {
            if(marker) map.removeLayer(marker);
            marker = L.marker(latlng).addTo(map);
            document.getElementById('lat').value = latlng.lat;
            document.getElementById('lng').value = latlng.lng;
            map.setView(latlng, 15);
        }
        
        map.on('click', function(e) {
            setMarker(e.latlng);
        });

        function getLocation() {
            if (navigator.geolocation) {
                alert("Mencari lokasi Anda... (Pastikan Anda mengizinkan akses lokasi)");
                
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }

        function showPosition(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const latlng = { lat: lat, lng: lng };
            
            setMarker(latlng);
            alert("Lokasi Anda berhasil ditemukan!");
        }

        function showError(error) {
            let message = "Terjadi kesalahan saat mendapatkan lokasi.";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message = "Akses lokasi ditolak. Silakan izinkan di pengaturan browser Anda.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    message = "Waktu tunggu habis. Coba lagi atau klik peta.";
                    break;
            }
            alert(message);
        }
    </script>
</body>
</html>
<?php 
session_start();
include 'koneksi.php'; 

// 1. Ambil data sekolah dari Database
$sekolah_data = [];
$query = "SELECT * FROM sekolah";
$result = $db->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['lat'] = (float) $row['lat'];
        $row['lng'] = (float) $row['lng'];
        $sekolah_data[] = $row;
    }
}

$json_sekolah = json_encode($sekolah_data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Sebaran Sekolah - PPDB</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        body { background-color: #f9f9f9; }
        .map-section { margin-top: 8rem; padding: 2rem 7% 4rem 7%; min-height: 80vh; }
        .map-header { text-align: center; margin-bottom: 2rem; }
        .map-header h1 { font-size: 2.2rem; color: #2e7d32; font-weight: 700; margin-bottom: 0.5rem; }
        .map-header p { color: #666; font-size: 1.1rem; }
        
        .map-container-box { background: #fff; padding: 15px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); border: 1px solid #e0e0e0; }
        #map { width: 100%; height: 600px; border-radius: 8px; z-index: 0; }
        .leaflet-pane img { max-width: none !important; max-height: none !important; }
        .map-legend { margin-top: 1rem; text-align: center; color: #555; font-size: 0.9rem; }

        .popup-school { width: 220px; font-family: 'Poppins', sans-serif; text-align: center; }
        .popup-school img { width: 100%; height: 120px; object-fit: cover; border-radius: 6px; margin-bottom: 10px; border: 1px solid #ddd; }
        .popup-school h3 { margin: 0 0 5px 0; color: #2e7d32; font-size: 1rem; font-weight: 700; }
        .popup-school p { font-size: 0.85rem; color: #555; margin-bottom: 10px; }
        .btn-rute { display: inline-block; background-color: #2e7d32; color: white !important; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; width: 100%; box-sizing: border-box; }
        .btn-rute:hover { background-color: #1b5e20; }
        
        @media (max-width: 768px) {
            .map-section { margin-top: 8rem; padding: 1rem 5%; }
            #map { height: 400px; }
            .map-header h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <?php include "layout/header.html"; ?>

    <section class="map-section">
        <div class="map-header">
            <h1>Peta Sebaran SMK Negeri</h1>
            <p>Lokasi dan Informasi Sekolah Menengah Kejuruan Negeri di Kota Padang</p>
        </div>

        <div class="map-container-box">
            <div id="map"></div>
        </div>
        
        <div class="map-legend">
            <p><i data-feather="map-pin"></i> Klik penanda biru untuk melihat Foto & Detail sekolah.</p>
        </div>
    </section>

    <?php include "layout/footer.html"; ?>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        feather.replace();

        // 1. Inisialisasi Peta
        var map = L.map('map').setView([-0.9400, 100.3550], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        setTimeout(function(){ map.invalidateSize();}, 500);

        // 2. Data Sekolah
        var dataSekolah = <?php echo $json_sekolah ?: '[]'; ?>;
        var markers = []; // Array untuk menyimpan semua marker agar bisa dicari

        // 3. Render Marker
        dataSekolah.forEach(function(sekolah) {
            if(sekolah.lat && sekolah.lng) {
                var gambar = sekolah.foto ? 'uploads/' + sekolah.foto : 'img/logo-smk.png';
                var popupContent = `
                    <div class="popup-school">
                        <img src="${gambar}" alt="${sekolah.nama}" onerror="this.src='img/logo-smk.png'">
                        <h3>${sekolah.nama}</h3>
                        <p>${sekolah.alamat}</p>
                        <a href="https://www.google.com/maps/dir/?api=1&destination=${sekolah.lat},${sekolah.lng}" target="_blank" class="btn-rute">
                            Lihat Rute
                        </a>
                    </div>
                `;
                
                var marker = L.marker([sekolah.lat, sekolah.lng]).addTo(map).bindPopup(popupContent);
                
                // Simpan referensi marker untuk fitur pencarian
                markers.push({
                    nama: sekolah.nama,
                    marker: marker
                });
            }
        });

        // 4. LOGIKA PENCARIAN (Menangkap parameter ?cari=... dari URL)
        const urlParams = new URLSearchParams(window.location.search);
        const keyword = urlParams.get('cari');

        if(keyword) {
            // Cari sekolah yang namanya mirip dengan keyword
            const found = markers.find(item => item.nama.toLowerCase().includes(keyword.toLowerCase()));
            
            if(found) {
                // Jika ketemu: Zoom ke lokasi & Buka Popup
                map.setView(found.marker.getLatLng(), 16);
                setTimeout(() => {
                    found.marker.openPopup();
                }, 500); // Delay dikit biar smooth
            } else {
                alert("Sekolah dengan nama '" + keyword + "' tidak ditemukan.");
            }
        }

        // Script Dropdown & Search Toggle
        const loginToggle = document.getElementById('loginToggle');
        const loginMenu = document.getElementById('loginDropdownMenu');
        if(loginToggle){
            loginToggle.addEventListener('click', (e) => { e.preventDefault(); loginMenu.classList.toggle('active'); });
            document.addEventListener('click', (e) => { if(!loginToggle.contains(e.target) && !loginMenu.contains(e.target)) loginMenu.classList.remove('active'); });
        }

        function toggleSearch(e) {
            e.preventDefault();
            const form = document.getElementById('searchForm');
            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>
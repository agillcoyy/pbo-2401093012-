<?php
session_start();
include "koneksi.php";

// Cek Login Siswa
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("location: login.php");
    exit();
}

$nisn = $_SESSION['nisn'];
// Ambil data siswa terbaru
$siswa = $db->query("SELECT * FROM siswa WHERE nisn='$nisn'")->fetch_assoc();

// Cek Status Pendaftaran Siswa
$status_daftar = $db->query("
    SELECT p.*, s.nama as nama_sekolah, j.nama_jurusan, sj.kuota 
    FROM pendaftaran p 
    JOIN sekolah_jurusan sj ON p.id_sekolah_jurusan = sj.id 
    JOIN sekolah s ON sj.id_sekolah = s.id 
    JOIN jurusan j ON sj.id_jurusan = j.id
    WHERE p.nisn = '$nisn'
")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .container { padding: 8rem 7% 2rem; }
        .card { background: white; padding: 25px; margin-bottom: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); color: #333; }
        h3 { border-bottom: 2px solid var(--primary); padding-bottom: 10px; margin-bottom: 20px; color: var(--primary); }
        
        /* Table Styling */
        table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: middle; }
        th { background-color: var(--primary); color: white; font-weight: 600; }
        tr:hover { background-color: #f9f9f9; }

        /* Form Elements inside Table */
        .select-jurusan {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            font-family: inherit;
        }
        .btn-pilih {
            background: var(--primary);
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-pilih:hover { background: #1b4e20; }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <?php include "layout/header-dashboard.html" ?>

    <div class="container">
            <div class="txt-welcome">
            <!-- <h1>Halo, <?= htmlspecialchars($siswa['nama']) ?>!</h1> -->
            <p>Nilai Rapor Anda: <b><?= $siswa['nilai_rapor'] ?></b></p>
        
        </div>
     
        <div class="card">
            <h3>Status Pendaftaran</h3>
            <?php if($status_daftar): ?>
                <table style="border:none;">
                    <tr><td width="200">Sekolah Tujuan</td><td>: <b><?= $status_daftar['nama_sekolah'] ?></b></td></tr>
                    <tr><td>Jurusan</td><td>: <b><?= $status_daftar['nama_jurusan'] ?></b></td></tr>
                    <tr><td>Nilai Akhir</td><td>: <b><?= ($status_daftar['nilai_akhir'] > 0) ? number_format($status_daftar['nilai_akhir'], 2) : 'Menunggu Tes' ?></b></td></tr>
                    <tr><td>Status</td><td>: 
                        <?php 
                            $st = $status_daftar['status'];
                            $bg = ($st == 'diterima') ? 'green' : (($st == 'ditolak') ? 'red' : 'orange');
                        ?>
                        <span class="status-badge" style="background:<?= $bg ?>"><?= strtoupper($st) ?></span>
                    </td></tr>
                </table>
                <div style="margin-top:15px; padding:10px; background:#e8f5e9; border-radius:5px; font-size:0.9rem;">
                    <i data-feather="info" style="width:14px;"></i> <b>Info:</b> Nilai Tes Minat Bakat akan diinput oleh Admin Sekolah setelah Anda mengikuti tes secara offline di sekolah tujuan.
                </div>
            <?php else: ?>
                <p>Anda belum mendaftar. Silakan pilih Sekolah dan Jurusan pada tabel di bawah ini.</p>
            <?php endif; ?>
        </div>

        <div class="card" id="daftar-sekolah">
            <h3>Daftar Sekolah & Jurusan Tersedia</h3>
            <table>
                <thead>
                    <tr>
                        <th width="25%">Nama Sekolah</th>
                        <th width="15%">Jarak</th>
                        <th width="40%">Pilih Jurusan (Kuota)</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 1. Ambil Semua Data Sekolah & Jurusan
                    $query = "SELECT sj.id as id_mapping, s.id as id_sekolah, s.nama as nama_sekolah, j.nama_jurusan, sj.kuota, s.lat, s.lng 
                              FROM sekolah_jurusan sj 
                              JOIN sekolah s ON sj.id_sekolah = s.id 
                              JOIN jurusan j ON sj.id_jurusan = j.id 
                              ORDER BY s.nama ASC, j.nama_jurusan ASC";
                    $res = $db->query($query);

                    // 2. Kelompokkan Data per Sekolah
                    $sekolah_list = [];
                    while($row = $res->fetch_assoc()) {
                        $id_sek = $row['id_sekolah'];
                        
                        // Hitung jarak sekali saja per sekolah
                        if(!isset($sekolah_list[$id_sek])) {
                            $jarak_m = hitungJarak($siswa['lat'], $siswa['lng'], $row['lat'], $row['lng']);
                            $sekolah_list[$id_sek] = [
                                'nama' => $row['nama_sekolah'],
                                'jarak' => $jarak_m,
                                'jurusan' => []
                            ];
                        }
                        // Masukkan jurusan ke sekolah tsb
                        $sekolah_list[$id_sek]['jurusan'][] = [
                            'id_mapping' => $row['id_mapping'],
                            'nama' => $row['nama_jurusan'],
                            'kuota' => $row['kuota']
                        ];
                    }

                    // 3. Urutkan Sekolah Berdasarkan Jarak Terdekat
                    usort($sekolah_list, function($a, $b) {
                        return $a['jarak'] <=> $b['jarak'];
                    });

                    // 4. Tampilkan Tabel
                    foreach($sekolah_list as $sek):
                    ?>
                    <tr>
                        <td><b><?= $sek['nama'] ?></b></td>
                        <td><?= number_format($sek['jarak']/1000, 2) ?> KM</td>
                        
                        <form action="proses_daftar.php" method="GET">
                            <input type="hidden" name="jarak" value="<?= $sek['jarak'] ?>">
                            
                            <td>
                                <select name="id" class="select-jurusan" required>
                                    <option value="" disabled selected>-- Pilih Jurusan --</option>
                                    <?php foreach($sek['jurusan'] as $jur): ?>
                                        <option value="<?= $jur['id_mapping'] ?>">
                                            <?= $jur['nama'] ?> (Kuota: <?= $jur['kuota'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <?php if(!$status_daftar): ?>
                                    <button type="submit" class="btn-pilih" onclick="return confirm('Apakah Anda yakin memilih sekolah dan jurusan ini?')">
                                        Daftar Sekarang
                                    </button>
                                <?php else: ?>
                                    <span style="color:grey; font-style:italic;">Sudah Mendaftar</span>
                                <?php endif; ?>
                            </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>



                </tbody>
            </table>
        </div>
 <section id="contact" class="section-box" style="background-color: #fff;">
        <h2 class="section-title">Kontak Kami</h2>
        <div class="contact-content">
            <p>Memiliki kendala saat mendaftar? Hubungi kami melalui formulir di bawah ini atau kunjungi Dinas Pendidikan Kota Padang.</p>
            
            <form class="contact-form" onsubmit="alert('Pesan terkirim! (Demo)'); return false;">
                <input type="text" placeholder="Nama Lengkap" required>
                <input type="email" placeholder="Alamat Email" required>
                <textarea rows="4" placeholder="Pesan / Kendala Anda" required></textarea>
                <button type="submit">Kirim Pesan</button>
            </form>

            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 15px;">
                <a href="#"><i data-feather="instagram"></i></a>
                <a href="#"><i data-feather="facebook"></i></a>
                <a href="#"><i data-feather="phone"></i></a>
            </div>
        </div>
    </section>


    </div>
    <script>feather.replace();</script>
</body>
</html>
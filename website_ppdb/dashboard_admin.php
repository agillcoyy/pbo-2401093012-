<?php
session_start();
include "koneksi.php";

// Cek Sesi Login
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'super' && $_SESSION['role'] !== 'sekolah')) {
    header("location: login_admin.php");
    exit();
}

$role = $_SESSION['role'];
$id_sekolah_admin = $_SESSION['id_sekolah'] ?? null;

// ==================================================================================
// BAGIAN LOGIC (PHP)
// ==================================================================================

// --- LOGIC SUPER ADMIN ---
if ($role == 'super') {

    // 1. TAMBAH SEKOLAH BARU
    if (isset($_POST['tambah_sekolah'])) {
        $nama = mysqli_real_escape_string($db, $_POST['nama']);
        $alamat = mysqli_real_escape_string($db, $_POST['alamat']);
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];

        // Upload Foto
        $foto_nama = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            
            $file_ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
            $clean_name = strtolower(str_replace(' ', '', $nama));
            $foto_nama = time() . "_" . $clean_name . "." . $file_ext;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto_nama);
        }

        $q = "INSERT INTO sekolah (nama, alamat, lat, lng, foto) VALUES ('$nama', '$alamat', '$lat', '$lng', '$foto_nama')";
        if ($db->query($q)) {
            echo "<script>alert('Sekolah Berhasil Ditambahkan!'); window.location='dashboard_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal: " . $db->error . "');</script>";
        }
    }

    // 2. UPDATE SEKOLAH
    if (isset($_POST['update_sekolah'])) {
        $id = $_POST['id_sekolah'];
        $nama = mysqli_real_escape_string($db, $_POST['nama']);
        $alamat = mysqli_real_escape_string($db, $_POST['alamat']);
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $q_old = $db->query("SELECT foto FROM sekolah WHERE id='$id'");
            $d_old = $q_old->fetch_assoc();
            if ($d_old['foto'] && file_exists("uploads/" . $d_old['foto'])) {
                unlink("uploads/" . $d_old['foto']);
            }

            $target_dir = "uploads/";
            $file_ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
            $clean_name = strtolower(str_replace(' ', '', $nama));
            $foto_nama = time() . "_" . $clean_name . "." . $file_ext;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto_nama);

            $q = "UPDATE sekolah SET nama='$nama', alamat='$alamat', lat='$lat', lng='$lng', foto='$foto_nama' WHERE id='$id'";
        } else {
            $q = "UPDATE sekolah SET nama='$nama', alamat='$alamat', lat='$lat', lng='$lng' WHERE id='$id'";
        }

        if ($db->query($q)) {
            echo "<script>alert('Data Sekolah Berhasil Diupdate!'); window.location='dashboard_admin.php';</script>";
        }
    }

    // 3. HAPUS SEKOLAH
    if (isset($_GET['hapus_sekolah'])) {
        $id = $_GET['hapus_sekolah'];
        $q_old = $db->query("SELECT foto FROM sekolah WHERE id='$id'");
        $d_old = $q_old->fetch_assoc();
        if ($d_old['foto'] && file_exists("uploads/" . $d_old['foto'])) unlink("uploads/" . $d_old['foto']);

        $db->query("DELETE FROM sekolah WHERE id='$id'");
        echo "<script>alert('Sekolah Berhasil Dihapus!'); window.location='dashboard_admin.php';</script>";
    }

    // 4. SETTING JURUSAN & KUOTA
    if (isset($_POST['tambah_jurusan_sekolah'])) {
        $id_sek = $_POST['id_sekolah'];
        $id_jur = $_POST['id_jurusan'];
        $kuota = $_POST['kuota'];

        $cek = $db->query("SELECT id FROM sekolah_jurusan WHERE id_sekolah='$id_sek' AND id_jurusan='$id_jur'");
        if ($cek->num_rows > 0) {
            $db->query("UPDATE sekolah_jurusan SET kuota='$kuota' WHERE id_sekolah='$id_sek' AND id_jurusan='$id_jur'");
            echo "<script>alert('Kuota Jurusan Diupdate!'); window.location='dashboard_admin.php';</script>";
        } else {
            $q = "INSERT INTO sekolah_jurusan (id_sekolah, id_jurusan, kuota) VALUES ('$id_sek', '$id_jur', '$kuota')";
            if ($db->query($q)) echo "<script>alert('Jurusan Ditambahkan!'); window.location='dashboard_admin.php';</script>";
        }
    }

    // 5. BUAT AKUN ADMIN SEKOLAH
    if (isset($_POST['tambah_admin'])) {
        $user = $_POST['username'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $id_sek = $_POST['id_sekolah'];

        $q = "INSERT INTO admin (username, password, role, id_sekolah) VALUES ('$user', '$pass', 'sekolah', '$id_sek')";
        if ($db->query($q)) echo "<script>alert('Akun Admin Dibuat!'); window.location='dashboard_admin.php';</script>";
        else echo "<script>alert('Gagal: Username mungkin sudah ada');</script>";
    }
}

// --- LOGIC ADMIN SEKOLAH ---
if ($role == 'sekolah' && isset($_POST['input_nilai'])) {
    $id_daftar = $_POST['id_daftar'];
    $nilai_tes = $_POST['nilai_tes'];
    $nilai_rapor = $_POST['nilai_rapor'];
    $nilai_akhir = ($nilai_rapor * 0.4) + ($nilai_tes * 0.6);

    $db->query("UPDATE pendaftaran SET nilai_tes_minat='$nilai_tes', nilai_akhir='$nilai_akhir', status='diterima' WHERE id='$id_daftar'");
    echo "<script>alert('Nilai Disimpan!'); window.location='dashboard_admin.php';</script>";
}

// --- PERSIAPAN DATA EDIT ---
$edit_data = null;
if (isset($_GET['edit_sekolah'])) {
    $id_edit = $_GET['edit_sekolah'];
    $edit_data = $db->query("SELECT * FROM sekolah WHERE id='$id_edit'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin PPDB</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* CSS INTERNAL UNTUK PERBAIKAN LAYOUT */
        .container { padding: 8rem 5% 2rem; color:#333; }
        .section { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); scroll-margin-top: 100px; }
        h2 { margin-bottom: 20px; color: var(--primary); border-bottom: 2px solid #eee; padding-bottom: 10px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .full-width { grid-column: span 2; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        input[type="file"] { padding: 7px; background: #f9f9f9; }

        .btn-submit { background: var(--primary); color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-warning { background: #fbc02d; color: #333; }
        .btn-danger { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; }
        .btn-edit { background: #1976d2; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; margin-right: 5px; }
        
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: middle; }
        th { background: var(--primary); color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        
        .thumb-sekolah { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 2px solid #eee; display: block; }
        .badge { padding: 5px 10px; border-radius: 5px; color: white; font-size: 0.8em; }
        .bg-super { background: #d32f2f; }
        .bg-sekolah { background: #1976d2; }
    </style>
</head>
<body>
    
    <nav class="navbar">
      <a href="#" class="navbar-logo">
        <img src="img/logo-smk.png" alt="logo" style="height:40px;"> 
        <img src="img/logo-sumbar.png" alt="logo" style="height:40px;"> 
        <img src="img/logo-kotapadang.png" alt="logo" style="height:40px;"> 
        Panel <span>Admin</span>
      </a>
      
      <div class="navbar-nav">
        <a href="#home">Home</a>
        
        <?php if($role == 'super'): ?>
            <a href="#sekolah">Daftar Sekolah</a>
            <a href="#peserta">Daftar Peserta Didik</a>
            <a href="#admin">Kelola Admin</a>
        <?php endif; ?>

        <?php if($role == 'sekolah'): ?>
            <a href="#validasi">Validasi Pendaftar</a>
        <?php endif; ?>
      </div>

      <div class="navbar-extra">
        <a href="logout.php" id="login" style="color: #333;">
            <i data-feather="log-out"></i> Logout
        </a>
      </div>
    </nav>

    <div class="container" id="home">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h1>Dashboard <span class="badge <?= ($role=='super') ? 'bg-super' : 'bg-sekolah' ?>"><?= ($role=='super') ? 'SUPER ADMIN' : 'ADMIN SEKOLAH' ?></span></h1>
            <?php if($role == 'sekolah'): 
                $nama_sekolah_saya = $db->query("SELECT nama FROM sekolah WHERE id='$id_sekolah_admin'")->fetch_object()->nama;
            ?>
                <h3><?= $nama_sekolah_saya ?></h3>
            <?php endif; ?>
        </div>

        <?php if($role == 'super'): ?>
        
        <div class="section" id="sekolah">
            <h2>1. Kelola Data Sekolah</h2>
            <h3><?= $edit_data ? "Edit Data Sekolah: " . $edit_data['nama'] : "Tambah Sekolah Baru" ?></h3>
            
            <form method="POST" enctype="multipart/form-data">
                <?php if($edit_data): ?>
                    <input type="hidden" name="id_sekolah" value="<?= $edit_data['id'] ?>">
                <?php endif; ?>

                <div class="form-grid">
                    <input type="text" name="nama" placeholder="Nama Sekolah" required value="<?= $edit_data ? $edit_data['nama'] : '' ?>">
                    <input type="text" name="alamat" placeholder="Alamat Lengkap" required value="<?= $edit_data ? $edit_data['alamat'] : '' ?>">
                    <input type="text" name="lat" placeholder="Latitude (-0.xxx)" required value="<?= $edit_data ? $edit_data['lat'] : '' ?>">
                    <input type="text" name="lng" placeholder="Longitude (100.xxx)" required value="<?= $edit_data ? $edit_data['lng'] : '' ?>">
                    
                    <div class="full-width">
                        <label>Foto Sekolah:</label>
                        <input type="file" name="foto" accept="image/*">
                        <?php if($edit_data && $edit_data['foto']): ?>
                            <small>Foto saat ini tersedia. Upload baru untuk mengganti.</small>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($edit_data): ?>
                    <button type="submit" name="update_sekolah" class="btn-submit btn-warning">Update Data</button>
                    <a href="dashboard_admin.php" class="btn-danger" style="padding:10px 20px;">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah_sekolah" class="btn-submit">Simpan Sekolah</button>
                <?php endif; ?>
            </form>

            <div style="margin-top:30px; overflow-x:auto;">
                <h4>Daftar Sekolah Terdaftar:</h4>
                <table style="margin-top:5px;">
                    <thead><tr><th>Foto</th><th>Nama Sekolah</th><th>Alamat</th><th>Koordinat</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php 
                        $q_sek = $db->query("SELECT * FROM sekolah ORDER BY nama ASC");
                        while($sk = $q_sek->fetch_assoc()):
                            $img_src = (!empty($sk['foto']) && file_exists('uploads/'.$sk['foto'])) ? 'uploads/'.$sk['foto'] : 'img/logo-smk.png';
                        ?>
                        <tr>
                            <td><img src="<?= $img_src ?>" class="thumb-sekolah"></td>
                            <td><?= $sk['nama'] ?></td>
                            <td><?= $sk['alamat'] ?></td>
                            <td><?= $sk['lat'] ?>, <?= $sk['lng'] ?></td>
                            <td>
                                <a href="?edit_sekolah=<?= $sk['id'] ?>#sekolah" class="btn-edit"><i data-feather="edit-2" style="width:12px;"></i></a>
                                <a href="?hapus_sekolah=<?= $sk['id'] ?>" class="btn-danger" onclick="return confirm('Hapus sekolah ini?');"><i data-feather="trash" style="width:12px;"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section" id="jurusan">
            <h2>2. Kelola Jurusan & Kuota</h2>
            <form method="POST">
                <div class="form-grid">
                    <select name="id_sekolah" required>
                        <option value="">-- Pilih Sekolah --</option>
                        <?php 
                        $s_res = $db->query("SELECT * FROM sekolah ORDER BY nama ASC");
                        while($s = $s_res->fetch_assoc()){ echo "<option value='{$s['id']}'>{$s['nama']}</option>"; }
                        ?>
                    </select>
                    <select name="id_jurusan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php 
                        $j_res = $db->query("SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
                        while($j = $j_res->fetch_assoc()){ echo "<option value='{$j['id']}'>{$j['nama_jurusan']}</option>"; }
                        ?>
                    </select>
                    <div class="full-width"><input type="number" name="kuota" placeholder="Kuota (ex: 32)" required></div>
                </div>
                <button type="submit" name="tambah_jurusan_sekolah" class="btn-submit">Simpan Kuota</button>
            </form>
        </div>

        <div class="section" id="peserta">
            <h2>3. Daftar Semua Peserta Didik</h2>
            <p>Memantau seluruh siswa yang mendaftar di semua sekolah.</p>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Sekolah Tujuan</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $q_all_siswa = $db->query("SELECT p.*, s.nama as nm_siswa, sek.nama as nm_sekolah, jur.nama_jurusan 
                                                   FROM pendaftaran p
                                                   JOIN siswa s ON p.nisn = s.nisn
                                                   JOIN sekolah_jurusan sj ON p.id_sekolah_jurusan = sj.id
                                                   JOIN sekolah sek ON sj.id_sekolah = sek.id
                                                   JOIN jurusan jur ON sj.id_jurusan = jur.id
                                                   ORDER BY p.tanggal_daftar DESC");
                        
                        if($q_all_siswa->num_rows > 0):
                            while($row = $q_all_siswa->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $row['nisn'] ?></td>
                            <td><?= $row['nm_siswa'] ?></td>
                            <td><?= $row['nm_sekolah'] ?></td>
                            <td><?= $row['nama_jurusan'] ?></td>
                            <td>
                                <?php 
                                    $st = $row['status'];
                                    $color = ($st=='diterima') ? 'green' : (($st=='ditolak') ? 'red' : 'orange');
                                    echo "<b style='color:$color'>".strtoupper($st)."</b>";
                                ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="5" align="center">Belum ada peserta didik yang mendaftar.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section" id="admin">
            <h2>4. Kelola Akun Admin Sekolah</h2>
            <form method="POST">
                <div class="form-grid">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <div class="full-width">
                        <select name="id_sekolah" required>
                            <option value="">-- Pilih Sekolah --</option>
                            <?php 
                            $s_res->data_seek(0);
                            while($s = $s_res->fetch_assoc()){ echo "<option value='{$s['id']}'>{$s['nama']}</option>"; }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="tambah_admin" class="btn-submit">Buat Akun</button>
            </form>
        </div>
        
        <?php endif; ?>

        <?php if($role == 'sekolah'): ?>
        <div class="section" id="validasi">
            <h2>Verifikasi & Input Nilai</h2>
            <p>Silakan input nilai tes minat bakat siswa yang telah hadir di sekolah.</p>
            <table>
                <thead><tr><th>Nama Siswa</th><th>Jurusan</th><th>Rapor (40%)</th><th>Tes (60%)</th><th>Akhir</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.*, s.nama as nm_sis, s.nilai_rapor, j.nama_jurusan FROM pendaftaran p JOIN siswa s ON p.nisn=s.nisn JOIN sekolah_jurusan sj ON p.id_sekolah_jurusan=sj.id JOIN jurusan j ON sj.id_jurusan=j.id WHERE sj.id_sekolah='$id_sekolah_admin' ORDER BY p.status ASC, p.nilai_akhir DESC";
                    $res = $db->query($sql);
                    if($res->num_rows > 0):
                        while($row = $res->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= $row['nm_sis'] ?><br><small><?= $row['nisn'] ?></small></td>
                        <td><?= $row['nama_jurusan'] ?></td>
                        <td><b><?= $row['nilai_rapor'] ?></b></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id_daftar" value="<?= $row['id'] ?>">
                                <input type="hidden" name="nilai_rapor" value="<?= $row['nilai_rapor'] ?>">
                                <input type="number" name="nilai_tes" class="input-nilai" value="<?= $row['nilai_tes_minat'] ?>" min="0" max="100" required>
                        </td>
                        <td><?= number_format($row['nilai_akhir'], 2) ?></td>
                        <td><button type="submit" name="input_nilai" class="btn-submit" style="padding:5px 10px;">Simpan</button></form></td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="6" align="center">Belum ada pendaftar di sekolah ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </div>
    <script>feather.replace();</script>
</body>
</html>
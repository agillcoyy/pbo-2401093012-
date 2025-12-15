<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMPB SMK Padang 2026/2027</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/footer.css">
    <style>
        /* CSS Tambahan Khusus Index */
        .section-title { text-align: center; margin-bottom: 2rem; color: var(--primary); font-size: 2rem; font-weight: 700; }
        .section-box { padding: 4rem 7%; }
        .about-content, .contact-content { text-align: center; max-width: 800px; margin: 0 auto; line-height: 1.6; }
        
        /* Form Kontak Sederhana */
        .contact-form { max-width: 500px; margin: 20px auto; display: flex; flex-direction: column; gap: 10px; }
        .contact-form input, .contact-form textarea { padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .contact-form button { padding: 10px; background: var(--primary); color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <?php include "layout/header.html" ?>
 
    <section class="hero" id="home">
      <main class="content">
        <h1>SPMB <span>SMK</span> <br>Tahun Ajaran 2026/2027</h1>
        <p>Sistem Penerimaan Murid Baru SMK Kota Padang.<br>Siap Mencetak Generasi Unggul & Kompeten.</p>
        <a href="register.php" class="cta">Daftar Sekarang</a>
      </main>
    </section>

    <section id="alur" class="section-box" style="background-color: #fff;">
        <h2 class="section-title">Alur Pendaftaran</h2>
        <div class="about-content">
            <p>Ikuti langkah mudah berikut untuk mendaftar di SMK Negeri Kota Padang:</p>
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
                <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; width: 250px;">
                    <i data-feather="user-plus" style="width: 40px; height: 40px; color: var(--primary);"></i>
                    <h3>1. Daftar Akun</h3>
                    <p>Isi biodata dan nilai rapor semester 1-5.</p>
                </div>
                <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; width: 250px;">
                    <i data-feather="log-in" style="width: 40px; height: 40px; color: var(--primary);"></i>
                    <h3>2. Pilih Jurusan</h3>
                    <p>Login dan pilih Konsentrasi Keahlian yang diminati.</p>
                </div>
                <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; width: 250px;">
                    <i data-feather="check-circle" style="width: 40px; height: 40px; color: var(--primary);"></i>
                    <h3>3. Tes & Verifikasi</h3>
                    <p>Ikuti Tes Minat Bakat di sekolah tujuan untuk validasi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="section-box" style="background-color: #f1f8f4;">
        <h2 class="section-title">Tentang PPDB</h2>
        <div class="about-content">
            <p>
                PPDB SMK Kota Padang Tahun Ajaran <b>2026/2027</b> dilaksanakan secara objektif, transparan, dan akuntabel.
                Seleksi utama menggunakan gabungan <b>Nilai Rapor (40%)</b> dan <b>Tes Minat Bakat (60%)</b>.
                Jalur Zonasi tetap tersedia sebagai prioritas bagi siswa yang tinggal di dekat sekolah (kuota 10%).
            </p>
        </div>
    </section>

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
 
    <?php include "layout/footer.html" ?>
   
    <script>
      feather.replace();

      // LOGIKA DROPDOWN LOGIN
      const loginToggle = document.getElementById('loginToggle');
      const loginDropdownMenu = document.getElementById('loginDropdownMenu');
      
      if(loginToggle){
          loginToggle.addEventListener('click', function(e) {
            e.preventDefault(); 
            loginDropdownMenu.classList.toggle('active'); 
          });

          // Tutup dropdown jika klik di luar
          document.addEventListener('click', function(e) {
            const isLoginDropdown = loginToggle.contains(e.target) || loginDropdownMenu.contains(e.target);
            if (!isLoginDropdown) {
              loginDropdownMenu.classList.remove('active');
            }
          });
      }

      // LOGIKA SEARCH BAR
      function toggleSearch(e) {
          e.preventDefault();
          const form = document.getElementById('searchForm');
          if (form.style.display === 'none') {
              form.style.display = 'block';
          } else {
              form.style.display = 'none';
          }
      }
    </script>
</body>
</html>
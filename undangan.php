<?php
// 1. Panggil koneksi database
require 'koneksi.php';

// 2. Tangkap ID dari URL
if (!isset($_GET['id'])) {
    die("Maaf, ID undangan tidak ditemukan!");
}

$id_undangan = $_GET['id'];

// 3. Cari data di tabel data_acara
$query = "SELECT * FROM data_acara WHERE id = '$id_undangan'";
$hasil = mysqli_query($koneksi, $query);
$data  = mysqli_fetch_assoc($hasil);

if (!$data) {
    die("Maaf, data undangan tidak ditemukan di database!");
}

// Tangkap nama tamu dari URL (contoh: ?id=2&to=Bapak+Budi)
$nama_tamu = isset($_GET['to']) ? $_GET['to'] : (isset($_GET['kpd']) ? $_GET['kpd'] : 'Bapak/Ibu/Saudara/i');

// Format tanggal
$tanggal_asli = $data['tanggal_acara'];
$tahun = date('Y', strtotime($tanggal_asli));
$bulan = date('F', strtotime($tanggal_asli));
$tanggal = date('d', strtotime($tanggal_asli));
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Pernikahan <?= $data['mempelai_pria']; ?> & <?= $data['mempelai_wanita']; ?></title>
    
    <!-- Import Font Elegan -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Great+Vibes&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-latin { font-family: 'Great Vibes', cursive; }
        .font-lora { font-family: 'Lora', serif; }
        .bentuk-kubah {
            border-top-left-radius: 9999px;
            border-top-right-radius: 9999px;
        }
    </style>
</head>
<!-- overflow-hidden di awal agar halaman utama tidak bisa di-scroll sebelum tombol dibuka -->
<body class="bg-[#2c2c2c] text-gray-800 antialiased overflow-hidden pb-28">

    <!-- ================= LAYAR SAMPUL UTAMA (COVER SCREEN) ================= -->
    <div id="cover-screen" class="fixed inset-0 z-50 max-w-md mx-auto flex flex-col justify-between py-12 px-6 text-center shadow-2xl transition-all duration-700"
         style="background-image: url('https://images.unsplash.com/photo-1606800052052-a08af7148866?q=80&w=800&auto=format&fit=crop'); background-size: cover; background-position: center;">
        
        <!-- Overlay Gradasi Gelap -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/80 z-0"></div>

        <!-- Bagian Atas: Judul & Nama Pasangan -->
        <div class="relative z-10 pt-4">
            <p class="text-white text-xs font-cinzel tracking-[0.3em] mb-2">THE WEDDING OF</p>
            <h1 class="font-latin text-5xl md:text-6xl text-white drop-shadow-md">
                <?= $data['mempelai_pria']; ?> <span class="text-2xl text-rose-300">&amp;</span> <?= $data['mempelai_wanita']; ?>
            </h1>
        </div>

        <!-- Bagian Bawah: Kepada Tamu & Tombol Buka Undangan -->
        <div class="relative z-10 w-full bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-white shadow-lg">
            <p class="font-lora text-xs uppercase tracking-widest text-gray-200 mb-1">Kepada Yth.</p>
            <p class="font-cinzel text-xl font-bold mb-3 text-amber-200"><?= htmlspecialchars($nama_tamu); ?></p>
            <p class="font-lora text-[11px] text-gray-200 leading-relaxed mb-6">
                Tanpa Mengurangi Rasa Hormat, Kami Mengundang Bapak/Ibu/Saudara/i untuk Hadir di Acara Kami.
            </p>
            
            <button onclick="bukaUndangan()" class="w-full py-3 px-6 bg-[#8b7355] hover:bg-[#725e45] text-white font-lora text-sm rounded-xl shadow-lg flex items-center justify-center space-x-2 transition-all transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Buka Undangan</span>
            </button>
        </div>
    </div>

    <!-- Script JavaScript untuk Animasi Membuka Undangan -->
    <script>
        function bukaUndangan() {
            const cover = document.getElementById('cover-screen');
            // Efek geser ke atas dan memudar
            cover.style.transform = 'translateY(-100%)';
            cover.style.opacity = '0';
            
            // Izinkan kembali body untuk melakukan scroll setelah cover tertutup
            setTimeout(() => {
                cover.style.display = 'none';
                document.body.classList.remove('overflow-hidden');
            }, 700);
        }
    </script>


    <!-- ================= CONTAINER UTAMA UNDANGAN ================= -->
    <main class="max-w-md mx-auto bg-[#f9f8f6] min-h-screen relative overflow-x-hidden shadow-2xl">

        <!-- SECTION 1: SAVE THE DATE / DETAIL ACARA -->
        <section id="beranda" class="relative min-h-screen flex flex-col items-center justify-between py-16 px-6 text-center bg-[#f4f3ef]">
            <div class="w-full pt-6">
                <h2 class="font-latin text-5xl text-[#8b7355] mb-4">Save The Date</h2>
                <p class="font-lora text-xs text-gray-600 leading-relaxed max-w-xs mx-auto mb-2">
                    "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri..."
                </p>
                <span class="font-cinzel text-[10px] font-bold tracking-widest text-[#8b7355]">- Ar-Rum - Ayat 21 -</span>
            </div>

            <!-- Kartu Putih Berbentuk Kubah -->
            <div class="w-full bg-white bentuk-kubah pt-12 pb-10 px-6 shadow-xl mt-12">
                <h3 class="font-latin text-3xl text-[#8b7355] mb-1">Resepsi Pernikahan</h3>
                <p class="font-cinzel text-xs uppercase tracking-[0.2em] text-gray-500 mb-6"><?= $bulan; ?></p>
                
                <div class="flex items-center justify-center space-x-6 mb-6">
                    <span class="font-cinzel text-sm font-bold text-gray-600 truncate max-w-[80px]"><?= $data['mempelai_pria']; ?></span>
                    <div class="border-l border-r border-gray-300 px-6 py-1">
                        <span class="font-cinzel text-5xl font-bold text-[#8b7355]"><?= $tanggal; ?></span>
                    </div>
                    <span class="font-cinzel text-sm font-bold text-gray-600"><?= $tahun; ?></span>
                </div>

                <p class="font-lora text-sm font-semibold text-gray-700 mb-2">Pukul <?= $data['waktu_acara']; ?> WIB</p>
                <p class="font-lora text-xs text-gray-500 leading-relaxed mb-8 px-4"><?= $data['lokasi_acara']; ?></p>

                <a href="#lokasi" class="inline-block bg-[#8b7355] text-white font-lora text-sm px-8 py-3 rounded-full shadow-md hover:bg-[#725e45] transition-colors">
                    Buka Google Maps
                </a>
            </div>
        </section>

        <!-- SECTION 2: MEMPELAI -->
        <section id="mempelai" class="py-20 px-6 text-center bg-white">
            <p class="font-cinzel text-xs tracking-[0.3em] text-[#8b7355] mb-2">THE WEDDING OF</p>
            
            <div class="mb-8">
                <h2 class="font-latin text-4xl md:text-5xl text-gray-800 leading-tight"><?= $data['mempelai_pria']; ?></h2>
                <div class="font-cinzel text-2xl text-[#8b7355] my-2">&amp;</div>
                <h2 class="font-latin text-4xl md:text-5xl text-gray-800 leading-tight"><?= $data['mempelai_wanita']; ?></h2>
            </div>
            
            <p class="font-lora text-sm text-gray-600 max-w-xs mx-auto leading-relaxed mb-12">
                Atas Rahmat Tuhan Yang Maha Esa, kami bermaksud mengundang Bapak/Ibu/Saudara/i dalam acara pernikahan kami.
            </p>

            <div class="space-y-12">
                <div class="flex flex-col items-center">
                    <div class="w-36 h-36 rounded-full overflow-hidden shadow-lg mb-4 border-4 border-[#8b7355]/20">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-latin text-3xl text-[#8b7355] mb-1"><?= $data['mempelai_pria']; ?></h3>
                    <p class="font-lora text-xs text-gray-500">Putra dari Keluarga Bapak &amp; Ibu</p>
                </div>

                <span class="font-cinzel text-2xl text-gray-300 block">&amp;</span>

                <div class="flex flex-col items-center">
                    <div class="w-36 h-36 rounded-full overflow-hidden shadow-lg mb-4 border-4 border-[#8b7355]/20">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-latin text-3xl text-[#8b7355] mb-1"><?= $data['mempelai_wanita']; ?></h3>
                    <p class="font-lora text-xs text-gray-500">Putri dari Keluarga Bapak &amp; Ibu</p>
                </div>
            </div>
        </section>

        <!-- SECTION 3: RUNDOWN ACARA -->
        <section id="rundown" class="py-20 px-6 bg-[#fdfbf7] border-t border-gray-200">
            <h2 class="font-cinzel text-2xl text-center text-[#8b7355] mb-12 tracking-widest">Susunan Acara</h2>
            
            <div class="relative border-l-2 border-[#8b7355]/30 ml-4 space-y-8">
                <div class="relative pl-6">
                    <div class="absolute -left-[7px] top-1.5 w-3 h-3 rounded-full bg-[#8b7355]"></div>
                    <span class="font-cinzel text-xs font-bold text-[#8b7355]">08:00 WIB</span>
                    <h4 class="font-lora font-bold text-gray-800 text-sm mt-1">Persiapan &amp; Kedatangan Tamu</h4>
                </div>
                <div class="relative pl-6">
                    <div class="absolute -left-[7px] top-1.5 w-3 h-3 rounded-full bg-[#8b7355]"></div>
                    <span class="font-cinzel text-xs font-bold text-[#8b7355]">10:00 WIB</span>
                    <h4 class="font-lora font-bold text-gray-800 text-sm mt-1">Akad Nikah</h4>
                </div>
                <div class="relative pl-6">
                    <div class="absolute -left-[7px] top-1.5 w-3 h-3 rounded-full bg-[#8b7355]"></div>
                    <span class="font-cinzel text-xs font-bold text-[#8b7355]">11:00 WIB</span>
                    <h4 class="font-lora font-bold text-gray-800 text-sm mt-1">Resepsi Pernikahan</h4>
                </div>
            </div>
        </section>

        <!-- SECTION 4: TITIP HADIAH -->
        <section id="hadiah" class="py-20 px-6 bg-white border-t border-gray-200 text-center">
            <h2 class="font-cinzel text-2xl text-[#8b7355] mb-4 tracking-widest">Titip Hadiah</h2>
            <div class="bg-[#f9f8f6] p-6 rounded-2xl shadow-sm border border-gray-200 text-left">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-cinzel font-bold text-sm text-gray-700">BCA</span>
                    <span class="text-xs bg-[#8b7355]/10 text-[#8b7355] px-2 py-1 rounded font-semibold">12345678</span>
                </div>
                <p class="font-lora text-xs text-gray-500 mb-3">Atas Nama: <?= $data['mempelai_wanita']; ?></p>
                <button onclick="alert('Nomor rekening berhasil disalin!')" class="w-full py-2 bg-[#8b7355] text-white font-lora text-xs rounded-lg hover:bg-[#725e45] transition-colors">
                    Salin Rekening
                </button>
            </div>
        </section>

        <!-- SECTION 5: RSVP -->
        <section id="rsvp" class="py-20 px-6 bg-[#fdfbf7] border-t border-gray-200">
            <h2 class="font-cinzel text-2xl text-center text-[#8b7355] mb-2 tracking-widest">Kehadiran &amp; Ucapan</h2>
            <form class="space-y-4 mt-6">
                <div>
                    <label class="block font-lora text-xs font-bold text-gray-700 mb-1">Nama</label>
                    <input type="text" placeholder="Masukkan nama Anda" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block font-lora text-xs font-bold text-gray-700 mb-1">Ucapan / Doa</label>
                    <textarea rows="3" placeholder="Tulis ucapan selamat..." class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs"></textarea>
                </div>
                <button type="button" onclick="alert('Terima kasih atas konfirmasinya!')" class="w-full py-3 bg-[#8b7355] text-white font-lora text-xs font-bold rounded-lg shadow">
                    Kirim Konfirmasi
                </button>
            </form>
        </section>

        <!-- SECTION 6: GALLERY -->
        <section id="gallery" class="py-20 px-6 bg-white border-t border-gray-200 text-center">
            <h2 class="font-cinzel text-2xl text-[#8b7355] mb-8 tracking-widest">Our Gallery</h2>
            <div class="grid grid-cols-2 gap-3">
                <div class="h-36 rounded-xl overflow-hidden shadow">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <div class="h-36 rounded-xl overflow-hidden shadow">
                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
            </div>
        </section>

        <!-- SECTION 7: LOKASI -->
        <section id="lokasi" class="py-16 px-6 text-center bg-[#fdfbf7] border-t border-gray-200">
            <h2 class="font-cinzel text-2xl text-[#8b7355] mb-4">Lokasi Acara</h2>
            <p class="font-lora text-sm text-gray-600 mb-6"><?= $data['lokasi_acara']; ?></p>
            <div class="w-full h-48 bg-gray-200 rounded-xl overflow-hidden shadow-inner flex items-center justify-center text-gray-500 font-lora text-xs">
                [Peta Google Maps Interaktif]
            </div>
        </section>

    </main>

    <!-- FLOATING NAVBAR -->
    <nav class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-[#8b7355]/95 backdrop-blur-md text-white px-5 py-3 rounded-full shadow-2xl flex space-x-6 z-40 border border-white/20">
        <a href="#beranda" title="Beranda"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></a>
        <a href="#mempelai" title="Mempelai"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4-4 0 11-8 0 4 4 0 018 0z"/></svg></a>
        <a href="#rundown" title="Rundown"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></a>
        <a href="#hadiah" title="Hadiah"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></a>
        <a href="#rsvp" title="RSVP"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg></a>
        <a href="#gallery" title="Galeri"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></a>
    </nav>

</body>
</html>
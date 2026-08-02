<?php
// 1. Memanggil file koneksi database
require 'koneksi.php';

// 2. Mengecek apakah tombol "Proses Undangan" (submit) sudah ditekan
if (isset($_POST['submit'])) {
    
    // 3. Menangkap data yang dikirim dari form dan menyimpannya ke dalam variabel
    $mempelai_pria   = $_POST['mempelai-pria'];
    $mempelai_wanita = $_POST['mempelai-wanita'];
    $tanggal_acara   = $_POST['tanggal-acara'];
    $waktu_acara     = $_POST['waktu-acara'];
    $lokasi_acara    = $_POST['lokasi-acara'];

    // 4. Menyusun query SQL untuk memasukkan data ke tabel data_acara
    $query = "INSERT INTO data_acara (mempelai_pria, mempelai_wanita, tanggal_acara, waktu_acara, lokasi_acara) 
              VALUES ('$mempelai_pria', '$mempelai_wanita', '$tanggal_acara', '$waktu_acara', '$lokasi_acara')";

    // 5. Mengeksekusi query ke dalam database
    $eksekusi = mysqli_query($koneksi, $query);

    // 6. Mengecek apakah data berhasil masuk
    if ($eksekusi) {
        // Mengambil ID yang baru saja digenerate oleh MySQL (Auto Increment)
        $id_baru = mysqli_insert_id($koneksi);

        // Jika berhasil, munculkan pesan dan langsung arahkan ke link undangan mereka!
        echo "<script>
                alert('Sempurna! Undangan Anda berhasil dibuat.');
                document.location.href = 'undangan.php?id=" . $id_baru . "';
              </script>";
    } else {
        // Jika gagal, munculkan pesan error
        echo "<script>
                alert('Waduh, data gagal disimpan!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Undangan | UndanganPro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <style> .font-serif-elegan { font-family: 'Playfair Display', serif; } </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4" style="background-image: url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center;">

    <div class="bg-white/95 p-8 rounded-lg shadow-2xl w-full max-w-2xl kartu-kustom animate-on-load backdrop-blur-sm relative">
        
        <!-- Tombol Kembali -->
        <a href="index.html" class="absolute top-4 left-4 text-gray-500 hover:text-[#d4af37] flex items-center text-sm font-medium transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <h1 class="font-serif-elegan text-3xl font-bold text-center text-gray-900 mb-2 mt-4">Form Generator Undangan</h1>
        <p class="text-sm text-center text-gray-600 mb-8">Lengkapi data di bawah ini untuk membuat undangan digital Anda</p>

        <!-- Form Kita Sebelumnya -->
        <form action="" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="mempelai-pria" class="block text-sm font-medium text-gray-700">Nama Mempelai Pria</label>
                    <!-- Tambahkan name="mempelai-pria" -->
                    <input type="text" id="mempelai-pria" name="mempelai-pria" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:ring-[#d4af37] focus:border-[#d4af37] sm:text-sm">
                </div>
                <div>
                    <label for="mempelai-wanita" class="block text-sm font-medium text-gray-700">Nama Mempelai Wanita</label>
                    <!-- Tambahkan name="mempelai-wanita" -->
                    <input type="text" id="mempelai-wanita" name="mempelai-wanita" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:ring-[#d4af37] focus:border-[#d4af37] sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal-acara" class="block text-sm font-medium text-gray-700">Tanggal Acara</label>
                    <!-- Tambahkan name="tanggal-acara" -->
                    <input type="date" id="tanggal-acara" name="tanggal-acara" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:ring-[#d4af37] focus:border-[#d4af37] sm:text-sm">
                </div>
                <div>
                    <label for="waktu-acara" class="block text-sm font-medium text-gray-700">Waktu Acara</label>
                    <!-- Tambahkan name="waktu-acara" -->
                    <input type="time" id="waktu-acara" name="waktu-acara" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:ring-[#d4af37] focus:border-[#d4af37] sm:text-sm">
                </div>
            </div>

            <div>
                <label for="lokasi-acara" class="block text-sm font-medium text-gray-700">Lokasi / Alamat Lengkap</label>
                <!-- Tambahkan name="lokasi-acara" -->
                <textarea id="lokasi-acara" name="lokasi-acara" rows="3" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:ring-[#d4af37] focus:border-[#d4af37] sm:text-sm"></textarea>
            </div>

            <button type="submit" name="submit" class="w-full py-3 px-4 rounded-md shadow-sm text-sm font-semibold text-white bg-[#d4af37] hover:bg-[#b5942f] transition-all">
                Proses Undangan
            </button>
        </form>
    </div>

</body>
</html>
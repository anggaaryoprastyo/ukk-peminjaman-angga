<?php
// 1. Memulai session untuk mengecek login
session_start();

// 2. Memastikan path ke app.php benar
// Asumsi: app.php berada di folder 'backend/app.php'
require_once __DIR__ . '/backend/app.php'; 

// 3. Ambil data barang dari database
$data_barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC");

// 4. Cek status login
$is_login = isset($_SESSION['id_user']);
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Alat Hadroh & Rebana Premium - JuraganRebana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="bg-emerald-600 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v12"/><path d="M6 12h12"/></svg>
                    </div>
                    <span class="font-extrabold text-2xl text-slate-900 tracking-tight">JuraganRebana<span class="text-emerald-600">.</span></span>
                </div>

                <div class="flex items-center gap-8">
                    <div class="hidden md:flex items-center gap-6">
                        <a href="#paket" class="text-sm font-bold text-slate-600 hover:text-emerald-600 transition">Katalog Alat</a>
                        <a href="#cara-sewa" class="text-sm font-bold text-slate-600 hover:text-emerald-600 transition">Prosedur</a>
                    </div>

                    <?php if($is_login): ?>
                        <div class="relative group">
                            <button class="flex items-center gap-3 bg-slate-50 border border-slate-200 p-1 pr-4 rounded-full hover:bg-slate-100 transition">
                                <div class="w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center font-bold shadow-md shadow-emerald-200 overflow-hidden">
                                    <?php if(!empty($_SESSION['foto'])): ?>
                                        <img src="storage/user/<?= $_SESSION['foto'] ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
                                    <?php endif; ?>
                                </div>
                                <span class="text-sm font-bold text-slate-700"><?= explode(' ', $_SESSION['nama'])[0] ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            
                            <div class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <a href="riwayat_pinjam.php" class="block px-4 py-2 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">Riwayat Sewa</a>
                                <hr class="my-2 border-slate-50">
                                <a href="backend/auth/logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold transition">Keluar Akun</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="backend/auth/login.php" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-full text-sm font-bold transition duration-300 shadow-lg shadow-emerald-200">
                            Masuk / Daftar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-36 overflow-hidden">
        <div class="absolute inset-0 z-0 bg-emerald-900">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 to-emerald-950 opacity-90"></div>
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
            <span class="inline-flex items-center gap-2 py-2 px-4 rounded-full bg-white/10 border border-white/20 text-emerald-100 text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Sewa Alat Hadroh Terlengkap 2026
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-8">
                Syiarkan Sholawat, <br>
                <span class="text-amber-400">Urusan Alat Kami Tangani.</span>
            </h1>
            <p class="text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto mb-12 leading-relaxed">
                Sewa full set rebana kualitas premium, suara garing, dan sudah dituning rapi oleh ahli. Tanpa ribet, alat siap tempur di panggung!
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#paket" class="bg-amber-500 hover:bg-amber-400 text-slate-900 px-10 py-4 rounded-full font-bold text-lg transition duration-300 shadow-2xl shadow-amber-500/40">
                    Mulai Sewa Alat
                </a>
                <a href="#cara-sewa" class="bg-white/10 hover:bg-white/20 text-white border border-white/30 px-10 py-4 rounded-full font-bold text-lg transition duration-300 backdrop-blur-sm">
                    Lihat Prosedur
                </a>
            </div>
        </div>
    </section>

    <section id="paket" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-xl text-left">
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Katalog Alat Tersedia</h2>
                    <p class="text-slate-500 italic">Pilih alat yang Anda butuhkan. Semua alat kami rawat secara rutin untuk menjamin kualitas suara.</p>
                </div>
                <div class="bg-slate-100 p-1 rounded-xl flex">
                    <button class="px-6 py-2 bg-white text-emerald-600 rounded-lg shadow-sm text-sm font-bold">Semua</button>
                    <button class="px-6 py-2 text-slate-500 text-sm font-bold hover:text-slate-700">Set Lengkap</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php while($b = mysqli_fetch_assoc($data_barang)): ?>
                <div class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-emerald-900/10 transition-all duration-500 flex flex-col">
                    <div class="h-64 bg-slate-100 overflow-hidden relative">
                        <?php if(!empty($b['foto'])): ?>
                            <img src="storage/barang/<?= $b['foto'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <?php else: ?>
                            <div class="flex items-center justify-center h-full bg-slate-200 text-slate-400 font-bold uppercase tracking-widest text-xs">Foto Tidak Tersedia</div>
                        <?php endif; ?>
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur text-emerald-700 text-[10px] font-black uppercase rounded-lg shadow-sm">
                                Stok: <?= $b['jumlah'] ?> Unit
                            </span>
                        </div>
                    </div>
                    <div class="p-8 flex-grow">
                        <h3 class="text-xl font-extrabold text-slate-900 mb-2"><?= $b['nama_barang'] ?></h3>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-4 tracking-wider">Kondisi: <span class="text-amber-600"><?= $b['kondisi'] ?></span></p>
                        <p class="text-slate-500 text-sm mb-8 line-clamp-2 leading-relaxed italic">"<?= $b['keterangan'] ?>"</p>
                        
                        <a href="detail_barang.php?id=<?= $b['id_barang'] ?>" class="flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-emerald-600 text-white font-bold py-4 rounded-2xl transition duration-300 group-hover:shadow-xl group-hover:shadow-emerald-100">
                            Cek Detail & Sewa
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section id="cara-sewa" class="py-24 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-16">Alur Penyewaan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <div class="hidden md:block absolute top-12 left-1/4 right-1/4 h-0.5 bg-dashed bg-slate-200 border-t-2 border-dashed"></div>
                
                <div class="relative group">
                    <div class="w-20 h-20 bg-white border-4 border-emerald-100 text-emerald-600 font-black text-2xl rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3 group-hover:rotate-0 transition duration-300 shadow-xl shadow-emerald-900/5">1</div>
                    <h4 class="font-extrabold text-lg text-slate-900">Pilih Alat</h4>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Cari alat yang dibutuhkan di katalog kami dan klik Detail.</p>
                </div>
                <div class="relative group">
                    <div class="w-20 h-20 bg-emerald-600 text-white font-black text-2xl rounded-3xl flex items-center justify-center mx-auto mb-6 -rotate-3 group-hover:rotate-0 transition duration-300 shadow-xl shadow-emerald-900/20">2</div>
                    <h4 class="font-extrabold text-lg text-slate-900">Isi Form & Verifikasi</h4>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Lengkapi data diri dan tentukan tanggal peminjaman.</p>
                </div>
                <div class="relative group">
                    <div class="w-20 h-20 bg-white border-4 border-emerald-100 text-emerald-600 font-black text-2xl rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3 group-hover:rotate-0 transition duration-300 shadow-xl shadow-emerald-900/5">3</div>
                    <h4 class="font-extrabold text-lg text-slate-900">Ambil & Bayar</h4>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Cetak bukti sewa, ambil alat ke toko, dan bayar di tempat.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-20">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="text-left">
                <h2 class="text-3xl font-extrabold text-white mb-6 leading-tight text-center md:text-left">Amankan Tanggal Acara <br>Anda Sekarang!</h2>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/6281234567890" class="flex-1 bg-emerald-500 hover:bg-emerald-400 text-white font-black px-8 py-5 rounded-2xl transition text-center shadow-2xl shadow-emerald-500/20">
                        Chat Admin WA
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8 border-l border-slate-800 pl-0 md:pl-16">
                <div>
                    <h5 class="text-white font-bold mb-4 uppercase text-xs tracking-widest">Kontak</h5>
                    <p class="text-sm mb-2">admin@juraganrebana.com</p>
                    <p class="text-sm">+62 812 3456 7890</p>
                </div>
                <div>
                    <h5 class="text-white font-bold mb-4 uppercase text-xs tracking-widest">Lokasi</h5>
                    <p class="text-sm leading-relaxed">Jl. Rebana No. 123, <br>Kota Pekalongan, Jateng.</p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-20 pt-8 border-t border-slate-800 text-center text-xs font-bold tracking-widest uppercase opacity-50">
            &copy; 2026 JuraganRebana. All rights reserved.
        </div>
    </footer>

</body>
</html>
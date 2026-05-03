<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | EduPortal Kendali</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden">

    <!-- SIDEBAR ADMIN (Gelap agar kontras dengan halaman user) -->
    <?php include 'layout/sidebar.php'; ?>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <!-- Header -->
        <?php include 'layout/navbar.php'; ?>

        <!-- Area Konten (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-slate-50/50">
            
            <!-- Kartu Statistik Cepat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <p class="text-slate-500 text-sm font-semibold mb-1 relative z-10">Total Mahasiswa</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 relative z-10">142</h3>
                    <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-emerald-500 relative z-10">
                        <i class="ph-bold ph-trend-up"></i> +12% bulan ini
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <p class="text-slate-500 text-sm font-semibold mb-1 relative z-10">Kursus Aktif</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 relative z-10">8</h3>
                    <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-slate-400 relative z-10">
                        <i class="ph-bold ph-minus"></i> Tetap
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <p class="text-slate-500 text-sm font-semibold mb-1 relative z-10">Sertifikat Terbit</p>
                    <h3 class="text-3xl font-extrabold text-slate-800 relative z-10">85</h3>
                    <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-emerald-500 relative z-10">
                        <i class="ph-bold ph-trend-up"></i> +5 baru
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <p class="text-slate-500 text-sm font-semibold mb-1 relative z-10">Server Status</p>
                    <h3 class="text-3xl font-extrabold text-emerald-500 relative z-10">Online</h3>
                    <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-slate-400 relative z-10">
                        Ping: 12ms
                    </div>
                </div>
            </div>

            <!-- Tabel Pendaftar Terbaru -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Aktivitas Pendaftaran Terbaru</h3>
                    <button class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Lihat Laporan Lengkap &rarr;</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50/50 text-xs uppercase font-semibold text-slate-500">
                            <tr>
                                <th class="px-6 py-4 border-b border-slate-100">Nama Lengkap</th>
                                <th class="px-6 py-4 border-b border-slate-100">Email</th>
                                <th class="px-6 py-4 border-b border-slate-100">Metode Login</th>
                                <th class="px-6 py-4 border-b border-slate-100">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <!-- Data Dummy (Nantinya diganti dengan fetch() dari API) -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">Arga Chon Feriandref</td>
                                <td class="px-6 py-4">arga@student.ac.id</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-2 py-1 rounded text-xs font-semibold">
                                        <i class="ph-fill ph-google-logo"></i> Google OAuth
                                    </span>
                                </td>
                                <td class="px-6 py-4"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block mr-2"></span>Aktif</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">Mahasiswa Baru</td>
                                <td class="px-6 py-4">siswa@student.ac.id</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-semibold">
                                        <i class="ph-fill ph-envelope"></i> Manual
                                    </span>
                                </td>
                                <td class="px-6 py-4"><span class="w-2 h-2 rounded-full bg-emerald-500 inline-block mr-2"></span>Aktif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        function logout() {
            Swal.fire({
                title: 'Akhiri Sesi Admin?',
                text: "Anda akan dikembalikan ke halaman login utama.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Keluar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.html';
                }
            })
        }
    </script>
</body>
</html>
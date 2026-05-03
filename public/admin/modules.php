<?php 
// Ambil ID Kursus dari URL jika ada
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 1; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Modul Video | Admin EduPortal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex overflow-hidden h-screen">

    <!-- Panggil Sidebar -->
    <?php include 'layout/sidebar.php'; ?>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- Panggil Navbar -->
        <?php include 'layout/navbar.php'; ?>

        <main class="p-6 md:p-8 max-w-5xl mx-auto w-full">
            <div class="mb-8">
                <a href="courses.php" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold mb-4 transition">
                    <i class="ph-bold ph-arrow-left"></i> Kembali ke Daftar Kursus
                </a>
                <h1 class="text-2xl font-bold text-slate-800">Kelola Materi Video</h1>
                <p class="text-sm text-slate-500 mt-1">Mengelola modul untuk Kursus ID: <span class="font-bold text-indigo-600">#<?= $course_id ?></span></p>
            </div>

            <!-- BAGIAN 1: TABEL DAFTAR MODUL SAAT INI -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="p-6 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-800"><i class="ph-fill ph-list-numbers text-indigo-500 mr-2"></i>Modul Terdaftar</h2>
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold" id="moduleCount">Memuat...</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-sm font-bold text-slate-600">Urutan</th>
                                <th class="px-6 py-4 text-sm font-bold text-slate-600">Judul Video</th>
                                <th class="px-6 py-4 text-sm font-bold text-slate-600">Durasi</th>
                                <th class="px-6 py-4 text-sm font-bold text-slate-600 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="moduleTableBody" class="divide-y divide-slate-100">
                            <tr>
                                <td colspan="4" class="text-center py-8 text-slate-500">
                                    <i class="ph-bold ph-spinner-gap animate-spin text-3xl mb-2 text-indigo-500"></i>
                                    <p>Menarik data terenkripsi dari server...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- BAGIAN 2: FORM UPLOAD MODUL BARU -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                <h2 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4"><i class="ph-fill ph-plus-circle text-indigo-500 mr-2"></i>Tambahkan Modul Baru</h2>
                
                <form id="uploadForm" class="space-y-6">
                    <input type="hidden" name="course_id" id="course_id" value="<?= $course_id ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Video Modul</label>
                            <input type="text" name="title" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Pengenalan Arsitektur MVC">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan (Sequence)</label>
                            <input type="number" name="sequence" id="nextSequence" required min="1" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Durasi Video (detik)</label>
                            <input type="number" name="duration" required min="1" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: 300 (untuk 5 menit)">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">File Video (MP4)</label>
                        <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 transition cursor-pointer relative">
                            <input type="file" id="videoFile" name="video" accept="video/mp4" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <i class="ph-fill ph-cloud-arrow-up text-5xl text-indigo-400 mb-3"></i>
                            <h3 class="text-sm font-bold text-slate-700">Klik atau tarik file video ke sini</h3>
                            <p class="text-xs text-slate-500 mt-1" id="fileNameDisplay">Hanya menerima format .mp4</p>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2">
                        <i class="ph-bold ph-upload-simple"></i> Upload dan Simpan Modul
                    </button>
                </form>
            </div>
        </main>
    </div>

    <!-- Script Kriptografi -->
    <script src="../js/crypto_client.js?v=2"></script>
    <script>
        document.getElementById('pageTitle').innerText = "Manajemen Video";
        const currentCourseId = document.getElementById('course_id').value;

        // Jalankan fetch saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchExistingModules);

        // ==========================================
        // 1. FUNGSI MENARIK & DEKRIPSI DATA MODUL
        // ==========================================
        async function fetchExistingModules() {
            try {
                // Kita gunakan endpoint dari sisi mahasiswa untuk mengambil data!
                const response = await fetch(`https://kursus.mitrautamateknologi.xyz/public/api.php?ctrl=course&action=get_modules&course_id=${currentCourseId}&nocache=${new Date().getTime()}`);
                const result = await response.json();

                const tbody = document.getElementById('moduleTableBody');
                const countBadge = document.getElementById('moduleCount');

                if (result.status === 'success') {
                    // DEKRIPSI PAYLOAD AES-256-GCM
                    const decrypted = await decryptPayload(result.data.payload, result.data.iv, result.data.tag);
                    
                    if (decrypted && decrypted.data.length > 0) {
                        const modules = decrypted.data;
                        countBadge.innerText = `${modules.length} Modul`;
                        
                        // Set rekomendasi nomor urut (Sequence) berikutnya di form
                        const maxSeq = Math.max(...modules.map(m => m.sequence));
                        document.getElementById('nextSequence').value = maxSeq + 1;

                        tbody.innerHTML = modules.map(modul => {
                            const mins = Math.floor(modul.duration_seconds / 60);
                            const secs = (modul.duration_seconds % 60).toString().padStart(2, '0');
                            
                            return `
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                        ${modul.sequence}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-800">${modul.title}</td>
                                <td class="px-6 py-4 text-slate-500 text-sm"><i class="ph-fill ph-clock mr-1"></i>${mins}:${secs}</td>
                                <td class="px-6 py-4 text-right">
                                    <button onclick='editModule(${JSON.stringify(modul)})' class="text-amber-500 hover:text-amber-600 font-semibold text-sm mr-3">Edit</button>
                                    <button onclick='deleteModule(${modul.id})' class="text-red-500 hover:text-red-600 font-semibold text-sm">Hapus</button>
                                </td>
                            </tr>
                            `;
                        }).join('');
                    } else {
                        countBadge.innerText = `0 Modul`;
                        document.getElementById('nextSequence').value = 1;
                        tbody.innerHTML = `<tr><td colspan="4" class="text-center py-8 text-slate-500">Belum ada modul video untuk kursus ini.</td></tr>`;
                    }
                } else {
                    countBadge.innerText = `Error`;
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center py-8 text-red-500">Gagal memuat data dari server.</td></tr>`;
                }
            } catch (error) {
                console.error("Gagal menarik modul:", error);
            }
        }

        // ==========================================
        // 2. FUNGSI UPLOAD MODUL BARU
        // ==========================================
        document.getElementById('videoFile').addEventListener('change', function(e) {
            const display = document.getElementById('fileNameDisplay');
            if (e.target.files.length > 0) {
                display.innerHTML = `<span class="text-emerald-600 font-bold"><i class="ph-fill ph-check-circle"></i> File siap: ${e.target.files[0].name}</span>`;
            }
        });

        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault(); 
            const form = document.getElementById('uploadForm');
            const submitBtn = document.getElementById('submitBtn');
            const originalBtnHtml = submitBtn.innerHTML;

            const formData = new FormData(form);

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ph-bold ph-spinner-gap animate-spin text-xl"></i> Sedang Mengunggah... (Harap Tunggu)';
            submitBtn.classList.replace('bg-indigo-600', 'bg-slate-400');

            try {
                const response = await fetch('https://kursus.mitrautamateknologi.xyz/public/api.php?ctrl=admin&action=upload_module', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    Swal.fire('Berhasil!', result.message, 'success').then(() => {
                        form.reset(); 
                        document.getElementById('fileNameDisplay').innerText = "Hanya menerima format .mp4";
                        
                        // Refresh otomatis tabel di atas setelah sukses upload!
                        fetchExistingModules();
                    });
                } else {
                    Swal.fire('Gagal Upload', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error Koneksi', 'Gagal menghubungi server.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
                submitBtn.classList.replace('bg-slate-400', 'bg-indigo-600');
            }
        });
    
        // ==========================================
        // FUNGSI EDIT MODUL
        // ==========================================
        async function editModule(modul) {
            const { value: formValues } = await Swal.fire({
                title: 'Edit Modul Video',
                html: `
                    <div class="space-y-4 text-left">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Video</label>
                            <input id="edit-title" class="swal2-input m-0 w-full" value="${modul.title}">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Urutan</label>
                                <input id="edit-seq" type="number" class="swal2-input m-0 w-full" value="${modul.sequence}">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Durasi (Detik)</label>
                                <input id="edit-dur" type="number" class="swal2-input m-0 w-full" value="${modul.duration_seconds}">
                            </div>
                        </div>
                        <p class="text-xs text-amber-600 mt-2"><i class="ph-fill ph-info"></i> Untuk mengganti file video, silakan hapus modul ini dan upload ulang.</p>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Simpan Perubahan',
                confirmButtonColor: '#4f46e5',
                preConfirm: () => {
                    return {
                        id: modul.id,
                        title: document.getElementById('edit-title').value,
                        sequence: document.getElementById('edit-seq').value,
                        duration: document.getElementById('edit-dur').value
                    }
                }
            });

            if (formValues) {
                const formData = new FormData();
                formData.append('id', formValues.id);
                formData.append('title', formValues.title);
                formData.append('sequence', formValues.sequence);
                formData.append('duration', formValues.duration);

                try {
                    const response = await fetch('https://kursus.mitrautamateknologi.xyz/public/api.php?ctrl=admin&action=update_module', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    if (result.status === 'success') {
                        Swal.fire('Tersimpan!', 'Perubahan berhasil disimpan.', 'success');
                        fetchExistingModules(); // Refresh tabel
                    } else {
                        Swal.fire('Gagal', result.message, 'error');
                    }
                } catch(e) {
                    Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                }
            }
        }

        // ==========================================
        // FUNGSI HAPUS MODUL
        // ==========================================
        async function deleteModule(moduleId) {
            const result = await Swal.fire({
                title: 'Hapus Modul Ini?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!'
            });

            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', moduleId);

                try {
                    const response = await fetch('https://kursus.mitrautamateknologi.xyz/public/api.php?ctrl=admin&action=delete_module', {
                        method: 'POST',
                        body: formData
                    });
                    const res = await response.json();
                    
                    if (res.status === 'success') {
                        Swal.fire('Terhapus!', 'Modul berhasil dihapus dari sistem.', 'success');
                        fetchExistingModules(); // Refresh tabel
                    }
                } catch(e) {
                    Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                }
            }
        }
    </script>
</body>
</html>


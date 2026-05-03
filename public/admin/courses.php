<?php 
// Pastikan sesi admin valid di sini jika diperlukan nanti
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kursus | Admin EduPortal</title>
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

        <!-- Konten Utama -->
        <main class="p-6 md:p-8 max-w-6xl mx-auto w-full">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Daftar Kursus</h1>
                    <p class="text-sm text-slate-500 mt-1">Kelola program studi dan kursus yang tersedia.</p>
                </div>
                <button onclick="showAddModal()" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/30 flex items-center gap-2">
                    <i class="ph-bold ph-plus"></i> Tambah Kursus
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600">ID</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600">Judul Kursus</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600">Deskripsi</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-600 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="courseTableBody" class="divide-y divide-slate-100">
                        <tr>
                            <td colspan="4" class="text-center py-8 text-slate-500">
                                <i class="ph-bold ph-spinner-gap animate-spin text-3xl mb-2 text-indigo-500"></i>
                                <p>Menarik data terenkripsi...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Script Kriptografi Q1 -->
    <script src="../js/crypto_client.js?v=2"></script>
    <script>
        document.getElementById('pageTitle').innerText = "Manajemen Kursus";

        document.addEventListener('DOMContentLoaded', fetchCourses);

        async function fetchCourses() {
            try {
                const response = await fetch('https://kursus.mitrautamateknologi.xyz/public/api.php?ctrl=admin&action=get_courses');
                const result = await response.json();

                if (result.status === 'success') {
                    // DEKRIPSI PAYLOAD
                    const decrypted = await decryptPayload(result.data.payload, result.data.iv, result.data.tag);
                    if (decrypted) {
                        renderTable(decrypted.data);
                    }
                } else {
                    document.getElementById('courseTableBody').innerHTML = `<tr><td colspan="4" class="text-center py-6 text-red-500">${result.message || 'Gagal memuat data'}</td></tr>`;
                }
            } catch (error) {
                console.error("Error fetching courses:", error);
            }
        }

        function renderTable(courses) {
            const tbody = document.getElementById('courseTableBody');
            if (courses.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-6 text-slate-500">Belum ada kursus. Silakan tambah baru.</td></tr>`;
                return;
            }

            tbody.innerHTML = courses.map(course => `
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-mono text-sm text-slate-500">#${course.id}</td>
                    <td class="px-6 py-4 font-bold text-slate-800">${course.title}</td>
                    <td class="px-6 py-4 text-slate-500 text-sm truncate max-w-xs">${course.description || '-'}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="modules.php?course_id=${course.id}" class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                            <i class="ph-bold ph-video-camera"></i> Kelola Video
                        </a>
                    </td>
                </tr>
            `).join('');
        }

        async function showAddModal() {
            const { value: formValues } = await Swal.fire({
                title: 'Tambah Kursus Baru',
                html:
                    '<input id="swal-title" class="swal2-input" placeholder="Judul Kursus (Cth: Pemrograman Web)">' +
                    '<textarea id="swal-desc" class="swal2-textarea" placeholder="Deskripsi Singkat"></textarea>',
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Simpan Kursus',
                confirmButtonColor: '#4f46e5',
                preConfirm: () => {
                    const title = document.getElementById('swal-title').value;
                    if(!title) { Swal.showValidationMessage('Judul kursus wajib diisi'); return false; }
                    return {
                        title: title,
                        description: document.getElementById('swal-desc').value
                    }
                }
            });

            if (formValues) {
                const formData = new FormData();
                formData.append('title', formValues.title);
                formData.append('description', formValues.description);

                try {
                    const response = await fetch('https://kursus.mitrautamateknologi.xyz/public/api.php?ctrl=admin&action=add_course', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    if (result.status === 'success') {
                        Swal.fire('Berhasil!', result.message, 'success');
                        fetchCourses(); // Refresh tabel
                    } else {
                        Swal.fire('Gagal', result.message, 'error');
                    }
                } catch(e) {
                    Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                }
            }
        }
    </script>
</body>
</html>

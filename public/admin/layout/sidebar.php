<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col h-screen sticky top-0">
    <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <h1 class="text-xl font-extrabold text-indigo-600 tracking-tight">EduPortal<span class="text-slate-800">Admin</span></h1>
    </div>
    <nav class="flex-1 p-4 space-y-1">
        <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?= ($current_page == 'index.php') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
            <i class="ph-fill ph-squares-four text-xl"></i> Dasbor
        </a>
        <a href="courses.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?= ($current_page == 'courses.php') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
            <i class="ph-fill ph-graduation-cap text-xl"></i> Kelola Kursus
        </a>
        <a href="modules.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?= ($current_page == 'modules.php') ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
            <i class="ph-fill ph-video-camera text-xl"></i> Kelola Video
        </a>
    </nav>
    <div class="p-4 border-t border-slate-100">
        <button onclick="logout()" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-red-500 hover:bg-red-50 transition-colors font-medium">
            <i class="ph-bold ph-sign-out text-xl"></i> Keluar
        </button>
    </div>
</aside>
<?php
// Koneksi ke Redis
$redis = new Redis();
$redis->connect('redis-cache', 6379);

$skor1 = $redis->get('skor:paslon1') ?: 0;
$skor2 = $redis->get('skor:paslon2') ?: 0;
$skor3 = $redis->get('skor:paslon3') ?: 0; 

$voters = $redis->keys('voted:*');
$total_voters = count($voters);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Ruang Hokage</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        /* Backup style jika Tailwind gagal load */
        .nav-item { border-radius: 0; }
    </style>
</head>
<body class="bg-gray-100 text-black font-sans p-10 selection:bg-black selection:text-white">
    
    <nav class="bg-white border-b-4 border-black p-4 mb-6 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div class="font-black text-xl tracking-tighter italic">
                <a href="/">HOKAGE_VOTE</a>
            </div>
            <div id="nav-links" class="flex gap-2 md:gap-4 font-bold uppercase text-xs md:text-sm">
                <a href="/" data-path="/" class="nav-item border-2 border-transparent px-3 py-1 transition-all">Bilik Suara</a>
                <a href="/scoreboard" data-path="/scoreboard" class="nav-item border-2 border-transparent px-3 py-1 transition-all">Scoreboard</a>
                <a href="/admin" data-path="/admin" class="nav-item border-2 border-transparent px-3 py-1 transition-all">Admin</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto border-4 border-black p-8 bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
        <div class="flex justify-between items-center border-b-4 border-black pb-4 mb-6">
            <h1 class="text-3xl font-black uppercase">Ruang Hokage</h1>
            <span class="bg-black text-white px-3 py-1 font-mono text-sm">SERVER PHP ADMIN</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 text-center">
            <div class="border-2 border-black p-4">
                <h2 class="font-bold uppercase text-gray-500 text-sm mb-1">Kandidat 01</h2>
                <p class="text-5xl font-black"><?php echo $skor1; ?></p>
            </div>
            <div class="border-2 border-black p-4">
                <h2 class="font-bold uppercase text-gray-500 text-sm mb-1">Kandidat 02</h2>
                <p class="text-5xl font-black"><?php echo $skor2; ?></p>
            </div>
            <div class="border-2 border-black p-4 border-dashed bg-gray-50">
                <h2 class="font-bold uppercase text-gray-500 text-sm mb-1">Kandidat 03</h2>
                <p class="text-5xl font-black"><?php echo $skor3; ?></p>
            </div>
            <div class="border-2 border-black p-4 bg-black text-white">
                <h2 class="font-bold uppercase text-gray-300 text-sm mb-1">Total Suara</h2>
                <p class="text-5xl font-black"><?php echo $total_voters; ?></p>
            </div>
        </div>

        <h3 class="font-bold uppercase mb-2">Riwayat Pemilih Sah:</h3>
        <div class="border-2 border-black h-64 overflow-y-auto p-4 bg-gray-50 mb-6">
            <ul class="list-disc pl-6 font-mono text-lg">
                <?php 
                if ($total_voters > 0) {
                    foreach($voters as $voter) {
                        $nama = str_replace('voted:', '', $voter);
                        echo "<li>" . htmlspecialchars(strtoupper($nama)) . "</li>";
                    }
                } else {
                    echo "<li class='text-gray-400 list-none'>Belum ada suara yang masuk.</li>";
                }
                ?>
            </ul>
        </div>

        <button onclick="window.print()" class="w-full bg-black text-white font-bold py-4 uppercase border-2 border-transparent hover:bg-white hover:text-black hover:border-black transition-all">
            Cetak Berita Acara (PDF)
        </button>
    </div>

    <script>
        // Gunakan script murni tanpa is:inline karena ini PHP
        function updateActiveNav() {
            // Kita normalize path agar /admin/ dan /admin dianggap sama
            const currentPath = window.location.pathname.replace(/\/$/, ""); 
            const navItems = document.querySelectorAll('.nav-item');

            navItems.forEach(item => {
                let itemPath = item.getAttribute('data-path').replace(/\/$/, "");
                
                // Cek kecocokan path
                const isActive = (itemPath === "" && currentPath === "") || 
                                 (itemPath !== "" && currentPath.startsWith(itemPath));

                if (isActive) {
                    item.classList.add('bg-black', 'text-white', 'border-black');
                    item.classList.remove('text-black', 'border-transparent');
                } else {
                    item.classList.remove('bg-black', 'text-white', 'border-black');
                    item.classList.add('text-black', 'border-transparent', 'hover:border-black');
                }
            });
        }

        window.onload = updateActiveNav;
    </script>
</body>
</html>
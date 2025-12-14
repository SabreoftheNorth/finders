<style>
    .sidebar-preload, .sidebar-preload * {
        transition: none !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            const sidebar = document.querySelector('aside');
            if(sidebar) sidebar.classList.remove('sidebar-preload');
        }, 100);
    });
</script>

<aside class="sidebar-preload fixed left-0 top-0 w-20 hover:w-64 bg-white shadow-lg flex flex-col h-full border-r border-gray-200 hidden md:flex transition-[width] duration-500 ease-in-out group/sidebar z-50">
    
    <!-- Header Section -->
    <div class="p-3 pt-6 pb-4 border-b border-gray-200">
        <div class="flex items-center gap-3 p-2 relative group/item">
            <div class="w-11 h-11 min-w-[44px] min-h-[44px] flex items-center justify-center flex-shrink-0">
                <img src="../assets/img/FindeRS_Logo.png" alt="FindeRS Logo" class="w-full h-full object-contain">
            </div>
            <div class="overflow-hidden whitespace-nowrap max-w-0 opacity-0 group-hover/sidebar:max-w-xs group-hover/sidebar:opacity-100 transition-all duration-500 ease-in-out">
                <h1 class="text-lg font-bold text-gray-800">FindeRS</h1>
                <p class="text-xs text-green-600 font-semibold">Panel Admin RS</p>
            </div>
            <!-- Tooltip -->
            <div class="absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover/item:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-50 group-hover/sidebar:hidden">
                FindeRS
                <div class="absolute top-1/2 -left-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 space-y-1 px-2 group-hover/sidebar:px-3 transition-all duration-300">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        
        $menu_items = [
            ['url' => 'index.php', 'icon' => 'fa-chart-pie', 'label' => 'Dashboard'],
            ['url' => 'kelola_kunjungan.php', 'icon' => 'fa-calendar-check', 'label' => 'Kelola Kunjungan'],
            ['url' => 'kelola_layanan.php', 'icon' => 'fa-stethoscope', 'label' => 'Layanan & Poli'],
            ['url' => 'profil_rs.php', 'icon' => 'fa-hospital-user', 'label' => 'Profil Rumah Sakit'],
        ];

        foreach ($menu_items as $item):
            $is_active = ($current_page === $item['url']);
            $active_class = $is_active 
                ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600 shadow-sm' 
                : 'text-gray-600 hover:bg-gray-50 border-l-4 border-transparent hover:text-blue-600';
        ?>
            <a href="<?= $item['url'] ?>" 
               class="flex items-center pl-5 pr-3 group-hover/sidebar:px-3 py-3 rounded-r-lg transition-all duration-300 relative group/item <?= $active_class ?>" 
               title="<?= $item['label'] ?>">
                <i class="fa-solid <?= $item['icon'] ?> text-lg w-6 text-center flex-shrink-0"></i>
                <span class="font-medium text-sm whitespace-nowrap overflow-hidden max-w-0 opacity-0 ml-0 group-hover/sidebar:max-w-xs group-hover/sidebar:opacity-100 group-hover/sidebar:ml-4 transition-all duration-500 ease-in-out"><?= $item['label'] ?></span>
                <!-- Tooltip -->
                <div class="absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover/item:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-50 group-hover/sidebar:hidden">
                    <?= $item['label'] ?>
                    <div class="absolute top-1/2 -left-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
                </div>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Profile & Logout Section - Bottom -->
    <div class="p-3 mt-auto border-t border-gray-200 bg-gray-50">
        <div class="flex items-center gap-3 mb-3 p-2 rounded-lg hover:bg-gray-100 transition-all duration-300 relative group/item">
            <div class="w-10 h-10 min-w-[40px] min-h-[40px] bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold flex-shrink-0">
                <?= strtoupper(substr($_SESSION['mitra_name'] ?? 'M', 0, 1)) ?>
            </div>
            <div class="overflow-hidden whitespace-nowrap max-w-0 opacity-0 group-hover/sidebar:max-w-xs group-hover/sidebar:opacity-100 transition-all duration-500 ease-in-out">
                <p class="text-sm font-bold text-gray-800 truncate"><?= $_SESSION['mitra_name'] ?? 'Mitra' ?></p>
                <p class="text-xs text-gray-500 truncate">ID RS: <?= $_SESSION['id_rs'] ?? '-' ?></p>
            </div>
            <!-- Tooltip -->
            <div class="absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover/item:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-50 group-hover/sidebar:hidden">
                <?= $_SESSION['mitra_name'] ?? 'Mitra' ?>
                <div class="absolute top-1/2 -left-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
            </div>
        </div>
        <a href="../logout.php" class="flex items-center pl-5 pr-3 group-hover/sidebar:justify-center group-hover/sidebar:gap-2 group-hover/sidebar:px-3 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-300 text-sm font-medium shadow-sm relative group/item" title="Logout">
            <i class="fa-solid fa-right-from-bracket text-lg w-6 text-center flex-shrink-0"></i>
            <span class="font-medium whitespace-nowrap overflow-hidden max-w-0 opacity-0 ml-0 group-hover/sidebar:max-w-xs group-hover/sidebar:opacity-100 group-hover/sidebar:ml-2 transition-all duration-500 ease-in-out">Logout</span>
            <!-- Tooltip -->
            <div class="absolute left-full ml-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover/item:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-50 group-hover/sidebar:hidden">
                Logout
                <div class="absolute top-1/2 -left-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
            </div>
        </a>
    </div>
</aside>
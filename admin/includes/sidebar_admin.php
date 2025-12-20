<aside class="w-64 bg-white shadow-lg flex flex-col h-full border-r border-gray-200">
    <!-- logoo -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center">
                <img src="../assets/img/FindeRS_Logo.png" alt="FindeRS Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800">FindeRS</h1>
                <p class="text-xs text-gray-500">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- menu navigasi -->
    <nav class="flex-1 overflow-y-auto py-4 px-3">
        <div class="space-y-1">
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            $menu_items = [
                ['url' => 'index.php', 'icon' => 'fa-chart-line', 'label' => 'Dashboard'],
                ['url' => 'jadwal_data.php', 'icon' => 'fa-calendar-check', 'label' => 'Data Penjadwalan'],
                ['url' => 'rs_data.php', 'icon' => 'fa-hospital', 'label' => 'Data Rumah Sakit'],
                ['url' => 'layanan_data.php', 'icon' => 'fa-stethoscope', 'label' => 'Data Layanan'],
                ['url' => 'users_data.php', 'icon' => 'fa-users', 'label' => 'Data User'],
            ];

            foreach ($menu_items as $item):
                $is_active = ($current_page === $item['url']);
                $active_class = $is_active 
                    ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' 
                    : 'text-gray-600 hover:bg-gray-50 border-l-4 border-transparent';
            ?>
                <a href="<?= $item['url'] ?>" 
                   class="flex items-center gap-3 px-4 py-3 rounded-r-lg transition-all <?= $active_class ?>">
                    <i class="fa-solid <?= $item['icon'] ?> w-5"></i>
                    <span class="font-medium text-sm"><?= $item['label'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <!-- profil admin -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-user-shield text-white"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800"><?= $_SESSION['admin_name'] ?? 'Admin' ?></p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
        <a href="../logout.php" 
           class="flex items-center justify-center gap-2 w-full bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-lg transition text-sm font-medium">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>

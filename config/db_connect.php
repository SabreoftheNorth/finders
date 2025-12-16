<?php

// Matikan laporan error default PHP agar user tidak melihat path file sensitif
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "finder_rs";

try {
    // Mencoba membuat koneksi
    $conn = mysqli_connect($host, $user, $pass, $db);
    
    // Set charset agar support karakter khusus
    mysqli_set_charset($conn, "utf8mb4");

} catch (Exception $e) {
    // Jika koneksi gagal, tampilkan tampilan Error 500 yang user-friendly
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Database Error - FindeRS</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md text-center">
            <div class="text-red-500 text-5xl mb-4">
                <i class="fa-solid fa-database"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Gagal Terhubung ke Server</h1>
            <p class="text-gray-500 mb-4">Sistem sedang mengalami gangguan koneksi database. Silakan coba beberapa saat lagi.</p>
            <button onclick="location.reload()" class="bg-red-500 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-600 transition duration-300">
                <i class="fa-solid fa-rotate-right mr-2"></i> Muat Ulang
            </button>
        </div>
    </body>
    </html>
    <?php
    exit; // Hentikan script agar tidak lanjut eksekusi
}
?>
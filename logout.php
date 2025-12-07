<?php
session_start();

// 1. Hapus semua variabel sesi
session_unset();

// 2. Hancurkan sesi
session_destroy();

// 3. (Opsional) Hapus cookie sesi agar benar-benar bersih
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Kembalikan pengguna ke halaman Login
header("Location: login.php");
exit;
?>
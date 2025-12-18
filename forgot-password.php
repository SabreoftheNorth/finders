<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - FindeRS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/styles/style_logreg.css">
</head>
<body class="h-screen w-full flex overflow-hidden bg-white">

    <div class="w-full lg:w-5/12 flex flex-col justify-center items-center px-8 lg:px-16 bg-white z-10 shadow-xl lg:shadow-none relative overflow-hidden">
        
        <div class="absolute top-0 left-0 -ml-10 -mt-10 w-40 h-40 bg-green-100 rounded-full opacity-50 blur-3xl animate-fade-in-down"></div>
        <div class="absolute bottom-0 right-0 -mr-10 -mb-10 w-40 h-40 bg-blue-100 rounded-full opacity-50 blur-3xl animate-fade-in-up"></div>

        <a href="login.php" class="absolute top-6 left-8 z-20 hover:opacity-80 transition cursor-pointer animate-fade-in-down" title="Kembali ke Login">
            <img src="assets/img/FindeRS_Logo.png" alt="FindeRS Logo" class="h-10 w-auto">
        </a>

        <div class="w-full max-w-md relative z-10 mt-10 animate-fade-in-up delay-100">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-finders-blue mb-2">Lupa Password?</h1>
                <p class="text-gray-500 text-sm">Masukkan email Anda untuk mereset password.</p>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-full relative mb-4 text-xs text-center animate-shake">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-full relative mb-4 text-xs text-center">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="api/auth/forgot-password.php" method="POST" class="space-y-5">
                
                <div class="animate-fade-in-up delay-200">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">Email Terdaftar</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        <input type="email" name="email" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="user@example.com">
                    </div>
                </div>

                <button type="submit" 
                    class="btn-pulse w-full py-3 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-[#00D348] hover:bg-[#00b03b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 transform hover:-translate-y-1 hover:scale-105 mt-4 animate-fade-in-up delay-300">
                    <span class="flex items-center justify-center gap-2">
                        LANJUTKAN
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                </button>

                <div class="text-center mt-6 animate-fade-in-up delay-500">
                    <p class="text-xs text-gray-500">
                        Ingat password Anda? <a href="login.php" class="font-bold text-finders-blue hover:text-green-600 transition underline decoration-transparent hover:decoration-green-600">Login Kembali</a>
                    </p>
                </div>
            </form>
        </div>

        <div class="absolute bottom-4 w-full text-center animate-fade-in-up delay-500">
            <p class="text-[10px] text-gray-300">
                &copy; 2025 FindeRS Healthcare System.
            </p>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-7/12 relative bg-finders-blue items-center justify-center overflow-hidden">
        <img src="assets/img/search_background.jpg" alt="Hospital Background" class="absolute inset-0 w-full h-full object-cover animate-fade-in-right opacity-50">
        <div class="absolute inset-0 bg-blue-900/85"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-16 text-white text-center animate-fade-in-up delay-200">
            <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-4">
                Keamanan Akun <br>
                <span class="text-finders-green">Prioritas Kami</span>
            </h2>
            <p class="text-blue-100 text-lg max-w-lg leading-relaxed font-light">
                Jangan khawatir jika Anda lupa password. Kami akan membantu Anda memulihkan akses ke akun FindeRS Anda dengan aman.
            </p>
        </div>
    </div>

</body>
</html>


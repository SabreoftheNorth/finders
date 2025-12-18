<?php
session_start();
if (!isset($_GET['email'])) {
    header("Location: forgot-password.php");
    exit;
}
$email = $_GET['email'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - FindeRS</title>
    
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
                <h1 class="text-3xl font-bold text-finders-blue mb-2">Reset Password</h1>
                <p class="text-gray-500 text-sm">Buat password baru untuk akun <strong><?php echo htmlspecialchars($email); ?></strong></p>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-full relative mb-4 text-xs text-center animate-shake">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="api/auth/reset-password.php" method="POST" class="space-y-5">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                
                <div class="animate-fade-in-up delay-200">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">Password Baru</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <input type="password" name="password" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="animate-fade-in-up delay-300">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944V12m0 0l4 4m-4-4l-4 4"></path>
                            </svg>
                        </span>
                        <input type="password" name="confirm_password" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" 
                    class="btn-pulse w-full py-3 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-[#00D348] hover:bg-[#00b03b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 transform hover:-translate-y-1 hover:scale-105 mt-4 animate-fade-in-up delay-300">
                    <span class="flex items-center justify-center gap-2">
                        SIMPAN PASSWORD BARU
                    </span>
                </button>
            </form>
        </div>

        <div class="absolute bottom-4 w-full text-center animate-fade-in-up delay-500">
            <p class="text-[10px] text-gray-300">
                &copy; 2025 FindeRS Healthcare System.
            </p>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-7/12 relative bg-finders-blue items-center justify-center overflow-hidden">
        <img src="assets/img/home_background.jpg" alt="Hospital Background" class="absolute inset-0 w-full h-full object-cover animate-fade-in-right opacity-50">
        <div class="absolute inset-0 bg-blue-900/85"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-16 text-white text-center animate-fade-in-up delay-200">
            <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-4">
                Langkah Terakhir <br>
                <span class="text-finders-green">Pemulihan Akun</span>
            </h2>
            <p class="text-blue-100 text-lg max-w-lg leading-relaxed font-light">
                Gunakan password yang kuat dan mudah diingat untuk menjaga keamanan akun Anda.
            </p>
        </div>
    </div>

</body>
</html>


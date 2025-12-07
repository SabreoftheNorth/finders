<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="assets/styles/style_logreg.css">
</head>
<body class="h-screen w-full flex overflow-hidden bg-white">

    <div class="w-full lg:w-5/12 flex flex-col justify-center items-center px-8 lg:px-16 bg-white z-10 shadow-xl lg:shadow-none relative overflow-y-auto">
        
        <div class="absolute top-0 left-0 -ml-10 -mt-10 w-40 h-40 bg-green-100 rounded-full opacity-50 blur-3xl animate-fade-in-down"></div>
        <div class="absolute bottom-0 right-0 -mr-10 -mb-10 w-40 h-40 bg-blue-100 rounded-full opacity-50 blur-3xl animate-fade-in-up"></div>

        <a href="index.php" class="absolute top-6 left-8 z-20 hover:opacity-80 transition cursor-pointer animate-fade-in-down" title="Kembali ke Beranda">
            <img src="assets/img/FindeRS_Logo.png" alt="FindeRS Logo" class="h-10 w-auto">
        </a>

        <div class="w-full max-w-md relative z-10 mt-16 mb-10 animate-fade-in-up delay-100">
            
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-bold text-finders-blue mb-2">Buat Akun Baru</h1>
                <p class="text-gray-500 text-sm">Lengkapi data diri Anda untuk bergabung.</p>
            </div>

            <form action="api/auth/register.php" method="POST" class="space-y-4">
                
                <div class="animate-fade-in-up delay-200">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">Nama Lengkap</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                        <input type="text" name="nama" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="Contoh: Budi Santoso">
                    </div>
                </div>

                <div class="animate-fade-in-up delay-200">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">Email</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="nama@email.com">
                    </div>
                    <p id="email-error" class="text-xs text-red-500 ml-4 mt-1 hidden">Format email tidak valid. Contoh: nama@email.com</p>
                </div>

                <div class="animate-fade-in-up delay-200">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">No. Telepon</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </span>
                        <input type="tel" name="no_telpon" id="no_telpon" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="0812xxxxxxxx" pattern="[0-9]+" inputmode="numeric">
                    </div>
                    <p id="phone-error" class="text-xs text-red-500 ml-4 mt-1 hidden">Nomor telepon hanya boleh berisi angka</p>
                </div>

                <div class="animate-fade-in-up delay-300">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">Password</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="Minimal 8 karakter" minlength="8">
                    </div>
                    <p id="password-error" class="text-xs text-red-500 ml-4 mt-1 hidden">Password minimal 8 karakter</p>
                </div>

                <div class="animate-fade-in-up delay-300">
                    <label class="block text-xs font-medium text-gray-700 ml-4 mb-1">Ulangi Password</label>
                    <div class="relative input-group">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </span>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" required 
                            class="input-enhanced block w-full pl-10 pr-6 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition text-sm shadow-sm hover:shadow-md" 
                            placeholder="••••••••">
                    </div>
                    <p id="confirm-password-error" class="text-xs text-red-500 ml-4 mt-1 hidden">Password tidak cocok</p>
                </div>

                <div class="animate-fade-in-up delay-300 flex items-start gap-3 px-4 pt-2 relative z-20">
                    <input type="checkbox" required class="custom-checkbox mt-0.5 shrink-0">
                    
                    <label class="text-xs text-gray-500 leading-relaxed select-none">
                        Saya menyetujui 
                        
                        <span class="relative group inline-block cursor-help">
                            <span class="text-finders-blue font-medium hover:text-green-600 border-b border-dashed border-finders-blue/50 hover:border-green-600 transition-colors">
                                Syarat & Ketentuan
                            </span>
                            
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/4 sm:-translate-x-1/2 mb-3 w-64 sm:w-72 p-4 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 pointer-events-none">
                                <h4 class="font-bold text-finders-blue text-sm mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Syarat Penggunaan
                                </h4>
                                <ul class="text-[10px] text-gray-500 space-y-1 list-disc ml-3 text-justify">
                                    <li>Pengguna wajib memberikan data identitas asli sesuai KTP.</li>
                                    <li>Dilarang menggunakan akun untuk tindakan ilegal atau merugikan pihak RS.</li>
                                    <li>FindeRS berhak memblokir akun yang melanggar ketentuan.</li>
                                </ul>
                                
                                <div class="absolute -bottom-1.5 left-1/4 sm:left-1/2 -ml-1.5 w-3 h-3 bg-white border-b border-r border-gray-100 transform rotate-45"></div>
                            </div>
                        </span>

                        <span class="relative group inline-block cursor-help">
                            <span class="text-finders-blue font-medium hover:text-green-600 border-b border-dashed border-finders-blue/50 hover:border-green-600 transition-colors">
                                Kebijakan Privasi
                            </span>

                            <div class="absolute bottom-full right-0 sm:left-1/2 transform sm:-translate-x-1/2 mb-3 w-64 sm:w-72 p-4 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 pointer-events-none">
                                <h4 class="font-bold text-finders-blue text-sm mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Keamanan Data
                                </h4>
                                <p class="text-[10px] text-gray-500 text-justify mb-2 leading-relaxed">
                                    Kami menghargai privasi Anda. Data pribadi Anda dilindungi dengan enkripsi tingkat tinggi.
                                </p>
                                <ul class="text-[10px] text-gray-500 space-y-1 list-disc ml-3">
                                    <li>Data tidak akan dibagikan ke pihak ketiga tanpa izin.</li>
                                    <li>Password disimpan dalam format Hash (Bcrypt/Argon2).</li>
                                </ul>
                                
                                <div class="absolute -bottom-1.5 right-8 sm:right-auto sm:left-1/2 sm:-ml-1.5 w-3 h-3 bg-white border-b border-r border-gray-100 transform rotate-45"></div>
                            </div>
                        </span>
                    </label>
                </div>

                <button type="submit" 
                    class="btn-pulse w-full py-3 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-[#00D348] hover:bg-[#00b03b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 transform hover:-translate-y-1 hover:scale-105 mt-6 animate-fade-in-up delay-300">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        DAFTAR SEKARANG
                    </span>
                </button>

                <div class="text-center mt-6 animate-fade-in-up delay-500 pb-8">
                    <p class="text-xs text-gray-500">
                        Sudah punya akun? <a href="login.php" class="font-bold text-finders-blue hover:text-green-600 transition underline decoration-transparent hover:decoration-green-600">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>

        <div class="absolute bottom-2 w-full text-center hidden lg:block animate-fade-in-up delay-500">
            <p class="text-[10px] text-gray-300">
                &copy; 2025 FindeRS Healthcare System.
            </p>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-7/12 relative bg-finders-blue items-center justify-center overflow-hidden">
        
        <img src="assets/img/rumahsakit_bg.png" alt="Hospital Hallway" class="absolute inset-0 w-full h-full object-cover animate-fade-in-right">
        
        <div class="absolute inset-0 bg-blue-900/85 animate-fade-in-right"></div>
        
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-green-400 rounded-full opacity-10 blob-anim blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-48 h-48 bg-finders-green rounded-full opacity-10 blob-anim blur-xl" style="animation-delay: 1s;"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-16 text-white text-center animate-fade-in-up delay-200">
             <div class="bg-white/10 p-4 rounded-full mb-6 backdrop-blur-sm border border-white/20 shadow-lg transform hover:rotate-12 transition duration-500">
                 <svg class="w-12 h-12 text-finders-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
             </div>

            <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-4 drop-shadow-lg">
                Bergabung <br>
                <span class="text-finders-green">Bersama Kami</span>
            </h2>
            
            <p class="text-blue-100 text-lg max-w-lg leading-relaxed font-light drop-shadow-md">
                Daftarkan diri Anda untuk kemudahan akses layanan kesehatan di berbagai rumah sakit terpercaya.
            </p>
        </div>
    </div>

    <script src="assets/js/script.js"></script>

</body>
</html>
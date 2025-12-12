<!-- Floating Window Detail Kunjungan -->
<div id="detailModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
        <div class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full animate-fade-in-up" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 rounded-t-3xl">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                            <i class="fa-solid fa-clipboard-list"></i>
                            Detail Kunjungan
                        </h3>
                        <p class="text-blue-100 text-sm mt-1">Informasi lengkap janji temu Anda</p>
                    </div>
                    <button onclick="closeDetailModal()" class="text-white/80 hover:text-white transition">
                        <i class="fa-solid fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-3 max-h-[70vh] overflow-y-auto">

                <!-- Nama Pasien -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-user text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Nama Pasien</p>
                            <p id="modalPasien" class="font-bold text-gray-800"></p>
                        </div>
                    </div>
                </div>

                <!-- Rumah Sakit -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-hospital text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Rumah Sakit</p>
                            <p id="modalRsName" class="font-bold text-gray-800"></p>
                        </div>
                    </div>
                </div>

                <!-- Layanan -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-stethoscope text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Layanan</p>
                            <p id="modalLayanan" class="font-bold text-gray-800"></p>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Kunjungan -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex flex-col items-center justify-center text-white shadow-md">
                            <span id="modalTanggal" class="text-2xl font-bold leading-none"></span>
                            <span id="modalBulan" class="text-xs font-medium"></span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Tanggal Kunjungan</p>
                            <p id="modalTanggalLengkap" class="font-bold text-gray-800"></p>
                            <p id="modalHari" class="text-sm text-gray-600"></p>
                        </div>
                    </div>
                </div>

                <!-- Queue Number & Estimasi (Jika dikonfirmasi) -->
                <div id="modalQueueSection" class="hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 p-4 rounded-xl border-2 border-blue-300 text-center">
                            <p class="text-xs text-blue-600 font-bold uppercase mb-2">No. Antrean</p>
                            <p id="modalQueue" class="text-3xl font-bold text-blue-600"></p>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-gray-200 text-center">
                            <p class="text-xs text-gray-500 font-bold uppercase mb-2">Estimasi Waktu</p>
                            <p id="modalEstimasi" class="text-lg font-bold text-gray-700"></p>
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-600 font-bold uppercase mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-note-sticky"></i> Catatan
                    </p>
                    <p id="modalCatatan" class="text-sm text-gray-700"></p>
                </div>

                <!-- Status Badge -->
                <div class="flex justify-center">
                    <span id="modalStatus" class="px-6 py-2 rounded-full text-sm font-bold border flex items-center gap-2">
                        <i id="modalStatusIcon" class="fa-solid"></i>
                        <span id="modalStatusText"></span>
                    </span>
                </div>

                <!-- QR Code (hanya tampil jika dikonfirmasi) -->
                <div id="modalQRSection" class="hidden">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 text-center hover:border-blue-300 hover:shadow-md transition-all">
                        <div class="flex justify-center mb-4">
                            <div class="w-48 h-48 bg-gray-50 flex items-center justify-center rounded-lg border border-gray-200 overflow-hidden">
                                <img src="/finders/assets/img/qrcode.png" alt="QR Code" class="w-full h-full object-contain" onerror="console.error('QR Code image failed to load')">
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-1 font-medium">Tunjukkan kode QR saat kedatangan</p>
                        <p id="modalCheckInCounter" class="text-base font-bold text-blue-600">Check-in Counter 2</p>
                    </div>
                </div>

                <!-- Dibuat Pada -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        Dibuat pada: <span id="modalDibuatPada" class="font-semibold text-gray-700"></span>
                    </p>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50/50 p-4 rounded-b-3xl border-t border-gray-200 flex gap-3">
                <button onclick="shareTicket()" class="flex-1 px-6 py-3 bg-white border-2 border-gray-300 hover:border-blue-400 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-all">
                    Share
                </button>
                <button onclick="saveTicket()" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/30">
                    Simpan Tiket
                </button>
            </div>
        </div>
    </div>
</div>

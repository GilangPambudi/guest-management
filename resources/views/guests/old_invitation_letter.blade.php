<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Pernikahan - {{ $groomName }} & {{ $brideName }}</title>
    <link rel="icon" href="{{ asset('logoQR-transparent.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- FontAwesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'dancing': ['Dancing Script', 'cursive'],
                        'playfair': ['Playfair Display', 'serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'wedding-pink': '#f093fb',
                        'wedding-purple': '#667eea',
                        'wedding-gold': '#ffecd2',
                    },
                    backgroundImage: {
                        'gradient-wedding': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'gradient-pink': 'linear-gradient(45deg, #f093fb 0%, #f5576c 100%)',
                        'gradient-gold': 'linear-gradient(45deg, #ffecd2 0%, #fcb69f 100%)',
                        'gradient-blue': 'linear-gradient(45deg, #a8edea 0%, #fed6e3 100%)',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fall': 'fall 3s linear forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        },
                        fall: {
                            '0%': {
                                transform: 'translateY(-50px) rotate(0deg)',
                                opacity: '1'
                            },
                            '100%': {
                                transform: 'translateY(100vh) rotate(360deg)',
                                opacity: '0'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }

        /* Mobile-first responsive adjustments */
        @media (max-width: 640px) {
            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }
    </style>
</head>

<body class="bg-gradient-wedding min-h-screen font-inter">
    <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div
                class="relative overflow-hidden bg-gradient-pink text-white text-center py-8 sm:py-12 md:py-16 px-4 sm:px-8">
                <!-- Decorative Background -->
                <div class="absolute inset-0 opacity-10 pointer-events-none select-none">
                    <div class="absolute inset-0"
                        style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><text y=&quot;.9em&quot; font-size=&quot;90&quot; fill=&quot;white&quot; opacity=&quot;0.1&quot;>♥</text></svg>'); background-size: 100px 100px;">
                    </div>
                </div>
                <!-- Guest Info -->
                <div class="relative z-10 max-w-xl mx-auto mb-6">
                    <div
                        class="bg-gradient-gold rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center border-l-4 border-wedding-pink shadow-lg">
                        <h2 class="font-playfair text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-2">
                            Kepada Yth. {{ $guest->guest_name }}
                        </h2>
                        <span
                            class="inline-block bg-blue-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium">
                            {{ $guest->guest_category }}
                        </span>
                    </div>
                </div>
                <!-- Couple Names & Invitation -->
                <div class="relative z-10 flex flex-col items-center">
                    <h1
                        class="font-playfair text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold mb-3 sm:mb-4 drop-shadow px-4">
                        Dengan hormat kami mengundang Anda untuk menghadiri acara pernikahan kami
                    </h1>
                    <div class="flex flex-col items-center w-full">
                        <div
                            class="bg-white bg-opacity-80 rounded-2xl shadow-lg px-6 py-4 sm:px-10 sm:py-6 border-2 border-wedding-pink 
                            inline-block 
                            w-full 
                            max-w-full 
                            sm:w-auto sm:max-w-none">
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4">
                                <span
                                    class="font-dancing text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-wedding-purple drop-shadow">
                                    {{ $groomName }}
                                </span>
                                <span
                                    class="font-dancing text-2xl sm:text-3xl md:text-4xl my-1 sm:my-0 text-gray-700">&</span>
                                <span
                                    class="font-dancing text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-wedding-purple drop-shadow">
                                    {{ $brideName }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="p-4 sm:p-6 md:p-8 space-y-4 sm:space-y-6 md:space-y-8">

                <!-- Wedding Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i
                                class="fas fa-calendar-alt text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Tanggal
                            </h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">
                                {{ \Carbon\Carbon::parse($weddingDate)->locale('id')->translatedFormat('j F Y') }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i class="fas fa-clock text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Waktu</h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">
                                {{ \Carbon\Carbon::parse($weddingTimeStart)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($weddingTimeEnd)->format('H:i') }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i
                                class="fas fa-building text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Tempat
                            </h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">{{ $weddingVenue }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i
                                class="fas fa-map-marker-alt text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Lokasi
                            </h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">{{ $weddingLocation }}</p>
                        </div>
                    </div>
                </div>

                <!-- Wedding Image -->
                @if ($weddingImage)
                    <div class="text-center">
                        <img src="{{ asset($weddingImage) }}" alt="Foto Pernikahan"
                            class="max-w-full h-auto max-h-64 sm:max-h-80 md:max-h-96 mx-auto rounded-xl sm:rounded-2xl shadow-xl">
                    </div>
                @endif

                <!-- RSVP Section -->
                <div
                    class="bg-gradient-wedding text-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0"
                            style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><text y=&quot;.9em&quot; font-size=&quot;90&quot; fill=&quot;white&quot;>📋</text></svg>'); background-size: 150px 150px;">
                        </div>
                    </div>
                    <div class="relative z-10 text-center">
                        <h3 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold mb-3 sm:mb-4">
                            <i class="fas fa-clipboard-check mr-2 sm:mr-3"></i>
                            <span class="block sm:inline">RSVP - Mohon Konfirmasi Kehadiran Anda</span>
                        </h3>

                        <div class="mb-4 sm:mb-6">
                            <span class="text-blue-200 text-sm sm:text-base">Status Saat Ini:</span>
                            <span id="current-status"
                                class="ml-2 inline-block px-3 py-1 sm:px-4 sm:py-2 rounded-full font-semibold text-xs sm:text-sm
                {{ $guest->guest_attendance_status == 'Yes'
                    ? 'bg-green-500 text-white animate-pulse-slow'
                    : ($guest->guest_attendance_status == 'No'
                        ? 'bg-red-500 text-white'
                        : 'bg-gray-500 text-white') }}">
                                {{ $guest->guest_attendance_status == '-' ? 'Belum Dikonfirmasi' : ($guest->guest_attendance_status == 'Yes' ? 'Hadir' : 'Tidak Hadir') }}
                            </span>
                        </div>

                        @if ($guest->guest_attendance_status == '-')
                            <div id="attendance-buttons"
                                class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
                                <button onclick="updateAttendance('Yes')"
                                    class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 sm:py-4 sm:px-6 md:px-8 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                    id="btn-yes">
                                    <i class="fas fa-check mr-2"></i>Ya, Saya akan Hadir
                                </button>
                                <button onclick="updateAttendance('No')"
                                    class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 sm:py-4 sm:px-6 md:px-8 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                    id="btn-no">
                                    <i class="fas fa-times mr-2"></i>Maaf, Tidak Bisa Hadir
                                </button>
                            </div>
                            <p class="text-blue-200 text-xs sm:text-sm mt-3 sm:mt-4">Konfirmasi Anda membantu kami
                                mempersiapkan
                                acara dengan lebih baik. Terima kasih!</p>
                        @else
                            <div id="attendance-confirmed">
                                @if ($guest->guest_attendance_status == 'Yes')
                                    <div
                                        class="bg-white bg-opacity-20 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-3 sm:mb-4">
                                        <div class="text-4xl sm:text-5xl md:text-6xl mb-3 sm:mb-4">🎉</div>
                                        <h4 class="text-lg sm:text-xl font-bold mb-2">Terima Kasih Sudah Konfirmasi!
                                        </h4>
                                        <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">Kami sangat senang
                                            bisa merayakan hari istimewa kami bersama Anda!</p>
                                    </div>
                                @else
                                    <div
                                        class="bg-white bg-opacity-20 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-3 sm:mb-4">
                                        <div class="text-4xl sm:text-5xl md:text-6xl mb-3 sm:mb-4">😔</div>
                                        <h4 class="text-lg sm:text-xl font-bold mb-2">Kami akan merindukan Anda!</h4>
                                        <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">Terima kasih sudah
                                            memberitahu kami.
                                            Kami mengerti dan berharap bisa merayakan bersama di lain waktu!</p>
                                    </div>
                                @endif

                                <!-- Change RSVP Button -->
                                <div id="change-rsvp-section">
                                    <button onclick="showChangeRSVP()"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                        id="btn-change-rsvp">
                                        <i class="fas fa-edit mr-2"></i>Ubah RSVP
                                    </button>
                                </div>

                                <!-- Hidden Change RSVP Buttons -->
                                <div id="change-attendance-buttons"
                                    class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center mt-3 sm:mt-4"
                                    style="display: none;">
                                    <button onclick="updateAttendance('Yes')"
                                        class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                        id="btn-change-yes">
                                        <i class="fas fa-check mr-2"></i>Ya, Saya akan Hadir
                                    </button>
                                    <button onclick="updateAttendance('No')"
                                        class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                        id="btn-change-no">
                                        <i class="fas fa-times mr-2"></i>Maaf, Tidak Bisa Hadir
                                    </button>
                                    <button onclick="hideChangeRSVP()"
                                        class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base"
                                        id="btn-cancel-change">
                                        <i class="fas fa-undo mr-2"></i>Batal
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- QR Code Section -->
                <div
                    class="bg-gradient-blue rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0"
                            style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><rect x=&quot;40&quot; y=&quot;40&quot; width=&quot;20&quot; height=&quot;20&quot; fill=&quot;white&quot; opacity=&quot;0.1&quot;/></svg>'); background-size: 100px 100px;">
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">
                            Kode QR Pribadi Anda</h3>
                        <div
                            class="bg-white p-3 sm:p-4 md:p-6 rounded-lg sm:rounded-xl md:rounded-2xl shadow-xl inline-block mb-4 sm:mb-6 hover:transform hover:scale-105 transition-all duration-300">
                            <img src="{{ asset($guest->guest_qr_code) }}" alt="QR Code Tamu"
                                class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 mx-auto">
                        </div>
                        <div class="text-gray-700">
                            <p class="mb-3 sm:mb-4 text-sm sm:text-base">Silakan tunjukkan kode QR ini di pintu masuk.
                            </p>
                            {{-- <div class="bg-gray-800 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg inline-block cursor-pointer hover:bg-gray-700 transition-colors font-mono text-xs sm:text-sm break-all"
                                onclick="copyQRCode('{{ $guest->guest_id_qr_code }}')">
                                {{ $guest->guest_id_qr_code }}
                            </div>
                            <br><small class="text-gray-500 mt-2 block text-xs sm:text-sm">Klik ID di atas untuk
                                menyalin</small> --}}
                        </div>
                    </div>
                </div>

                <!-- Maps -->
                @if ($weddingMaps)
                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink text-center">
                        <i class="fas fa-map text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-3 sm:mb-4"></i>
                        <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Petunjuk Arah
                        </h3>
                        <p class="text-gray-800 mb-3 sm:mb-4 text-sm sm:text-base">Klik di bawah untuk membuka lokasi
                            di
                            aplikasi peta Anda</p>
                        <a href="{{ $weddingMaps }}" target="_blank"
                            class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lihat di Peta
                        </a>
                    </div>
                @endif

                <!-- Wedding Wishes Section -->
                <div class="bg-gradient-blue rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0"
                            style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><text y=&quot;.9em&quot; font-size=&quot;90&quot; fill=&quot;white&quot; opacity=&quot;0.1&quot;>💌</text></svg>'); background-size: 100px 100px;">
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3
                            class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 text-center">
                            <i class="fas fa-heart mr-2 sm:mr-3 text-pink-500"></i>Ucapan & Doa
                        </h3>

                        <!-- Form Ucapan -->
                        <div class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 shadow-lg">
                            <h4 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4" id="wishFormTitle">
                                Tinggalkan Ucapan Anda</h4>
                            <div id="wishFormContainer">
                                <form id="wishForm" class="space-y-3 sm:space-y-4">
                                    <div>
                                        <textarea id="wishMessage" name="message" rows="4"
                                            placeholder="Tuliskan ucapan dan doa terbaik Anda untuk pasangan bahagia..."
                                            class="w-full p-3 sm:p-4 border border-gray-300 rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none text-sm sm:text-base"
                                            maxlength="500" required></textarea>
                                        <div class="text-right mt-1">
                                            <small class="text-gray-500" id="charCount">0/500</small>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" id="submitWishBtn"
                                            class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                                            <i class="fas fa-paper-plane mr-2"></i><span id="wishBtnText">Kirim
                                                Ucapan</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div id="editWishBtnContainer" class="text-center" style="display:none;">
                                <button type="button" onclick="showWishForm()"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                                    <i class="fas fa-edit mr-2"></i>Ubah ucapan
                                </button>
                            </div>
                        </div>

                        <!-- Daftar Ucapan -->
                        <div class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-base sm:text-lg font-bold text-gray-800">Semua Ucapan</h4>
                                <span class="text-sm text-gray-500" id="wishCount">Memuat...</span>
                            </div>

                            <div id="wishList" class="space-y-3 sm:space-y-4 max-h-96 overflow-y-auto">
                                <!-- Wishes will be loaded here -->
                                <div class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500">Memuat ucapan...</p>
                                </div>
                            </div>

                            <!-- Load More Button -->
                            <div class="text-center mt-4" id="loadMoreContainer" style="display: none;">
                                <button id="loadMoreBtn"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                                    <i class="fas fa-chevron-down mr-2"></i>Muat Lebih Banyak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wedding Gift -->
                <div
                    class="bg-gradient-pink text-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-center border-l-4 border-wedding-pink">
                    <h3 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold mb-3 sm:mb-4">
                        <i class="fas fa-gift mr-2 sm:mr-3"></i>Hadiah Pernikahan
                    </h3>
                    <p class="mb-4 sm:mb-6 text-sm sm:text-base">Doa restu Anda adalah hadiah terbaik
                        untuk kami. Namun jika Anda
                        ingin memberikan hadiah digital:</p>
                    <button type="button"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 sm:py-4 sm:px-6 md:px-8 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                        onclick="openPaymentModal()">
                        <i class="fas fa-credit-card mr-2"></i>Kirim Hadiah Digital
                    </button>
                </div>

                <!-- Footer Message -->
                <div
                    class="bg-gradient-gold rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-center border-l-4 border-wedding-pink">
                    <p class=" text-gray-700 italic text-sm sm:text-base md:text-lg mb-3 sm:mb-4">Dengan penuh sukacita
                        kami mengundang kehadiran
                        Anda untuk merayakan pernikahan kami. Kehadiran Anda akan membuat hari istimewa kami menjadi
                        lebih bermakna.</p>
                    <p class="text-gray-800 font-bold text-base sm:text-lg md:text-xl">
                        Dengan cinta dan rasa syukur,<br>
                        <span class="font-dancing">{{ $groomName }} & {{ $brideName }}</span>
                    </p>
                </div>

                {{-- <!-- Print Button -->
                <div class="text-center no-print">
                    <button onclick="window.print()"
                        class="bg-wedding-purple hover:bg-purple-700 text-white font-bold py-3 px-4 sm:py-4 sm:px-6 md:px-8 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                        <i class="fas fa-print mr-2"></i>Print Invitation
                    </button>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl sm:rounded-2xl max-w-md w-full max-h-full overflow-auto mx-4">
            <div class="bg-green-500 text-white p-4 sm:p-6 rounded-t-xl sm:rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg sm:text-xl font-bold">
                        <i class="fas fa-gift mr-2"></i>Kirim Hadiah Wedding
                    </h3>
                    <button onclick="closePaymentModal()" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-lg sm:text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-4 sm:p-6">
                <form id="paymentForm">
                    <div class="mb-4 sm:mb-6">
                        <label class="block text-gray-700 font-bold mb-3 text-sm sm:text-base">Masukkan Nominal Hadiah:</label>

                        <!-- Custom Amount Input -->
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">Rp</span>
                            <input type="number" id="customAmount" placeholder="Masukkan nominal hadiah"
                                min="1000" step="10000"
                                class="w-full pl-12 pr-4 py-3 sm:py-4 border border-gray-300 rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm sm:text-base
                                [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none
                                [appearance:textfield]"
                            >
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg sm:rounded-xl p-3 sm:p-4 mb-4 sm:mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            <span class="text-blue-700 text-xs sm:text-sm">Transaksi aman menggunakan Midtrans</span>
                        </div>
                    </div>
                </form>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <button type="button" onclick="closePaymentModal()"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-colors text-sm sm:text-base">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="button" onclick="processPayment()"
                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-colors text-sm sm:text-base">
                        <i class="fas fa-credit-card mr-2"></i>Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- CDN Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
    </script>

    <script>
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Track user interaction to mark invitation as opened
        let hasInteracted = false;
        let interactionTimer = null;

        function markAsOpened() {
            if (hasInteracted) return; // Prevent multiple calls
            
            hasInteracted = true;
            
            fetch('/mark-opened/{{ $invitation->slug }}/{{ $guest->guest_id_qr_code }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                console.log('Invitation marked as opened:', data);
            }).catch(error => {
                console.error('Error marking invitation as opened:', error);
            });
        }

        // Multiple ways to detect real user interaction
        document.addEventListener('DOMContentLoaded', function() {
            // Detect scroll (real users usually scroll)
            let scrollThreshold = 100; // pixels
            window.addEventListener('scroll', function() {
                if (window.scrollY > scrollThreshold) {
                    markAsOpened();
                }
            });

            // Detect mouse movement (bots usually don't move mouse)
            let mouseMoveCount = 0;
            document.addEventListener('mousemove', function(e) {
                mouseMoveCount++;
                if (mouseMoveCount > 5) { // After several mouse movements
                    markAsOpened();
                }
            });

            // Detect touch interaction (mobile users)
            document.addEventListener('touchstart', function() {
                markAsOpened();
            });

            // Detect any click
            document.addEventListener('click', function() {
                markAsOpened();
            });

            // Fallback: mark as opened after 10 seconds of page load (but only if page is visible)
            if (!document.hidden) {
                setTimeout(function() {
                    markAsOpened();
                }, 10000);
            }

            // Handle page visibility change (when user switches tabs)
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    // User came back to tab
                    setTimeout(function() {
                        markAsOpened();
                    }, 2000);
                }
            });
        });

        // SweetAlert2 Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function updateAttendance(status) {
            console.log('updateAttendance called with status:', status);

            // Determine which button was clicked
            let clickedBtn;
            let isChanging = false;

            // Check if change attendance buttons exist and are visible
            const changeAttendanceButtons = document.getElementById('change-attendance-buttons');

            if (changeAttendanceButtons && changeAttendanceButtons.style.display === 'flex') {
                // User is changing existing RSVP
                clickedBtn = document.getElementById('btn-change-' + (status === 'Yes' ? 'yes' : 'no'));
                isChanging = true;
            } else {
                // User is setting initial RSVP
                clickedBtn = document.getElementById('btn-' + (status === 'Yes' ? 'yes' : 'no'));
            }

            if (!clickedBtn) {
                console.error('Button not found for status:', status);
                console.log('Available buttons:', {
                    'btn-yes': document.getElementById('btn-yes'),
                    'btn-no': document.getElementById('btn-no'),
                    'btn-change-yes': document.getElementById('btn-change-yes'),
                    'btn-change-no': document.getElementById('btn-change-no'),
                    'change-attendance-buttons': changeAttendanceButtons
                });
                return;
            }

            const originalText = clickedBtn.innerHTML;
            const url = "{{ url('/update-attendance/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}";

            console.log('Making request to URL:', url);
            console.log('Request data:', {
                attendance_status: status
            });

            clickedBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memperbarui...';
            clickedBtn.disabled = true;

            // Disable all attendance buttons safely
            const attendanceButtons = document.getElementById('attendance-buttons');
            if (attendanceButtons) {
                const buttons = attendanceButtons.querySelectorAll('button');
                buttons.forEach(btn => btn.disabled = true);
            }

            if (changeAttendanceButtons) {
                const buttons = changeAttendanceButtons.querySelectorAll('button');
                buttons.forEach(btn => btn.disabled = true);
            }

            Toast.fire({
                icon: 'info',
                title: isChanging ? 'Memperbarui RSVP Anda...' : 'Memperbarui status kehadiran Anda...'
            });

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    attendance_status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Success response:', response);
                    if (response.success) {
                        updateStatusDisplay(response.new_status, isChanging);

                        let statusText = response.new_status === 'Yes' ? 'hadir' : 'tidak hadir';
                        let icon = response.new_status === 'Yes' ? 'success' : 'info';
                        let message = isChanging ?
                            `RSVP diubah! Anda sekarang terdaftar sebagai ${statusText}` :
                            `Anda sekarang terdaftar sebagai ${statusText}!`;

                        Toast.fire({
                            icon: icon,
                            title: message
                        });

                        if (response.new_status === 'Yes') {
                            celebrateAttendance();
                        }

                        // Hide change buttons if they were shown
                        if (isChanging) {
                            hideChangeRSVP();
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'Gagal memperbarui status kehadiran'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr, status, error);
                    console.error('Response text:', xhr.responseText);

                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Halaman tidak ditemukan. Silakan periksa URL.';
                    } else if (xhr.status === 422) {
                        errorMessage = 'Data yang diberikan tidak valid.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Terjadi kesalahan server.';
                    }

                    Toast.fire({
                        icon: 'error',
                        title: errorMessage
                    });
                },
                complete: function() {
                    clickedBtn.innerHTML = originalText;
                    clickedBtn.disabled = false;

                    // Re-enable all buttons safely
                    if (attendanceButtons) {
                        const buttons = attendanceButtons.querySelectorAll('button');
                        buttons.forEach(btn => btn.disabled = false);
                    }

                    if (changeAttendanceButtons) {
                        const buttons = changeAttendanceButtons.querySelectorAll('button');
                        buttons.forEach(btn => btn.disabled = false);
                    }
                }
            });
        }

        function showChangeRSVP() {
            const changeRsvpSection = document.getElementById('change-rsvp-section');
            const changeAttendanceButtons = document.getElementById('change-attendance-buttons');

            if (changeRsvpSection) {
                changeRsvpSection.style.display = 'none';
            }

            if (changeAttendanceButtons) {
                changeAttendanceButtons.style.display = 'flex';
            }

            Toast.fire({
                icon: 'info',
                title: 'Anda sekarang dapat mengubah status RSVP Anda'
            });
        }

        function hideChangeRSVP() {
            const changeRsvpSection = document.getElementById('change-rsvp-section');
            const changeAttendanceButtons = document.getElementById('change-attendance-buttons');

            if (changeRsvpSection) {
                changeRsvpSection.style.display = 'block';
            }

            if (changeAttendanceButtons) {
                changeAttendanceButtons.style.display = 'none';
            }
        }

        function updateStatusDisplay(status, isChanging = false) {
            const statusBadge = document.getElementById('current-status');
            const statusText = status === 'Yes' ? 'Hadir' : (status === 'No' ? 'Tidak Hadir' : 'Belum Dikonfirmasi');

            let statusClass = 'ml-2 inline-block px-3 py-1 sm:px-4 sm:py-2 rounded-full font-semibold text-xs sm:text-sm ';
            if (status === 'Yes') {
                statusClass += 'bg-green-500 text-white animate-pulse-slow';
            } else if (status === 'No') {
                statusClass += 'bg-red-500 text-white';
            } else {
                statusClass += 'bg-gray-500 text-white';
            }

            statusBadge.textContent = statusText;
            statusBadge.className = statusClass;

            const buttonsContainer = document.getElementById('attendance-buttons');
            const confirmedContainer = document.getElementById('attendance-confirmed');

            if (status !== '-') {
                if (buttonsContainer) {
                    buttonsContainer.style.display = 'none';
                }

                let confirmationHTML = '';
                if (status === 'Yes') {
                    confirmationHTML = `
                <div class="bg-white bg-opacity-20 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-3 sm:mb-4">
                    <div class="text-4xl sm:text-5xl md:text-6xl mb-3 sm:mb-4">🎉</div>
                    <h4 class="text-lg sm:text-xl font-bold mb-2">Terima Kasih Sudah Konfirmasi!</h4>
                    <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">Kami sangat senang bisa merayakan hari istimewa kami bersama Anda!</p>
                </div>
                <div id="change-rsvp-section">
                    <button onclick="showChangeRSVP()" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-rsvp">
                        <i class="fas fa-edit mr-2"></i>Ubah RSVP
                    </button>
                </div>
                <div id="change-attendance-buttons" class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center mt-3 sm:mt-4" style="display: none;">
                    <button onclick="updateAttendance('Yes')" 
                            class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-yes">
                        <i class="fas fa-check mr-2"></i>Ya, Saya akan Hadir
                    </button>
                    <button onclick="updateAttendance('No')" 
                            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-no">
                        <i class="fas fa-times mr-2"></i>Maaf, Tidak Bisa Hadir
                    </button>
                    <button onclick="hideChangeRSVP()" 
                            class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base" 
                            id="btn-cancel-change">
                        <i class="fas fa-undo mr-2"></i>Batal
                    </button>
                </div>
            `;
                } else {
                    confirmationHTML = `
                <div class="bg-white bg-opacity-20 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-3 sm:mb-4">
                    <div class="text-4xl sm:text-5xl md:text-6xl mb-3 sm:mb-4">😔</div>
                    <h4 class="text-lg sm:text-xl font-bold mb-2">Kami akan merindukan Anda!</h4>
                    <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">Terima kasih sudah memberitahu kami. Kami mengerti dan berharap bisa merayakan bersama di lain waktu!</p>
                </div>
                <div id="change-rsvp-section">
                    <button onclick="showChangeRSVP()" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-rsvp">
                        <i class="fas fa-edit mr-2"></i>Ubah RSVP
                    </button>
                </div>
                <div id="change-attendance-buttons" class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center mt-3 sm:mt-4" style="display: none;">
                    <button onclick="updateAttendance('Yes')" 
                            class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-yes">
                        <i class="fas fa-check mr-2"></i>Ya, Saya akan Hadir
                    </button>
                    <button onclick="updateAttendance('No')" 
                            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-no">
                        <i class="fas fa-times mr-2"></i>Maaf, Tidak Bisa Hadir
                    </button>
                    <button onclick="hideChangeRSVP()" 
                            class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base" 
                            id="btn-cancel-change">
                        <i class="fas fa-undo mr-2"></i>Batal
                    </button>
                </div>
            `;
                }

                if (confirmedContainer) {
                    confirmedContainer.innerHTML = confirmationHTML;
                    confirmedContainer.style.display = 'block';
                } else {
                    const newConfirmed = document.createElement('div');
                    newConfirmed.id = 'attendance-confirmed';
                    newConfirmed.innerHTML = confirmationHTML;
                    buttonsContainer.parentNode.insertBefore(newConfirmed, buttonsContainer.nextSibling);
                }
            }
        }

        function celebrateAttendance() {
            createFallingHearts();
        }

        function createFallingHearts() {
            const hearts = ['💖', '💕', '💗', '💓', '💝'];
            for (let i = 0; i < 10; i++) {
                setTimeout(() => {
                    const heart = document.createElement('div');
                    heart.innerHTML = hearts[Math.floor(Math.random() * hearts.length)];
                    heart.className = 'fixed text-xl sm:text-2xl pointer-events-none z-50 animate-fall';
                    heart.style.left = Math.random() * 100 + 'vw';
                    heart.style.top = '-50px';
                    document.body.appendChild(heart);
                    setTimeout(() => heart.remove(), 3000);
                }, i * 200);
            }
        }

        function copyQRCode(qrCode) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(qrCode).then(() => {
                    Toast.fire({
                        icon: 'success',
                        title: 'ID Kode QR disalin ke clipboard!'
                    });
                }).catch(() => fallbackCopyTextToClipboard(qrCode));
            } else {
                fallbackCopyTextToClipboard(qrCode);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            const tempInput = document.createElement("input");
            tempInput.style.cssText = "position: absolute; left: -9999px;";
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            Toast.fire({
                icon: 'success',
                title: 'ID Kode QR disalin ke clipboard!'
            });
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        // Global flag to prevent multiple payment processing
        let isProcessingPayment = false;

        function processPayment() {
            // Prevent multiple payment processing
            if (isProcessingPayment) {
                console.log('Payment already in progress, ignoring duplicate request');
                return;
            }

            const amount = document.getElementById('customAmount').value;
            const paymentBtn = document.querySelector('#paymentModal button[onclick="processPayment()"]');
            const originalText = paymentBtn.innerHTML;

            // Validate amount
            if (!amount || amount < 1000) {
                Swal.fire({
                    icon: 'error',
                    title: 'Nominal Tidak Valid!',
                    text: 'Minimal transaksi midtrans adalah Rp 1.000.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Format number for display
            const formattedAmount = new Intl.NumberFormat('id-ID').format(amount);

            // Show confirmation dialog
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi Pemberian Hadiah',
                html: `Anda akan memberikan hadiah <strong>Rp ${formattedAmount}</strong> kepada <strong>{{ $groomName }} & {{ $brideName }}</strong>?`,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Lanjutkan',
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#6b7280',
                reverseButtons: true // Tambahkan ini agar tombol confirm di kanan
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with payment
                    proceedToMidtrans(amount, paymentBtn, originalText);
                }
            });
        }

        function proceedToMidtrans(amount, paymentBtn, originalText) {
            // Set processing flag and update UI
            isProcessingPayment = true;
            paymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            paymentBtn.disabled = true;

            // Show loading toast
            Toast.fire({
                icon: 'info',
                title: 'Memproses transaksi...'
            });

            fetch('{{ url("/payment/create/{$invitation->slug}/{$guest->guest_id_qr_code}") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: parseInt(amount)
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Show appropriate message for reused payment
                        if (data.reused) {
                            Toast.fire({
                                icon: 'info',
                                title: data.message || 'Melanjutkan transaksi sebelumnya'
                            });
                        }

                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                closePaymentModal();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Transaksi Berhasil!',
                                    text: 'Terima kasih atas hadiah Anda.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            onPending: function(result) {
                                closePaymentModal();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Transaksi Pending',
                                    text: 'Silakan selesaikan transaksi Anda.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Transaksi Gagal!',
                                    text: 'Terjadi kesalahan dalam proses transaksi.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            onClose: function() {
                                // Reset processing flag when modal closes
                                isProcessingPayment = false;
                            }
                        });
                    } else if (data.already_paid) {
                        // Handle already paid case
                        closePaymentModal();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sudah Memberikan Hadiah',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Handle other errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memproses!',
                            text: data.message || 'Terjadi kesalahan dalam memproses transaksi.',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan sistem.',
                        confirmButtonText: 'OK'
                    });
                })
                .finally(() => {
                    // Reset UI and processing flag
                    paymentBtn.innerHTML = originalText;
                    paymentBtn.disabled = false;
                    isProcessingPayment = false;
                });
        }

        // Global variable for gift mode (no longer needed but kept for compatibility)
        let currentGiftMode = 'custom';

        function openPaymentModal() {
            // Check for existing pending payment first
            Toast.fire({
                icon: 'info',
                title: 'Memeriksa status transaksi...'
            });
            
            fetch(`{{ url('/payment/check/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}`)
                .then(response => response.json())
                .then(data => {
                    // If there's a pending payment that's still valid (less than 3 hours old)
                    if (data.has_payment && data.status === 'pending' && data.hours_since_created < 3 && data.snap_token) {
                        // Use the pending payment directly
                        Toast.fire({
                            icon: 'info',
                            title: 'Melanjutkan transaksi yang masih pending'
                        });
                        
                        // Use the snap token directly without opening modal
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Transaksi Berhasil!',
                                    text: 'Terima kasih atas hadiah Anda.',
                                    confirmButtonText: 'OK'
                                });
                                // Celebrate successful payment
                                createFallingHearts();
                            },
                            onPending: function(result) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Transaksi Pending',
                                    text: 'Silakan selesaikan transaksi Anda.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Transaksi Gagal!',
                                    text: 'Terjadi kesalahan dalam proses transaksi.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });                    }
                    // If pending payment exists but no snap token available
                    else if (data.has_payment && data.status === 'pending' && data.hours_since_created < 3 && !data.snap_token) {
                        console.error('Snap token not found for pending payment');
                        // Show error and let user create a new payment
                        Toast.fire({
                            icon: 'error',
                            title: 'Token transaksi tidak ditemukan, membuat transaksi baru'
                        });
                        document.getElementById('paymentModal').classList.remove('hidden');
                        // Focus on custom input
                        setTimeout(() => {
                            document.getElementById('customAmount').focus();
                        }, 100);
                    }
                    // If payment is already settled, show message
                    else if (data.has_payment && data.status === 'settlement') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sudah Memberikan Hadiah',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                    // If no payment or expired pending payment, show modal
                    else {
                        document.getElementById('paymentModal').classList.remove('hidden');
                        // Focus on custom input
                        setTimeout(() => {
                            document.getElementById('customAmount').focus();
                        }, 100);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                    // If error occurs, fallback to showing the modal
                    document.getElementById('paymentModal').classList.remove('hidden');
                    // Focus on custom input
                    setTimeout(() => {
                        document.getElementById('customAmount').focus();
                    }, 100);
                });
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            // Reset form
            document.getElementById('customAmount').value = '';
        }

        // Add input formatter for custom amount
        document.addEventListener('DOMContentLoaded', function() {
            const customAmountInput = document.getElementById('customAmount');

            if (customAmountInput) {
                customAmountInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^\d]/g, '');

                    // Remove leading zeros
                    value = value.replace(/^0+/, '');

                    // Ensure minimum value visual feedback only
                    if (value && parseInt(value) < 1000) {
                        // Show visual feedback but don't auto-correct
                        e.target.style.borderColor = '#ef4444';
                    } else {
                        e.target.style.borderColor = '#d1d5db';
                    }

                    e.target.value = value;
                });
            }
        });

        // Wishes functionality
        let currentPage = 1;
        let isLoading = false;
        let userHasWish = false;
        let userWish = null;

        // Character counter for wish message
        document.addEventListener('DOMContentLoaded', function() {
            const wishMessage = document.getElementById('wishMessage');
            const charCount = document.getElementById('charCount');
            const wishForm = document.getElementById('wishForm');
            const wishFormContainer = document.getElementById('wishFormContainer');
            const editWishBtnContainer = document.getElementById('editWishBtnContainer');
            const wishBtnText = document.getElementById('wishBtnText');
            const wishFormTitle = document.getElementById('wishFormTitle');

            if (wishMessage && charCount) {
                charCount.textContent = wishMessage.value.length + '/500';
                wishMessage.addEventListener('input', function() {
                    charCount.textContent = wishMessage.value.length + '/500';
                });
            }

            // Load user's existing wish first
            checkUserWish();

            // Load wishes on page load
            loadWishes();

            // Setup wish form submission
            if (wishForm) {
                wishForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const message = wishMessage.value.trim();
                    if (!message) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ucapan tidak boleh kosong!'
                        });
                        return;
                    }
                    // Kirim AJAX ke backend (ganti URL sesuai route Laravel)
                    const url = userHasWish ?
                        '{{ url('/wishes/update/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}' :
                        '{{ url('/wishes/create/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}';
                    const btn = document.getElementById('submitWishBtn');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                    btn.disabled = true;
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                message
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Toast.fire({
                                    icon: 'success',
                                    title: userHasWish ? 'Ucapan diperbarui!' :
                                        'Ucapan terkirim!'
                                });
                                userHasWish = true;
                                userWish = message;
                                // Sembunyikan form, tampilkan tombol edit
                                wishFormContainer.style.display = 'none';
                                editWishBtnContainer.style.display = 'block';
                                // Refresh daftar ucapan agar perubahan langsung terlihat
                                loadWishes(1);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Gagal mengirim ucapan.'
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan sistem.'
                            });
                        })
                        .finally(() => {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        });
                });
            }

            // Setup load more button
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    loadWishes(currentPage + 1);
                });
            }
        });

        function showWishForm() {
            document.getElementById('wishFormContainer').style.display = 'block';
            document.getElementById('editWishBtnContainer').style.display = 'none';
            const wishMessage = document.getElementById('wishMessage');
            if (wishMessage && userWish) {
                wishMessage.value = userWish;
                const charCount = document.getElementById('charCount');
                if (charCount) charCount.textContent = wishMessage.value.length + '/500';
            }
            const wishBtnText = document.getElementById('wishBtnText');
            if (wishBtnText) wishBtnText.textContent = 'Perbarui Ucapan';
        }

        function checkUserWish() {
            fetch(`{{ url('/wishes/' . $invitation->slug . '/' . $guest->guest_id_qr_code . '/check') }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.has_wish) {
                        userHasWish = true;
                        userWish = data.wish.message;
                        document.getElementById('wishFormContainer').style.display = 'none';
                        document.getElementById('editWishBtnContainer').style.display = 'block';
                    } else {
                        userHasWish = false;
                        userWish = null;
                        document.getElementById('wishFormContainer').style.display = 'block';
                        document.getElementById('editWishBtnContainer').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error checking user wish:', error);
                });
        }

        function loadWishes(page = 1) {
            if (isLoading) return;

            isLoading = true;
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const wishList = document.getElementById('wishList');

            if (page === 1) {
                wishList.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin text-2xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Loading wishes...</p>
                    </div>
                `;
            } else if (loadMoreBtn) {
                loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                loadMoreBtn.disabled = true;
            }

            fetch(`{{ url('/wishes/' . $invitation->slug) }}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayWishes(data.wishes, page === 1);
                        updateWishCount(data.total);
                        currentPage = page;

                        // Show/hide load more button
                        const loadMoreContainer = document.getElementById('loadMoreContainer');
                        if (data.has_more) {
                            loadMoreContainer.style.display = 'block';
                        } else {
                            loadMoreContainer.style.display = 'none';
                        }
                    } else {
                        if (page === 1) {
                            wishList.innerHTML = `
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-heart text-4xl mb-4 opacity-50"></i>
                                    <p>Jadilah yang pertama memberikan ucapan!</p>
                                </div>
                            `;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading wishes:', error);
                    if (page === 1) {
                        wishList.innerHTML = `
                            <div class="text-center py-4 text-red-500">
                                <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                                <p>Failed to load wishes. Please try again.</p>
                            </div>
                        `;
                    }
                })
                .finally(() => {
                    isLoading = false;
                    if (loadMoreBtn) {
                        loadMoreBtn.innerHTML = '<i class="fas fa-chevron-down mr-2"></i>Load More';
                        loadMoreBtn.disabled = false;
                    }
                });
        }

        function displayWishes(wishes, replace = false) {
            const wishList = document.getElementById('wishList');

            if (replace) {
                wishList.innerHTML = '';
            }

            if (wishes.length === 0 && replace) {
                wishList.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-heart text-4xl mb-4 opacity-50"></i>
                        <p>Be the first to leave your wishes!</p>
                    </div>
                `;
                return;
            }

            wishes.forEach(wish => {
                const wishElement = document.createElement('div');
                wishElement.className =
                    'bg-gray-50 rounded-lg p-3 sm:p-4 border-l-4 border-pink-300 hover:bg-gray-100 transition-colors';
                wishElement.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                                <h5 class="font-semibold text-gray-800 text-sm sm:text-base">${wish.guest_name}</h5>
                                <span class="text-xs text-gray-500 mt-1 sm:mt-0">${wish.created_at_formatted}</span>
                            </div>
                            <p class="text-gray-700 text-sm sm:text-base leading-relaxed">${wish.message}</p>
                        </div>
                    </div>
                `;
                wishList.appendChild(wishElement);
            });
        }

        function updateWishCount(count) {
            const wishCount = document.getElementById('wishCount');
            if (wishCount) {
                wishCount.textContent = `${count} wishes`;
            }
        }

        function submitWish() {
            const form = document.getElementById('wishForm');
            const submitBtn = document.getElementById('submitWishBtn');
            const messageInput = document.getElementById('wishMessage');
            const message = messageInput.value.trim();

            if (!message) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Please write your wishes first!'
                });
                return;
            }

            if (message.length > 500) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Your message is too long (max 500 characters)'
                });
                return;
            }

            // Check if message hasn't changed during edit
            if (userHasWish && userWish && message === userWish.message) {
                Toast.fire({
                    icon: 'info',
                    title: 'Tidak ada perubahan untuk disimpan'
                });
                return;
            }

            const originalText = submitBtn.innerHTML;
            const isEditing = userHasWish;

            submitBtn.innerHTML =
                `<i class="fas fa-spinner fa-spin mr-2"></i>${isEditing ? 'Memperbarui...' : 'Mengirim...'}`;
            submitBtn.disabled = true;

            fetch('{{ url('/wishes/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const isUpdate = data.action === 'updated';

                        Toast.fire({
                            icon: 'success',
                            title: isUpdate ? 'Ucapan Anda telah diperbarui!' : 'Ucapan Anda telah terkirim!'
                        });

                        // Update user wish status
                        userHasWish = true;
                        userWish = {
                            message: message,
                            created_at_formatted: 'just now'
                        };

                        // Update form to edit mode
                        updateWishForm();

                        // Reload wishes to show the updated one
                        loadWishes(1);

                        // Celebrate only for new wishes, not updates
                        if (!isUpdate) {
                            createFallingHearts();
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message || 'Failed to send wishes'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong. Please try again.'
                    });
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        }

        function loadWishes(page = 1) {
            if (isLoading) return;

            isLoading = true;
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const wishList = document.getElementById('wishList');

            if (page === 1) {
                wishList.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin text-2xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Loading wishes...</p>
                    </div>
                `;
            } else if (loadMoreBtn) {
                loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                loadMoreBtn.disabled = true;
            }

            fetch(`{{ url('/wishes/' . $invitation->slug) }}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayWishes(data.wishes, page === 1);
                        updateWishCount(data.total);
                        currentPage = page;

                        // Show/hide load more button
                        const loadMoreContainer = document.getElementById('loadMoreContainer');
                        if (data.has_more) {
                            loadMoreContainer.style.display = 'block';
                        } else {
                            loadMoreContainer.style.display = 'none';
                        }
                    } else {
                        if (page === 1) {
                            wishList.innerHTML = `
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-heart text-4xl mb-4 opacity-50"></i>
                                    <p>Be the first to leave your wishes!</p>
                                </div>
                            `;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading wishes:', error);
                    if (page === 1) {
                        wishList.innerHTML = `
                            <div class="text-center py-4 text-red-500">
                                <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                                <p>Failed to load wishes. Please try again.</p>
                            </div>
                        `;
                    }
                })
                .finally(() => {
                    isLoading = false;
                    if (loadMoreBtn) {
                        loadMoreBtn.innerHTML = '<i class="fas fa-chevron-down mr-2"></i>Load More';
                        loadMoreBtn.disabled = false;
                    }
                });
        }

        function displayWishes(wishes, replace = false) {
            const wishList = document.getElementById('wishList');

            if (replace) {
                wishList.innerHTML = '';
            }

            if (wishes.length === 0 && replace) {
                wishList.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-heart text-4xl mb-4 opacity-50"></i>
                        <p>Be the first to leave your wishes!</p>
                    </div>
                `;
                return;
            }

            wishes.forEach(wish => {
                const wishElement = document.createElement('div');
                wishElement.className =
                    'bg-gray-50 rounded-lg p-3 sm:p-4 border-l-4 border-pink-300 hover:bg-gray-100 transition-colors';
                wishElement.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                                <h5 class="font-semibold text-gray-800 text-sm sm:text-base">${wish.guest_name}</h5>
                                <span class="text-xs text-gray-500 mt-1 sm:mt-0">${wish.created_at_formatted}</span>
                            </div>
                            <p class="text-gray-700 text-sm sm:text-base leading-relaxed">${wish.message}</p>
                        </div>
                    </div>
                `;
                wishList.appendChild(wishElement);
            });
        }

        function updateWishCount(count) {
            const wishCount = document.getElementById('wishCount');
            if (wishCount) {
                wishCount.textContent = `${count} wishes`;
            }
        }

        function submitWish() {
            const form = document.getElementById('wishForm');
            const submitBtn = document.getElementById('submitWishBtn');
            const messageInput = document.getElementById('wishMessage');
            const message = messageInput.value.trim();

            if (!message) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Silakan tulis ucapan Anda terlebih dahulu!'
                });
                return;
            }

            if (message.length > 500) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Pesan Anda terlalu panjang (maksimal 500 karakter)'
                });
                return;
            }

            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitBtn.disabled = true;

            fetch('{{ url('/wishes/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Ucapan Anda telah terkirim!'
                        });

                        // Clear form
                        messageInput.value = '';
                        document.getElementById('charCount').textContent = '0/500';

                        // Reload wishes to show the new one
                        loadWishes(1);

                        // Celebrate
                        createFallingHearts();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message || 'Gagal mengirim ucapan'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong. Please try again.'
                    });
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        }

        // Close modal when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });
    </script>
</body>

</html>

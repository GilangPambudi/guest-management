<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Invitation - {{ $groomName }} & {{ $brideName }}</title>
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
                class="bg-gradient-pink text-white text-center py-8 sm:py-12 md:py-16 px-4 sm:px-8 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0"
                        style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><text y=&quot;.9em&quot; font-size=&quot;90&quot; fill=&quot;white&quot; opacity=&quot;0.1&quot;>♥</text></svg>'); background-size: 100px 100px;">
                    </div>
                </div>
                <div class="relative z-10">
                    <h1 class="font-dancing text-2xl sm:text-3xl md:text-4xl font-bold mb-3 sm:mb-4 animate-float">
                        You Are Cordially Invited
                    </h1>
                    <div class="font-playfair text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold">
                        {{ $groomName }}
                    </div>
                    <div class="font-dancing text-2xl sm:text-3xl md:text-4xl my-1 sm:my-2">&</div>
                    <div class="font-playfair text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold">
                        {{ $brideName }}
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="p-4 sm:p-6 md:p-8 space-y-4 sm:space-y-6 md:space-y-8">
                <!-- Guest Info -->
                <div
                    class="bg-gradient-gold rounded-xl sm:rounded-2xl p-4 sm:p-6 text-center border-l-4 border-wedding-pink">
                    <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-2">Dear
                        {{ $guest->guest_name }}</h2>
                    <span
                        class="inline-block bg-blue-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium">
                        {{ $guest->guest_category }} Guest
                    </span>
                </div>

                <!-- Wedding Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i
                                class="fas fa-calendar-alt text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Date</h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">
                                {{ \Carbon\Carbon::parse($weddingDate)->format('l, F j, Y') }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i class="fas fa-clock text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Time</h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">{{ $weddingTimeStart }} -
                                {{ $weddingTimeEnd }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i
                                class="fas fa-building text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Venue</h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">{{ $weddingVenue }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink hover:transform hover:-translate-y-1 sm:hover:-translate-y-2 transition-all duration-300">
                        <div class="text-center">
                            <i
                                class="fas fa-map-marker-alt text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-2 sm:mb-4"></i>
                            <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Location
                            </h3>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">{{ $weddingLocation }}</p>
                        </div>
                    </div>
                </div>

                <!-- Wedding Image -->
                @if ($weddingImage)
                    <div class="text-center">
                        <img src="{{ asset($weddingImage) }}" alt="Wedding Image"
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
                            <span class="block sm:inline">RSVP - Please Confirm Your Attendance</span>
                        </h3>

                        <div class="mb-4 sm:mb-6">
                            <span class="text-blue-200 text-sm sm:text-base">Current Status:</span>
                            <span id="current-status"
                                class="ml-2 inline-block px-3 py-1 sm:px-4 sm:py-2 rounded-full font-semibold text-xs sm:text-sm
                {{ $guest->guest_attendance_status == 'Yes'
                    ? 'bg-green-500 text-white animate-pulse-slow'
                    : ($guest->guest_attendance_status == 'No'
                        ? 'bg-red-500 text-white'
                        : 'bg-gray-500 text-white') }}">
                                {{ $guest->guest_attendance_status == '-' ? 'Not Confirmed' : $guest->guest_attendance_status }}
                            </span>
                        </div>

                        @if ($guest->guest_attendance_status == '-')
                            <div id="attendance-buttons"
                                class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
                                <button onclick="updateAttendance('Yes')"
                                    class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 sm:py-4 sm:px-6 md:px-8 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                    id="btn-yes">
                                    <i class="fas fa-check mr-2"></i>Yes, I'll Attend
                                </button>
                                <button onclick="updateAttendance('No')"
                                    class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 sm:py-4 sm:px-6 md:px-8 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                    id="btn-no">
                                    <i class="fas fa-times mr-2"></i>Sorry, Can't Attend
                                </button>
                            </div>
                            <p class="text-blue-200 text-xs sm:text-sm mt-3 sm:mt-4">Your response helps us prepare
                                better for the
                                celebration. Thank you!</p>
                        @else
                            <div id="attendance-confirmed">
                                @if ($guest->guest_attendance_status == 'Yes')
                                    <div
                                        class="bg-white bg-opacity-20 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-3 sm:mb-4">
                                        <div class="text-4xl sm:text-5xl md:text-6xl mb-3 sm:mb-4">🎉</div>
                                        <h4 class="text-lg sm:text-xl font-bold mb-2">Thank You for Confirming!</h4>
                                        <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">We're excited to
                                            celebrate with you on our special
                                            day!</p>
                                    </div>
                                @else
                                    <div
                                        class="bg-white bg-opacity-20 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-3 sm:mb-4">
                                        <div class="text-4xl sm:text-5xl md:text-6xl mb-3 sm:mb-4">😔</div>
                                        <h4 class="text-lg sm:text-xl font-bold mb-2">We'll Miss You!</h4>
                                        <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">Thank you for letting
                                            us know. We understand and
                                            hope to celebrate with you another time!</p>
                                    </div>
                                @endif

                                <!-- Change RSVP Button -->
                                <div id="change-rsvp-section">
                                    <button onclick="showChangeRSVP()"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                        id="btn-change-rsvp">
                                        <i class="fas fa-edit mr-2"></i>Change RSVP
                                    </button>
                                </div>

                                <!-- Hidden Change RSVP Buttons -->
                                <div id="change-attendance-buttons"
                                    class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center mt-3 sm:mt-4"
                                    style="display: none;">
                                    <button onclick="updateAttendance('Yes')"
                                        class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                        id="btn-change-yes">
                                        <i class="fas fa-check mr-2"></i>Yes, I'll Attend
                                    </button>
                                    <button onclick="updateAttendance('No')"
                                        class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base"
                                        id="btn-change-no">
                                        <i class="fas fa-times mr-2"></i>Sorry, Can't Attend
                                    </button>
                                    <button onclick="hideChangeRSVP()"
                                        class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base"
                                        id="btn-cancel-change">
                                        <i class="fas fa-undo mr-2"></i>Cancel
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
                            Your Personal QR Code</h3>
                        <div
                            class="bg-white p-3 sm:p-4 md:p-6 rounded-lg sm:rounded-xl md:rounded-2xl shadow-xl inline-block mb-4 sm:mb-6 hover:transform hover:scale-105 transition-all duration-300">
                            <img src="{{ asset($guest->guest_qr_code) }}" alt="Guest QR Code"
                                class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 mx-auto">
                        </div>
                        <div class="text-gray-700">
                            <p class="mb-3 sm:mb-4 text-sm sm:text-base">Please present this QR code at the entrance
                                for quick check-in.</p>
                            <div class="bg-gray-800 text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg inline-block cursor-pointer hover:bg-gray-700 transition-colors font-mono text-xs sm:text-sm break-all"
                                onclick="copyQRCode('{{ $guest->guest_id_qr_code }}')">
                                {{ $guest->guest_id_qr_code }}
                            </div>
                            <br><small class="text-gray-500 mt-2 block text-xs sm:text-sm">Click the ID above to
                                copy</small>
                        </div>
                    </div>
                </div>

                <!-- Maps -->
                @if ($weddingMaps)
                    <div
                        class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg border-t-4 border-wedding-pink text-center">
                        <i class="fas fa-map text-2xl sm:text-3xl md:text-4xl text-wedding-pink mb-3 sm:mb-4"></i>
                        <h3 class="text-gray-500 uppercase text-xs sm:text-sm font-semibold mb-1 sm:mb-2">Get
                            Directions</h3>
                        <p class="text-gray-800 mb-3 sm:mb-4 text-sm sm:text-base">Click below to open the location in
                            your maps application</p>
                        <a href="{{ $weddingMaps }}" target="_blank"
                            class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                            <i class="fas fa-map-marker-alt mr-2"></i>View on Maps
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
                            <i class="fas fa-heart mr-2 sm:mr-3 text-pink-500"></i>Wedding Wishes
                        </h3>

                        <!-- Form Ucapan -->
                        <div class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 shadow-lg">
                            <h4 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4">Leave Your Wishes
                            </h4>
                            <form id="wishForm" class="space-y-3 sm:space-y-4">
                                <div>
                                    <textarea id="wishMessage" name="message" rows="4"
                                        placeholder="Write your heartfelt wishes for the happy couple..."
                                        class="w-full p-3 sm:p-4 border border-gray-300 rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent resize-none text-sm sm:text-base"
                                        maxlength="500" required></textarea>
                                    <div class="text-right mt-1">
                                        <small class="text-gray-500" id="charCount">0/500</small>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="submitWishBtn"
                                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                                        <i class="fas fa-paper-plane mr-2"></i>Send Wishes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Daftar Ucapan -->
                        <div class="bg-white rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-base sm:text-lg font-bold text-gray-800">All Wishes</h4>
                                <span class="text-sm text-gray-500" id="wishCount">Loading...</span>
                            </div>

                            <div id="wishList" class="space-y-3 sm:space-y-4 max-h-96 overflow-y-auto">
                                <!-- Wishes will be loaded here -->
                                <div class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500">Loading wishes...</p>
                                </div>
                            </div>

                            <!-- Load More Button -->
                            <div class="text-center mt-4" id="loadMoreContainer" style="display: none;">
                                <button id="loadMoreBtn"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                                    <i class="fas fa-chevron-down mr-2"></i>Load More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wedding Gift -->
                <div
                    class="bg-gradient-pink text-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-center border-l-4 border-wedding-pink">
                    <h3 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold mb-3 sm:mb-4">
                        <i class="fas fa-gift mr-2 sm:mr-3"></i>Wedding Gift
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
                    <p class="text-gray-700 italic text-sm sm:text-base md:text-lg mb-3 sm:mb-4">We joyfully request
                        your presence as we celebrate our
                        union in marriage. Your presence will make our special day even more meaningful.</p>
                    <p class="text-gray-800 font-bold text-base sm:text-lg md:text-xl">
                        With love and gratitude,<br>
                        <span class="font-playfair">{{ $groomName }} & {{ $brideName }}</span>
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
                        <label class="block text-gray-700 font-bold mb-3 text-sm sm:text-base">Pilih Nominal
                            Hadiah:</label>

                        <!-- Gift Amount Selection Toggle -->
                        <div class="mb-4">
                            <div class="flex space-x-2">
                                <button type="button" onclick="toggleGiftMode('preset')"
                                    class="flex-1 py-2 px-3 text-sm font-medium rounded-lg transition-colors"
                                    id="preset-btn">
                                    💰 Preset
                                </button>
                                <button type="button" onclick="toggleGiftMode('custom')"
                                    class="flex-1 py-2 px-3 text-sm font-medium rounded-lg transition-colors"
                                    id="custom-btn">
                                    ✏️ Custom
                                </button>
                            </div>
                        </div>

                        <!-- Preset Amount Dropdown -->
                        <div id="preset-section">
                            <select id="giftAmount"
                                class="w-full p-3 sm:p-4 border border-gray-300 rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm sm:text-base">
                                <option value="50000">💰 Rp 50.000</option>
                                <option value="100000">💰 Rp 100.000</option>
                                <option value="200000">💰 Rp 200.000</option>
                                <option value="500000">💰 Rp 500.000</option>
                                <option value="1000000">💰 Rp 1.000.000</option>
                            </select>
                        </div>

                        <!-- Custom Amount Input -->
                        <div id="custom-section" style="display: none;">
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">Rp</span>
                                <input type="number" id="customAmount" placeholder="Masukkan nominal (min. 10.000)"
                                    min="10000" max="10000000" step="1000"
                                    class="w-full pl-12 pr-4 py-3 sm:py-4 border border-gray-300 rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm sm:text-base">
                            </div>
                            <small class="text-gray-500 mt-1 block text-xs">Minimal Rp 10.000 - Maksimal Rp
                                10.000.000</small>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg sm:rounded-xl p-3 sm:p-4 mb-4 sm:mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            <span class="text-blue-700 text-xs sm:text-sm">Pembayaran aman menggunakan Midtrans</span>
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

    <script>
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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

            clickedBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
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
                title: isChanging ? 'Updating your RSVP...' : 'Updating your attendance status...'
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

                        let statusText = response.new_status === 'Yes' ? 'attending' : 'not attending';
                        let icon = response.new_status === 'Yes' ? 'success' : 'info';
                        let message = isChanging ? `RSVP changed! You're now marked as ${statusText}` :
                            `You're now marked as ${statusText}!`;

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
                            title: response.message || 'Failed to update attendance status'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr, status, error);
                    console.error('Response text:', xhr.responseText);

                    let errorMessage = 'Something went wrong. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Page not found. Please check the URL.';
                    } else if (xhr.status === 422) {
                        errorMessage = 'Invalid data provided.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error occurred.';
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
                title: 'You can now change your RSVP status'
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
            const statusText = status === 'Yes' ? 'Yes' : (status === 'No' ? 'No' : 'Not Confirmed');

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
                    <h4 class="text-lg sm:text-xl font-bold mb-2">Thank You for Confirming!</h4>
                    <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">We're excited to celebrate with you on our special day!</p>
                </div>
                <div id="change-rsvp-section">
                    <button onclick="showChangeRSVP()" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-rsvp">
                        <i class="fas fa-edit mr-2"></i>Change RSVP
                    </button>
                </div>
                <div id="change-attendance-buttons" class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center mt-3 sm:mt-4" style="display: none;">
                    <button onclick="updateAttendance('Yes')" 
                            class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-yes">
                        <i class="fas fa-check mr-2"></i>Yes, I'll Attend
                    </button>
                    <button onclick="updateAttendance('No')" 
                            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-no">
                        <i class="fas fa-times mr-2"></i>Sorry, Can't Attend
                    </button>
                    <button onclick="hideChangeRSVP()" 
                            class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base" 
                            id="btn-cancel-change">
                        <i class="fas fa-undo mr-2"></i>Cancel
                    </button>
                </div>
            `;
                } else {
                    confirmationHTML = `
                <div class="bg-white bg-opacity-20 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-3 sm:mb-4">
                    <div class="text-4xl sm:text-5xl md:text-6xl mb-3 sm:mb-4">😔</div>
                    <h4 class="text-lg sm:text-xl font-bold mb-2">We'll Miss You!</h4>
                    <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">Thank you for letting us know. We understand and hope to celebrate with you another time!</p>
                </div>
                <div id="change-rsvp-section">
                    <button onclick="showChangeRSVP()" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-rsvp">
                        <i class="fas fa-edit mr-2"></i>Change RSVP
                    </button>
                </div>
                <div id="change-attendance-buttons" class="space-y-3 sm:space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center mt-3 sm:mt-4" style="display: none;">
                    <button onclick="updateAttendance('Yes')" 
                            class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-yes">
                        <i class="fas fa-check mr-2"></i>Yes, I'll Attend
                    </button>
                    <button onclick="updateAttendance('No')" 
                            class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base" 
                            id="btn-change-no">
                        <i class="fas fa-times mr-2"></i>Sorry, Can't Attend
                    </button>
                    <button onclick="hideChangeRSVP()" 
                            class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 text-sm sm:text-base" 
                            id="btn-cancel-change">
                        <i class="fas fa-undo mr-2"></i>Cancel
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
                        title: 'QR Code ID copied to clipboard!'
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
                title: 'QR Code ID copied to clipboard!'
            });
        }

        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function processPayment() {
            const amount = document.getElementById('giftAmount').value;
            const paymentBtn = document.querySelector('#paymentModal button[onclick="processPayment()"]');
            const originalText = paymentBtn.innerHTML;

            paymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            paymentBtn.disabled = true;

            fetch('{{ url("/payment/create/{$invitation->slug}/{$guest->guest_id_qr_code}") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: amount
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                closePaymentModal();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Terima kasih atas hadiah Anda.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            onPending: function(result) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Pembayaran Pending',
                                    text: 'Silakan selesaikan pembayaran Anda.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal!',
                                    text: 'Terjadi kesalahan dalam proses pembayaran.',
                                    confirmButtonText: 'OK'
                                });
                            }
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
                    paymentBtn.innerHTML = originalText;
                    paymentBtn.disabled = false;
                });
        }

        // Global variable for gift mode
        let currentGiftMode = 'preset';

        function toggleGiftMode(mode) {
            currentGiftMode = mode;
            const presetBtn = document.getElementById('preset-btn');
            const customBtn = document.getElementById('custom-btn');
            const presetSection = document.getElementById('preset-section');
            const customSection = document.getElementById('custom-section');

            if (mode === 'preset') {
                // Update buttons
                presetBtn.className =
                    'flex-1 py-2 px-3 text-sm font-medium rounded-lg transition-colors bg-green-500 text-white';
                customBtn.className =
                    'flex-1 py-2 px-3 text-sm font-medium rounded-lg transition-colors bg-gray-200 text-gray-700 hover:bg-gray-300';

                // Show/hide sections
                presetSection.style.display = 'block';
                customSection.style.display = 'none';

                // Clear custom input
                document.getElementById('customAmount').value = '';
            } else {
                // Update buttons
                presetBtn.className =
                    'flex-1 py-2 px-3 text-sm font-medium rounded-lg transition-colors bg-gray-200 text-gray-700 hover:bg-gray-300';
                customBtn.className =
                    'flex-1 py-2 px-3 text-sm font-medium rounded-lg transition-colors bg-green-500 text-white';

                // Show/hide sections
                presetSection.style.display = 'none';
                customSection.style.display = 'block';

                // Focus on custom input
                setTimeout(() => {
                    document.getElementById('customAmount').focus();
                }, 100);
            }
        }

        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
            // Initialize with preset mode
            toggleGiftMode('preset');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            // Reset form
            document.getElementById('giftAmount').value = '50000';
            document.getElementById('customAmount').value = '';
            toggleGiftMode('preset');
        }

        function processPayment() {
            let amount;

            // Get amount based on current mode
            if (currentGiftMode === 'preset') {
                amount = document.getElementById('giftAmount').value;
            } else {
                const customAmount = document.getElementById('customAmount').value;

                // Validate custom amount
                if (!customAmount || customAmount < 10000) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Nominal Tidak Valid',
                        text: 'Minimal nominal hadiah adalah Rp 10.000',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                if (customAmount > 10000000) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Nominal Terlalu Besar',
                        text: 'Maksimal nominal hadiah adalah Rp 10.000.000',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                amount = customAmount;
            }

            const paymentBtn = document.querySelector('#paymentModal button[onclick="processPayment()"]');
            const originalText = paymentBtn.innerHTML;

            paymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            paymentBtn.disabled = true;

            // Format amount for display
            const formattedAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);

            Toast.fire({
                icon: 'info',
                title: `Processing payment for ${formattedAmount}...`
            });

            fetch('{{ url("/payment/create/{$invitation->slug}/{$guest->guest_id_qr_code}") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: amount
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                closePaymentModal();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: `Terima kasih atas hadiah sebesar ${formattedAmount}.`,
                                    confirmButtonText: 'OK'
                                });

                                // Celebrate successful payment
                                createFallingHearts();
                            },
                            onPending: function(result) {
                                closePaymentModal();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Pembayaran Pending',
                                    text: 'Silakan selesaikan pembayaran Anda.',
                                    confirmButtonText: 'OK'
                                });
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal!',
                                    text: 'Terjadi kesalahan dalam proses pembayaran.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Gagal membuat transaksi.',
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
                    paymentBtn.innerHTML = originalText;
                    paymentBtn.disabled = false;
                });
        }

        // Add input formatter for custom amount
        document.addEventListener('DOMContentLoaded', function() {
            const customAmountInput = document.getElementById('customAmount');

            if (customAmountInput) {
                customAmountInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^\d]/g, '');

                    // Remove leading zeros
                    value = value.replace(/^0+/, '');

                    // Ensure minimum value
                    if (value && parseInt(value) < 10000) {
                        // Don't prevent typing, but show visual feedback
                        e.target.style.borderColor = '#ef4444';
                    } else {
                        e.target.style.borderColor = '#d1d5db';
                    }

                    e.target.value = value;
                });

                customAmountInput.addEventListener('blur', function(e) {
                    let value = parseInt(e.target.value);

                    if (value && value < 10000) {
                        e.target.value = '10000';
                        e.target.style.borderColor = '#d1d5db';

                        Toast.fire({
                            icon: 'info',
                            title: 'Minimal amount set to Rp 10.000'
                        });
                    }
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

            if (wishMessage && charCount) {
                wishMessage.addEventListener('input', function() {
                    const count = this.value.length;
                    charCount.textContent = `${count}/500`;

                    if (count > 450) {
                        charCount.classList.add('text-red-500');
                    } else {
                        charCount.classList.remove('text-red-500');
                    }
                });
            }

            // Load user's existing wish first
            checkUserWish();

            // Load wishes on page load
            loadWishes();

            // Setup wish form submission
            const wishForm = document.getElementById('wishForm');
            if (wishForm) {
                wishForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitWish();
                });
            }

            // Setup load more button
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    loadWishes(currentPage + 1);
                });
            }

            // ...existing code for custom amount input...
        });

        function checkUserWish() {
            fetch(`{{ url('/wishes/' . $invitation->slug . '/' . $guest->guest_id_qr_code . '/check') }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userHasWish = data.has_wish;
                        userWish = data.wish;

                        updateWishForm();
                    }
                })
                .catch(error => {
                    console.error('Error checking user wish:', error);
                });
        }

        function updateWishForm() {
            const submitBtn = document.getElementById('submitWishBtn');
            const wishMessage = document.getElementById('wishMessage');
            const formTitle = document.querySelector('.bg-white h4');

            if (userHasWish && userWish) {
                // User has already sent a wish - show edit mode
                formTitle.innerHTML = `
                    <i class="fas fa-edit mr-2"></i>Edit Your Wishes
                    <small class="block text-sm text-gray-500 font-normal mt-1">
                        You sent your wishes ${userWish.created_at_formatted}
                    </small>
                `;

                wishMessage.value = userWish.message;
                wishMessage.placeholder = "Edit your heartfelt wishes for the happy couple...";

                // Update character count
                const charCount = document.getElementById('charCount');
                charCount.textContent = `${userWish.message.length}/500`;

                submitBtn.innerHTML = '<i class="fas fa-edit mr-2"></i>Update Wishes';
                submitBtn.className = submitBtn.className.replace('bg-pink-500 hover:bg-pink-600',
                    'bg-yellow-500 hover:bg-yellow-600');

                // Add cancel edit button
                const cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.id = 'cancelEditBtn';
                cancelBtn.className =
                    'bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 text-sm sm:text-base ml-2';
                cancelBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Cancel Edit';
                cancelBtn.onclick = cancelEditWish;

                submitBtn.parentNode.appendChild(cancelBtn);

            } else {
                // User hasn't sent a wish yet - show normal mode
                formTitle.innerHTML = '<i class="fas fa-heart mr-2"></i>Leave Your Wishes';
                wishMessage.value = '';
                wishMessage.placeholder = "Write your heartfelt wishes for the happy couple...";
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Send Wishes';
                submitBtn.className = submitBtn.className.replace('bg-yellow-500 hover:bg-yellow-600',
                    'bg-pink-500 hover:bg-pink-600');

                // Remove cancel button if exists
                const cancelBtn = document.getElementById('cancelEditBtn');
                if (cancelBtn) {
                    cancelBtn.remove();
                }
            }
        }

        function cancelEditWish() {
            const wishMessage = document.getElementById('wishMessage');
            const charCount = document.getElementById('charCount');

            // Restore original wish message
            wishMessage.value = userWish.message;
            charCount.textContent = `${userWish.message.length}/500`;

            Toast.fire({
                icon: 'info',
                title: 'Edit cancelled'
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
                    title: 'No changes to save'
                });
                return;
            }

            const originalText = submitBtn.innerHTML;
            const isEditing = userHasWish;

            submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i>${isEditing ? 'Updating...' : 'Sending...'}`;
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
                            title: isUpdate ? 'Your wishes have been updated!' : 'Your wishes have been sent!'
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

            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
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
                            title: 'Your wishes have been sent!'
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

        // Close modal when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });
    </script>
</body>

</html>

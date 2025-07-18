<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Pernikahan - {{ $groom_name }} & {{ $bride_name }}</title>
    <link rel="icon" href="{{ asset('logoQR-transparent.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Preconnect CDN -->
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">

    <!-- Preload Resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        integrity="sha256-zRgmWB5PK4CvTx4FiXsxbHaYRBBjz/rvu97sOC7kzXI=" crossorigin="anonymous" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css"
        integrity="sha256-dABdfBfUoC8vJUBOwGVdm8L9qlMWaHTIfXt+7GnZCIo=" crossorigin="anonymous" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha256-NfRUfZNkERrKSFA0c1a8VmCplPDYtpTYj5lQmKe1R/o=" crossorigin="anonymous" as="script">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap">

    <!-- Dependencies CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        integrity="sha256-zRgmWB5PK4CvTx4FiXsxbHaYRBBjz/rvu97sOC7kzXI=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css"
        integrity="sha256-dABdfBfUoC8vJUBOwGVdm8L9qlMWaHTIfXt+7GnZCIo=" crossorigin="anonymous">

    <!-- Dependencies JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha256-NfRUfZNkERrKSFA0c1a8VmCplPDYtpTYj5lQmKe1R/o=" crossorigin="anonymous"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <!-- Custom CSS: Import guest.css (which imports common.css & animation.css) -->
    <link rel="stylesheet" href="{{ asset('css/guest.css') }}">

</head>

<body class="modal-open">
    <!-- Modal Pembuka Undangan -->
    <div id="invitation-modal" class="modal-overlay">
        <div class="d-flex justify-content-center align-items-center vh-100 overflow-y-auto">
            <div class="d-flex flex-column text-center p-4">
                <h2 class="font-esthetic mb-4 text-black" style="font-size: 2.25rem;">The Wedding Of</h2>

                @if(!empty($wedding_image))
                    <img src="{{ asset($wedding_image) }}" alt="Wedding Background" 
                         class="img-center-crop rounded-circle border border-3 border-light shadow mb-4 mx-auto" 
                         width="200" height="200">
                @else
                    <img src="{{ asset('wedding.png') }}" alt="Wedding Background" 
                         class="img-center-crop rounded-circle border border-3 border-light shadow mb-4 mx-auto" 
                         width="200" height="200">
                @endif

                <h2 class="font-esthetic mb-4 text-black" style="font-size: 2.25rem;">{{ $groom_alias }} &amp; {{ $bride_alias }}</h2>
                
                <div id="guest-name-modal" class="mb-4">
                    <div class="m-2">
                        <small class="mt-0 mb-1 mx-0 p-0 text-dark">Kepada Yth Bapak/Ibu/Saudara/i</small>
                        <p class="m-0 p-0 text-black fw-bold" style="font-size: 1.25rem">{{ $guest->guest_name ?? 'Nama Tamu' }}</p>
                    </div>
                </div>

                <button type="button" class="btn btn-light shadow rounded-4 mt-3 mx-auto" id="open-invitation-btn">
                    <i class="fa-solid fa-envelope-open fa-bounce me-2"></i>Buka Undangan
                </button>
            </div>
        </div>
    </div>

    {{-- <!-- Music Control Button - FLOATING OUTSIDE CONTENT -->
    <div id="music-control">
        <button id="music-toggle" class="btn btn-dark rounded-circle shadow-lg" onclick="toggleMusic()" title="Play/Pause Music">
            <i id="music-icon" class="fa-solid fa-play"></i>
        </button>
    </div> --}}

    <!-- Konten Undangan (Tersembunyi saat modal aktif) -->
    <div id="invitation-content" class="invitation-content bg-body-tertiary">

    <!-- Background Music -->
    <audio id="background-music" loop preload="auto">
        <source src="{{ asset('beautiful-in-white-backsound.webm') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <section id="home" class="bg-light position-relative overflow-hidden p-0 m-0 animate-section" data-animation="fade-in-up">
        @if(!empty($wedding_image))
            <img src="{{ asset($wedding_image) }}" alt="Wedding Background"
                class="position-absolute opacity-25 top-50 start-50 translate-middle bg-cover-home">
        @endif

        <div class="position-relative text-center bg-overlay-auto" style="background-color: unset;">
            <h1 class="font-esthetic pt-5 pb-4 fw-medium" style="font-size: 2.25rem;">Undangan Pernikahan</h1>

            {{-- @if($wedding_image) --}}
                <img src="{{ asset($wedding_image) }}" alt="Wedding Photo"
                    class="img-center-crop rounded-circle border border-3 border-light shadow my-4 mx-auto cursor-pointer">
            {{-- @endif --}}

            <h2 class="font-esthetic my-4" style="font-size: 2.25rem;">{{ $groom_alias }} &amp; {{ $bride_alias }}</h2>
            <p class="my-2" style="font-size: 1.25rem;">
                {{ \Carbon\Carbon::parse($wedding_date)->locale('id')->translatedFormat('l, j F Y') }}
            </p>

            <button class="btn btn-outline-auto btn-sm shadow rounded-pill px-3 py-1" style="font-size: 0.825rem;">
                <i class="fa-solid fa-calendar-check me-2"></i>Simpan ke Kalender
            </button>

            <div class="d-flex justify-content-center align-items-center mt-4 mb-2">
                <div class="swipe-indicator d-flex flex-column align-items-center">
                    <i class="fa-solid fa-angle-down fa-2x text-secondary opacity-75 mb-1"></i>
                </div>
            </div>

            <p class="pb-4 m-0 text-secondary" style="font-size: 0.825rem;">Swipe Down</p>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="svg-wrapper bg-light">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="color-theme-svg no-gap-bottom">
            <path fill="white" fill-opacity="1"
                d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,165.3C672,160,768,96,864,96C960,96,1056,160,1152,154.7C1248,149,1344,75,1392,37.3L1440,0L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <section class="bg-white text-center animate-section" id="couple" data-animation="fade-in-up">
        <h2 class="font-arabic py-4 m-0" style="font-size: 2rem;">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</h2>
        <h2 class="font-esthetic py-4 m-0" style="font-size: 2rem;">Assalamualaikum Warahmatullahi Wabarakatuh</h2>
        <p class="pb-4 px-2 m-0" style="font-size: 0.95rem;">Tanpa mengurangi rasa hormat, kami mengundang Anda untuk
            berkenan menghadiri acara pernikahan kami:</p>

        <div class="overflow-x-hidden pb-4">

            <div class="position-relative">
                <!-- Love animation -->
                <div class="position-absolute" style="top: 0%; right: 5%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        class="opacity-50" data-time="500" data-class="animate-love" viewBox="0 0 16 16">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                </div>

                <div data-aos="fade-right" data-aos-duration="2000" class="pb-1">
                    <img src="{{ $groom_image ? asset($groom_image) : asset('cowo.png') }}" alt="groom"
                        class="img-center-crop rounded-circle border border-3 border-light shadow my-4 mx-auto cursor-pointer animate-love">
                    <h2 class="font-esthetic m-0" style="font-size: 2.125rem;">{{ $groom_name }}</h2>
                    <p class="mt-3 mb-1" style="font-size: 1.25rem;">
                        @if($groom_child_number)
                            @if($groom_child_number == 1) Putra Pertama
                            @elseif($groom_child_number == 2) Putra Kedua
                            @elseif($groom_child_number == 3) Putra Ketiga
                            @else Putra ke-{{ $groom_child_number }}
                            @endif
                        @else
                            Putra
                        @endif
                    </p>
                    <p class="mb-0" style="font-size: 0.95rem;">Bapak {{ $groom_father ?? 'lorem ipsum' }}</p>
                    <p class="mb-0" style="font-size: 0.95rem;">dan</p>
                    <p class="mb-0" style="font-size: 0.95rem;">Ibu {{ $groom_mother ?? 'lorem ipsum' }}</p>
                </div>

                <!-- Love animation -->
                <div class="position-absolute" style="top: 90%; left: 5%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        class="opacity-50" data-time="2000" data-class="animate-love" viewBox="0 0 16 16">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                </div>
            </div>

            <h2 class="font-esthetic mt-4" style="font-size: 4.5rem;">&amp;</h2>

            <div class="position-relative">
                <!-- Love animation -->
                <div class="position-absolute" style="top: 0%; right: 5%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        class="opacity-50" data-time="3000" data-class="animate-love" viewBox="0 0 16 16">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                </div>

                <div data-aos="fade-left" data-aos-duration="2000" class="pb-1">
                    <img src="{{ $bride_image ? asset($bride_image) : asset('cewe.png') }}" alt="bride"
                        class="img-center-crop rounded-circle border border-3 border-light shadow my-4 mx-auto cursor-pointer animate-love">
                    <h2 class="font-esthetic m-0" style="font-size: 2.125rem;">{{ $bride_name }}</h2>
                    <p class="mt-3 mb-1" style="font-size: 1.25rem;">
                        @if($bride_child_number)
                            @if($bride_child_number == 1) Putri Pertama
                            @elseif($bride_child_number == 2) Putri Kedua
                            @elseif($bride_child_number == 3) Putri Ketiga
                            @else Putri ke-{{ $bride_child_number }}
                            @endif
                        @else
                            Putri
                        @endif
                    </p>
                    <p class="mb-0" style="font-size: 0.95rem;">Bapak {{ $bride_father ?? 'lorem ipsum' }}</p>
                    <p class="mb-0" style="font-size: 0.95rem;">dan</p>
                    <p class="mb-0" style="font-size: 0.95rem;">Ibu {{ $bride_mother ?? 'lorem ipsum' }}</p>
                </div>

                <!-- Love animation -->
                <div class="position-absolute" style="top: 90%; left: 5%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        class="opacity-50" data-time="2500" data-class="animate-love" viewBox="0 0 16 16">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="svg-wrapper bg-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="color-theme-svg no-gap-bottom">
            <path fill="#f8f9fa" fill-opacity="1"
                d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,165.3C672,160,768,96,864,96C960,96,1056,160,1152,154.7C1248,149,1344,75,1392,37.3L1440,0L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- Firman Allah Subhanahu Wa Ta'ala -->
    <section class="bg-light pt-2 pb-4 animate-section" data-animation="fade-in">
        <div class="container text-center">
            <h2 class="font-esthetic pt-2 pb-1 m-0" style="font-size: 2rem;">Allah Subhanahu Wa Ta'ala berfirman</h2>

            <div class="bg-theme-auto mt-4 p-3 shadow rounded-4" data-aos="fade-down" data-aos-duration="2000">
                <p class="p-1 mb-2" style="font-size: 0.95rem;">Dan segala sesuatu Kami ciptakan berpasang-pasangan agar
                    kamu mengingat (kebesaran Allah).</p>
                <p class="m-0 p-0 text-theme-auto" style="font-size: 0.95rem;">QS. Adh-Dhariyat: 49</p>
            </div>

            <div class="bg-theme-auto mt-4 p-3 shadow rounded-4" data-aos="fade-down" data-aos-duration="2000">
                <p class="p-1 mb-2" style="font-size: 0.95rem;">dan sesungguhnya Dialah yang menciptakan pasangan
                    laki-laki dan perempuan,</p>
                <p class="m-0 p-0 text-theme-auto" style="font-size: 0.95rem;">QS. An-Najm: 45</p>
            </div>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="svg-wrapper bg-light">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="color-theme-svg no-gap-bottom">
            <path fill="white" fill-opacity="1"
                d="M0,96L30,106.7C60,117,120,139,180,154.7C240,171,300,181,360,186.7C420,192,480,192,540,181.3C600,171,660,149,720,154.7C780,160,840,192,900,208C960,224,1020,224,1080,208C1140,192,1200,160,1260,138.7C1320,117,1380,107,1410,101.3L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- Momen Bahagia -->
    <section class="bg-white pb-2 animate-section" id="wedding-date" data-animation="slide-in-left">
        <div class="container text-center">
            <h2 class="font-esthetic py-4 m-0" style="font-size: 2.25rem;">Moment Bahagia</h2>

            <p class="py-2 m-0" style="font-size: 0.95rem;">Dengan memohon rahmat dan ridho Allah Subhanahu Wa Ta'ala,
                insyaAllah kami akan menyelenggarakan acara resepsi:</p>

            <!-- Love animation -->
            <div class="position-relative">
                <div class="position-absolute" style="top: 0%; right: 5%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        class="opacity-50" data-time="3000" data-class="animate-love" viewBox="0 0 16 16">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                </div>
            </div>

            <div class="container my-3">
                <div class="row justify-content-center g-3">
                    <div class="col-12 col-md-4">
                        <div class="card shadow rounded-4 border-0 h-100">
                            <div class="card-body py-3 px-2 text-center">
                                <div class="mb-2">
                                    <i class="fa-solid fa-calendar-days fa-lg text-theme-auto"></i>
                                </div>
                                <div class="mt-1 small">{{ \Carbon\Carbon::parse($wedding_date)->locale('id')->translatedFormat('j F Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card shadow rounded-4 border-0 h-100">
                            <div class="card-body py-3 px-2 text-center">
                                <div class="mb-2">
                                    <i class="fa-solid fa-clock fa-lg text-theme-auto"></i>
                                </div>
                                <div class="mt-1 small">
                                    {{ \Carbon\Carbon::parse($wedding_time_start)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($wedding_time_end)->format('H:i')  }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card shadow rounded-4 border-0 h-100">
                            <div class="card-body py-3 px-2 text-center">
                                <div class="mb-2">
                                    <i class="fa-solid fa-location-dot fa-lg text-theme-auto"></i>
                                </div>
                                <div class="mt-1 small">{{ $wedding_venue }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Love animation -->
            <div class="position-relative">
                <div class="position-absolute" style="top: 0%; left: 5%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                        class="opacity-50" data-time="2000" data-class="animate-love" viewBox="0 0 16 16">
                        <path
                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                </div>
            </div>

            <div class="py-2" data-aos="fade-down" data-aos-duration="1500">
                @if(!empty($wedding_maps))
                    <a href="{{ $wedding_maps }}" target="_blank"
                        class="btn btn-outline-auto btn-sm rounded-pill shadow mb-2 px-3"><i
                            class="fa-solid fa-map-location-dot me-2"></i>Lihat Google Maps</a>
                @endif
                <small class="d-block my-1">{{ $wedding_location ?? 'Nama jalan lengkap hingga provinsi' }}</small>
            </div>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="svg-wrapper bg-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="color-theme-svg no-gap-bottom">
            <path fill="#f8f9fa" fill-opacity="1"
                d="M0,96L30,106.7C60,117,120,139,180,154.7C240,171,300,181,360,186.7C420,192,480,192,540,181.3C600,171,660,149,720,154.7C780,160,840,192,900,208C960,224,1020,224,1080,208C1140,192,1200,160,1260,138.7C1320,117,1380,107,1410,101.3L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- RSVP -->
    <section class="bg-body-tertiary py-5 animate-section" id="rsvp" data-animation="zoom-in">
        <div class="container text-center">
            <h2 class="font-esthetic mb-4" style="font-size: 2rem;">Konfirmasi Kehadiran</h2>
            <p class="mb-2" style="font-size: 0.95rem;">Mohon konfirmasi kehadiran Anda pada acara pernikahan kami:</p>
            
            <!-- Default RSVP Buttons -->
            <div id="rsvp-buttons" class="d-flex justify-content-center gap-3 {{ $guest->guest_attendance_status !== '-' ? 'd-none' : '' }}">
                <button class="btn btn-sm btn-outline-danger btn-lg rounded-pill px-4" type="button" onclick="confirmAttendance('No')">
                    <i class="fa-solid fa-xmark me-2"></i>Tidak Hadir
                </button>
                <button class="btn btn-sm btn-outline-primary btn-lg rounded-pill px-4" type="button" onclick="confirmAttendance('Yes')">
                    <i class="fa-solid fa-check me-2"></i>Hadir
                </button>
            </div>

            <!-- RSVP Status Display (Hidden by default) -->
            <div id="rsvp-status" class="{{ $guest->guest_attendance_status !== '-' ? '' : 'd-none' }}">
                <div class="mb-3">
                    <h4 class="mb-2" id="rsvp-status-title">
                        @if($guest->guest_attendance_status === 'Yes')
                            <button class="btn btn-success btn-sm px-3 rounded-pill" disabled>Status RSVP: Hadir</button>
                        @elseif($guest->guest_attendance_status === 'No')
                            <button class="btn btn-danger btn-sm px-3 rounded-pill" disabled>Status RSVP: Tidak Hadir</button>
                        @endif
                    </h4>
                    <p class="mb-3" id="rsvp-status-message">
                        @if($guest->guest_attendance_status === 'Yes')
                            Terima kasih sudah konfirmasi!<br>Kami sangat senang bisa merayakan hari istimewa kami bersama Anda.
                        @elseif($guest->guest_attendance_status === 'No')
                            Kami akan merindukan Anda!<br>Terima kasih sudah memberitahu kami. Kami mengerti dan berharap bisa merayakan bersama di lain waktu.
                        @endif
                    </p>
                </div>
                <button class="btn btn-outline-warning btn-sm rounded-pill px-3" type="button" onclick="editRSVP()">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Ubah Konfirmasi
                </button>
            </div>

            <!-- Edit RSVP Options (Hidden by default) -->
            <div id="rsvp-edit" class="d-none">
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3" type="button" onclick="confirmAttendance('No')">
                        <i class="fa-solid fa-xmark me-2"></i>Tidak Hadir
                    </button>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3" type="button" onclick="confirmAttendance('Yes')">
                        <i class="fa-solid fa-check me-2"></i>Hadir
                    </button>
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" type="button" onclick="cancelEdit()">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Kode QR Pribadi, jika tamu memilih hadir, section ini muncul -->
    <section class="bg-body-tertiary py-5 animate-section {{ $guest->guest_attendance_status === 'Yes' ? '' : 'd-none' }}" id="qr-code" data-animation="fade-in">
        <div class="container text-center">
            <h2 class="font-esthetic mb-4" style="font-size: 2rem;">Kode QR Pribadi</h2>
            <p class="mb-4" style="font-size: 0.95rem;">
                Silakan tunjukkan kode QR ini di pintu masuk.
            </p>
            <div class="d-flex justify-content-center">
                <div class="bg-white rounded-4 shadow p-4">
                    @if($guest && $guest->guest_id_qr_code)
                        <img src="{{ asset($guest->guest_qr_code) }}" alt="QR Code Tamu" class="img-fluid"
                            style="max-width: 200px;">
                    @else
                        <div class="d-flex justify-content-center align-items-center bg-light rounded" 
                             style="width: 200px; height: 200px;">
                            <i class="fa-solid fa-qrcode fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="mt-3"> 
                        <small class="text-secondary">ID: {{ $guest->guest_id_qr_code ?? 'QR Tamu Undangan' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="svg-wrapper bg-body-tertiary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="color-theme-svg no-gap-bottom">
            <path fill="white" fill-opacity="1"
                d="M0,96L30,106.7C60,117,120,139,180,154.7C240,171,300,181,360,186.7C420,192,480,192,540,181.3C600,171,660,149,720,154.7C780,160,840,192,900,208C960,224,1020,224,1080,208C1140,192,1200,160,1260,138.7C1320,117,1380,107,1410,101.3L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- Gift -->
    <section class="bg-white py-2 animate-section" id="gift" data-animation="slide-in-right">
        <div class="container text-center">
            <h2 class="font-esthetic mb-4" style="font-size: 2rem;">Gift</h2>
            <p style="font-size: 0.95rem;">
                Kehadiran dan doa restu Anda merupakan hadiah terindah bagi kami.
            </p>
            <p class="mb-4" style="font-size: 0.95rem;">Namun, jika berkenan memberikan hadiah secara digital, silakan
                klik tombol di bawah ini.
            </p>
            <button class="btn btn-primary btn-lg rounded-pill shadow px-4" type="button" onclick="openPaymentModal()">
                <i class="fa-solid fa-gift me-2"></i>Beri Hadiah Digital
            </button>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="svg-wrapper bg-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="color-theme-svg no-gap-bottom">
            <path fill="#f8f9fa" fill-opacity="1"
                d="M0,96L30,106.7C60,117,120,139,180,154.7C240,171,300,181,360,186.7C420,192,480,192,540,181.3C600,171,660,149,720,154.7C780,160,840,192,900,208C960,224,1020,224,1080,208C1140,192,1200,160,1260,138.7C1320,117,1380,107,1410,101.3L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- Ucapan & Doa -->
    <section class="bg-body-tertiary my-0 pb-0 pt-3 animate-section" id="comment" data-animation="fade-in-up">
        <div class="container">
            <h2 class="font-esthetic text-center mb-4" style="font-size: 2.25rem;">Ucapan &amp; Doa</h2>
            
            <!-- Wish Form -->
            <div class="border rounded-4 shadow p-3 mb-4" id="wish-form-container">
                <div class="row justify-content-center mb-3">
                    <div class="col-12">
                        <label class="form-label mb-2"><i class="fa-solid fa-user me-2"></i>Nama</label>
                        <div class="card shadow-sm rounded-3 border-0">
                            <div class="card-body py-2">
                                <span class="fw-medium">{{ $guest->guest_name ?? 'Nama Tamu Undangan' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User's existing wish (hidden by default) -->
                <div class="d-none mb-3" id="user-wish-display">
                    <div class="alert alert-info rounded-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">Ucapan Anda:</h6>
                                <p class="mb-0" id="user-wish-text"></p>
                                <small class="text-muted" id="user-wish-date"></small>
                            </div>
                            <button class="btn btn-outline-primary btn-sm ms-2" onclick="editWish()">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Wish form (shown by default) -->
                <div class="mb-3" id="wish-form">
                    <label for="wish-message" class="form-label mb-2">
                        <i class="fa-solid fa-comment me-2"></i>Ucapan &amp; Doa
                    </label>
                    <div class="position-relative">
                        <textarea class="form-control shadow-sm rounded-3" id="wish-message" rows="4" 
                            minlength="1" maxlength="500" placeholder="Tulis ucapan dan doa Anda untuk pengantin..." 
                            autocomplete="off"></textarea>
                        <div class="text-end mt-1">
                            <small class="text-muted">
                                <span id="char-count">0</span>/500 karakter
                            </small>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary py-2 rounded-3 shadow" id="submit-wish-btn" onclick="submitWish()">
                        <i class="fa-solid fa-paper-plane me-2"></i><span id="submit-wish-text">Kirim Ucapan</span>
                    </button>
                </div>
            </div>

            <!-- Wishes Display -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-comments me-2"></i>
                        Ucapan dari Tamu (<span id="wishes-count">0</span>)
                    </h5>
                </div>
                
                <!-- Wishes List -->
                <div id="wishes-container">
                    <div class="text-center py-4" id="wishes-loading">
                        <i class="fa-solid fa-spinner fa-spin fa-2x text-muted"></i>
                        <p class="mt-2 text-muted">Memuat ucapan...</p>
                    </div>
                </div>

                <!-- Load More Button -->
                <div class="text-center mt-3 d-none" id="load-more-container">
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-4" id="load-more-btn" onclick="loadMoreWishes()">
                        <i class="fa-solid fa-plus me-2"></i>Muat Lebih Banyak
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Wave Separator -->
    <div class="svg-wrapper bg-body-tertiary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="color-theme-svg no-gap-bottom">
            <path fill="white" fill-opacity="1"
                d="M0,96L30,106.7C60,117,120,139,180,154.7C240,171,300,181,360,186.7C420,192,480,192,540,181.3C600,171,660,149,720,154.7C780,160,840,192,900,208C960,224,1020,224,1080,208C1140,192,1200,160,1260,138.7C1320,117,1380,107,1410,101.3L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z">
            </path>
        </svg>
    </div>

    <!-- End Of Invitation -->
    <section class="bg-white py-2 no-gap-bottom animate-section" data-animation="fade-in">
        <div class="container text-center">
            <p class="pb-2 pt-4" style="font-size: 0.95rem;">Terima kasih atas perhatian dan doa restu Anda, yang
                menjadi kebahagiaan serta kehormatan besar bagi kami.</p>

            <h2 class="font-esthetic" style="font-size: 2rem;">Wassalamualaikum Warahmatullahi Wabarakatuh</h2>
            <h2 class="font-arabic pt-4" style="font-size: 2rem;">اَلْحَمْدُ لِلّٰهِ رَبِّ الْعٰلَمِيْنَۙ</h2>

            <div class="mt-4 mb-2">
                <p class="font-esthetic mb-0" style="font-size: 1.5rem;">{{ $groom_alias }} &amp; {{ $bride_alias }}</p>
                <small class="text-muted">{{ $groom_name }} &amp; {{ $bride_name }}</small>
            </div>

            <hr class="my-3">

            <div class="row align-items-center justify-content-between flex-column pb-3">
                <div class="col-auto">
                    <small>Build with<i class="fa-solid fa-heart mx-1"></i>QREW</small>
                </div>
            </div>
        </div>
    </section>

    </div> <!-- End of invitation-content -->

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title font-esthetic" id="paymentModalLabel">
                        <i class="fa-solid fa-gift me-2"></i>Hadiah Digital
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="payment-content">
                        <p class="text-muted mb-3">Pilih nominal hadiah untuk {{ $groom_name }} & {{ $bride_name }}</p>

                        <!-- Custom Amount -->
                        <div class="mb-3">
                            <label for="customAmount" class="form-label">Masukkan nominal</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="customAmount" placeholder="Masukkan Nominal" min="1000">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="button" class="btn btn-primary w-100 rounded-pill" onclick="processPayment()">
                            <i class="fa-solid fa-credit-card me-2"></i>Lanjutkan Pembayaran
                        </button>
                    </div>

                    <!-- Payment Status Display (hidden by default) -->
                    <div id="payment-status" class="text-center" style="display: none;">
                        <div id="status-message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar Bottom -->
    <nav class="navbar navbar-expand sticky-bottom rounded-top-4 border-top p-0 bg-white shadow" id="navbar-menu-wrapper">
        <div id="navbar-menu-inner">
            <ul class="navbar-nav nav-justified w-100 align-items-center" id="navbar-menu">
                <li class="nav-item">
                    <a class="nav-link" href="#home">
                        <i class="fa-solid fa-house"></i>
                        <span class="d-block" style="font-size: 0.7rem;">Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#couple">
                        <i class="fa-solid fa-heart"></i>
                        <span class="d-block" style="font-size: 0.7rem;">Mempelai</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#wedding-date">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span class="d-block" style="font-size: 0.7rem;">Tanggal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gift">
                        <i class="fa-solid fa-gift"></i>
                        <span class="d-block" style="font-size: 0.7rem;">Gift</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#comment">
                        <i class="fa-solid fa-comments"></i>
                        <span class="d-block" style="font-size: 0.7rem;">Ucapan</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Modal functionality
        const modal = document.getElementById('invitation-modal');
        const openBtn = document.getElementById('open-invitation-btn');
        const invitationContent = document.getElementById('invitation-content');
        
        // Handle modal open button click
        openBtn.addEventListener('click', function() {
            // Show loading state
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Membuka undangan...';
            
            // Mark invitation as opened
            fetch(`{{ route('public.mark-as-opened', ['slug' => $invitation->slug, 'guest_id_qr_code' => $guest->guest_id_qr_code]) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Mark as opened:', data);
            })
            .catch(error => console.log('Mark as opened error:', error))
            .finally(() => {
                // Hide modal and show invitation content
                setTimeout(() => {
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    invitationContent.classList.add('show');
                    
                    // Show music control and auto-play music after modal is closed
                    setTimeout(() => {
                        const musicControl = document.getElementById('music-control');
                        if (musicControl) {
                            musicControl.style.display = 'block';
                            
                            // Auto-play music when invitation opens
                            autoPlayMusic();
                        }
                    }, 500);
                }, 500);
            });
        });

        // Scrollspy logic
        const sections = [
            { id: "home", nav: 0 },
            { id: "couple", nav: 1 },
            { id: "wedding-date", nav: 2 },
            { id: "gift", nav: 3 },
            { id: "comment", nav: 4 }
        ];
        const navLinks = document.querySelectorAll("#navbar-menu .nav-link");

        function onScroll() {
            let scrollPos = window.scrollY || window.pageYOffset;
            let offset = 80; // adjust if needed for sticky nav height
            let activeIdx = 0;
            for (let i = 0; i < sections.length; i++) {
                const sec = document.getElementById(sections[i].id);
                if (sec && sec.offsetTop - offset <= scrollPos) {
                    activeIdx = i;
                }
            }
            navLinks.forEach((link, idx) => {
                if (idx === activeIdx) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });
        }

        window.addEventListener("scroll", onScroll);
        onScroll();

        // Smooth scroll for navbar links
        navLinks.forEach(link => {
            link.addEventListener("click", function (e) {
                const href = this.getAttribute("href");
                if (href && href.startsWith("#")) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const y = target.getBoundingClientRect().top + window.pageYOffset - 70; // adjust offset
                        window.scrollTo({ top: y, behavior: "smooth" });
                    }
                }
            });
        });
    });

    // RSVP Functions
    function confirmAttendance(status) {
        // Show loading in SweetAlert
        Swal.fire({
            title: 'Memproses...',
            text: 'Sedang menyimpan konfirmasi kehadiran Anda',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Send AJAX request
        fetch(`{{ route('public.update-attendance-ajax', ['slug' => $invitation->slug, 'guest_id_qr_code' => $guest->guest_id_qr_code]) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                attendance_status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide all RSVP sections first
                document.getElementById('rsvp-buttons').classList.add('d-none');
                document.getElementById('rsvp-edit').classList.add('d-none');
                
                // Show status section
                document.getElementById('rsvp-status').classList.remove('d-none');
                
                if (status === 'Yes') {
                    // Attending
                    document.getElementById('rsvp-status-title').innerHTML = '<button class="btn btn-success btn-sm px-3 rounded-pill" disabled>Status RSVP: Hadir</button>';
                    document.getElementById('rsvp-status-message').innerHTML = 
                        'Terima kasih sudah konfirmasi!<br>Kami sangat senang bisa merayakan hari istimewa kami bersama Anda.';
                    
                    // Show QR Code section
                    document.getElementById('qr-code').classList.remove('d-none');
                    
                    // Show success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Terima Kasih!',
                        text: 'Kami sangat senang Anda dapat hadir di hari istimewa kami!',
                        confirmButtonColor: '#198754'
                    });
                } else {
                    // Not attending
                    document.getElementById('rsvp-status-title').innerHTML = '<button class="btn btn-danger btn-sm px-3 rounded-pill" disabled>Status RSVP: Tidak Hadir</button>';
                    document.getElementById('rsvp-status-message').innerHTML = 
                        'Kami akan merindukan Anda!<br>Terima kasih sudah memberitahu kami. Kami mengerti dan berharap bisa merayakan bersama di lain waktu.';
                    
                    // Hide QR Code section
                    document.getElementById('qr-code').classList.add('d-none');
                    
                    // Show info SweetAlert
                    Swal.fire({
                        icon: 'info',
                        title: 'Terima Kasih!',
                        text: 'Kami mengerti dan berharap bisa merayakan bersama di lain waktu.',
                        confirmButtonColor: '#0d6efd'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: data.message || 'Gagal menyimpan konfirmasi kehadiran.',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal terhubung ke server. Silakan coba lagi.',
                confirmButtonColor: '#dc3545'
            });
        });
    }

    function editRSVP() {
        // Hide status section and show edit options
        document.getElementById('rsvp-status').classList.add('d-none');
        document.getElementById('rsvp-edit').classList.remove('d-none');
    }

    function cancelEdit() {
        // Hide edit options and show status section
        document.getElementById('rsvp-edit').classList.add('d-none');
        document.getElementById('rsvp-status').classList.remove('d-none');
    }

    // ==========================================
    // WISHES FUNCTIONALITY
    // ==========================================
    
    let currentWishPage = 1;
    let isLoadingWishes = false;
    let hasMoreWishes = true;
    let userHasWish = false;
    let userWishData = null;

    // Initialize wishes when page loads
    document.addEventListener("DOMContentLoaded", function() {
        // Character counter for wish textarea
        const wishTextarea = document.getElementById('wish-message');
        const charCount = document.getElementById('char-count');
        
        if (wishTextarea && charCount) {
            wishTextarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                
                if (length > 500) {
                    charCount.parentElement.classList.add('text-danger');
                } else {
                    charCount.parentElement.classList.remove('text-danger');
                }
            });
        }

        // Check if user already has a wish and load wishes with delay to ensure DOM is ready
        setTimeout(() => {
            try {
                checkUserWish();
                loadWishes();
            } catch (initError) {
                console.error('Error initializing wishes:', initError);
            }
        }, 500);
    });

    function checkUserWish() {
        fetch(`{{ url('/wishes/' . $invitation->slug . '/' . $guest->guest_id_qr_code . '/check') }}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Check user wish response:', data);
            if (data.success && data.user_wish) {
                userHasWish = true;
                userWishData = data.user_wish;
                showUserWish(data.user_wish);
            }
        })
        .catch(error => {
            console.error('Error checking user wish:', error);
            // Don't show error to user for this non-critical operation
        });
    }

    function showUserWish(wish) {
        try {
            console.log('showUserWish called with:', wish);
            
            const userWishText = document.getElementById('user-wish-text');
            const userWishDate = document.getElementById('user-wish-date');
            const userWishDisplay = document.getElementById('user-wish-display');
            const wishForm = document.getElementById('wish-form');
            const submitBtn = document.getElementById('submit-wish-btn');
            
            if (!userWishText || !userWishDate || !userWishDisplay || !wishForm) {
                console.error('Required DOM elements not found for showUserWish');
                return;
            }
            
            userWishText.textContent = wish.message;
            userWishDate.textContent = 'Dikirim pada: ' + wish.created_at_formatted;
            userWishDisplay.classList.remove('d-none');
            wishForm.classList.add('d-none');
            
            // Safely update submit button text
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i><span id="submit-wish-text">Perbarui Ucapan</span>';
            }
            
            console.log('showUserWish completed successfully');
        } catch (error) {
            console.error('Error in showUserWish:', error);
        }
    }

    function editWish() {
        document.getElementById('wish-message').value = userWishData.message;
        document.getElementById('char-count').textContent = userWishData.message.length;
        document.getElementById('user-wish-display').classList.add('d-none');
        document.getElementById('wish-form').classList.remove('d-none');
    }

    function submitWish() {
        const message = document.getElementById('wish-message').value.trim();
        const submitBtn = document.getElementById('submit-wish-btn');
        
        if (!message) {
            Swal.fire({
                icon: 'warning',
                title: 'Pesan Kosong',
                text: 'Silakan tulis ucapan dan doa Anda terlebih dahulu.',
                confirmButtonColor: '#ffc107'
            });
            return;
        }

        if (message.length > 500) {
            Swal.fire({
                icon: 'warning',
                title: 'Pesan Terlalu Panjang',
                text: 'Ucapan maksimal 500 karakter.',
                confirmButtonColor: '#ffc107'
            });
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mengirim...';

        const url = userHasWish ? 
            `{{ url('/wishes/update/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}` :
            `{{ url('/wishes/create/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: userHasWish ? 'Ucapan Diperbarui!' : 'Ucapan Terkirim!',
                    text: userHasWish ? 'Ucapan Anda berhasil diperbarui.' : 'Terima kasih atas ucapan dan doa Anda!',
                    confirmButtonColor: '#198754'
                });

                // Update user wish data
                userHasWish = true;
                userWishData = {
                    message: message,
                    created_at_formatted: 'Baru saja'
                };

                console.log('About to show user wish...');
                // Show user wish display
                showUserWish(userWishData);
                
                console.log('About to clear form...');
                // Clear form
                const wishMessageElement = document.getElementById('wish-message');
                const charCountElement = document.getElementById('char-count');
                
                if (wishMessageElement) wishMessageElement.value = '';
                if (charCountElement) charCountElement.textContent = '0';

                console.log('About to reload wishes...');
                // Reload wishes to show the new/updated wish
                setTimeout(() => {
                    try {
                        currentWishPage = 1;
                        loadWishes(true);
                        console.log('Wishes reloaded successfully');
                    } catch (loadError) {
                        console.error('Error reloading wishes:', loadError);
                    }
                }, 100);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim',
                    text: data.message || 'Terjadi kesalahan saat mengirim ucapan.',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal terhubung ke server. Silakan coba lagi.',
                confirmButtonColor: '#dc3545'
            });
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i><span id="submit-wish-text">' + 
                (userHasWish ? 'Perbarui Ucapan' : 'Kirim Ucapan') + '</span>';
        });
    }

    function loadWishes(reset = false) {
        if (isLoadingWishes) return;
        
        if (reset) {
            currentWishPage = 1;
            hasMoreWishes = true;
        }

        isLoadingWishes = true;
        
        fetch(`{{ url('/wishes/' . $invitation->slug) }}?page=${currentWishPage}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            try {
                if (data.success) {
                    const container = document.getElementById('wishes-container');
                    
                    if (reset || currentWishPage === 1) {
                        container.innerHTML = '';
                    }

                    // Update wishes count
                    document.getElementById('wishes-count').textContent = data.total;

                    if (data.wishes.length === 0 && currentWishPage === 1) {
                        container.innerHTML = `
                            <div class="text-center py-4">
                                <i class="fa-solid fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada ucapan. Jadilah yang pertama memberikan ucapan!</p>
                            </div>
                        `;
                    } else {
                        data.wishes.forEach(wish => {
                            const wishElement = createWishElement(wish);
                            container.appendChild(wishElement);
                        });
                    }

                    // Update pagination
                    hasMoreWishes = data.has_more;
                    const loadMoreContainer = document.getElementById('load-more-container');
                    
                    if (hasMoreWishes && data.wishes.length > 0) {
                        loadMoreContainer.classList.remove('d-none');
                    } else {
                        loadMoreContainer.classList.add('d-none');
                    }

                    // Hide loading indicator
                    const loadingElement = document.getElementById('wishes-loading');
                    if (loadingElement) {
                        loadingElement.style.display = 'none';
                    }
                }
            } catch (domError) {
                console.error('Error updating DOM in loadWishes:', domError);
                throw domError; // Re-throw to be caught by outer catch
            }
        })
        .catch(error => {
            console.error('Error loading wishes:', error);
            const container = document.getElementById('wishes-container');
            container.innerHTML = `
                <div class="text-center py-4">
                    <i class="fa-solid fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                    <p class="text-muted">Gagal memuat ucapan. Silakan refresh halaman.</p>
                </div>
            `;
        })
        .finally(() => {
            isLoadingWishes = false;
        });
    }

    function createWishElement(wish) {
        const wishDiv = document.createElement('div');
        wishDiv.className = 'card mb-3 shadow-sm border-0';
        wishDiv.innerHTML = `
            <div class="card-body p-3">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">${wish.guest_name}</h6>
                        <p class="mb-2 text-dark">${wish.message}</p>
                        <small class="text-muted">
                            <i class="fa-solid fa-clock me-1"></i>
                            ${wish.created_at_formatted}
                        </small>
                    </div>
                </div>
            </div>
        `;
        return wishDiv;
    }

    function loadMoreWishes() {
        currentWishPage++;
        loadWishes();
    }

    // ==========================================
    // PAYMENT FUNCTIONALITY
    // ==========================================
    
    let isProcessingPayment = false;
    let selectedAmount = 0;

    function openPaymentModal() {
        // Reset modal state
        document.getElementById('payment-content').style.display = 'block';
        document.getElementById('payment-status').style.display = 'none';
        
        // Clear selections
        clearAmountSelection();
        document.getElementById('customAmount').value = '';
        
        // Check payment status first
        checkPaymentStatus();
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
        modal.show();
    }

    function closePaymentModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
        if (modal) {
            modal.hide();
        }
    }

    function selectAmount(amount) {
        selectedAmount = amount;
        
        // Clear all active states
        clearAmountSelection();
        
        // Set active state for selected button
        event.target.classList.add('active');
        event.target.classList.remove('btn-outline-primary');
        event.target.classList.add('btn-primary');
        
        // Clear custom input
        document.getElementById('customAmount').value = '';
    }

    function clearAmountSelection() {
        const buttons = document.querySelectorAll('.amount-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active', 'btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        selectedAmount = 0;
    }

    function checkPaymentStatus() {
        fetch(`/payment/check/{{ $invitation->slug }}/{{ $guest->guest_id_qr_code }}`)
            .then(response => response.json())
            .then(data => {
                if (data.has_payment) {
                    if (data.status === 'settlement') {
                        // Already paid
                        showPaymentStatus(data.message, 'success');
                    } else if (data.status === 'pending' && data.hours_since_created < 3) {
                        // Has pending payment, show continue option
                        showPendingPayment(data);
                    }
                    // If expired or other status, allow new payment
                }
            })
            .catch(error => {
                console.error('Error checking payment status:', error);
            });
    }

    function showPaymentStatus(message, type = 'info') {
        document.getElementById('payment-content').style.display = 'none';
        document.getElementById('payment-status').style.display = 'block';
        
        const statusMessage = document.getElementById('status-message');
        let alertClass = type === 'success' ? 'alert-success' : 'alert-info';
        
        statusMessage.innerHTML = `
            <div class="alert ${alertClass} text-center">
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'info-circle'} fa-2x mb-2"></i>
                <p class="mb-0">${message}</p>
            </div>
        `;
    }

    function showPendingPayment(data) {
        document.getElementById('payment-content').style.display = 'none';
        document.getElementById('payment-status').style.display = 'block';
        
        const statusMessage = document.getElementById('status-message');
        const formattedAmount = new Intl.NumberFormat('id-ID').format(data.amount);
        
        statusMessage.innerHTML = `
            <div class="alert alert-warning text-center">
                <i class="fa-solid fa-clock fa-2x mb-2"></i>
                <h6>Pembayaran Pending</h6>
                <p class="mb-3">Anda memiliki pembayaran sebesar <strong>Rp ${formattedAmount}</strong> yang masih pending.</p>
                <button class="btn btn-primary w-100 mb-2" onclick="continuePendingPayment('${data.snap_token}')">
                    <i class="fa-solid fa-credit-card me-2"></i>Lanjutkan Pembayaran
                </button>
            </div>
        `;
    }

    function continuePendingPayment(snapToken) {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil!',
                    text: 'Terima kasih atas hadiah yang Anda berikan.',
                    confirmButtonText: 'Tutup'
                }).then(() => {
                    closePaymentModal();
                });
            },
            onPending: function(result) {
                Swal.fire({
                    icon: 'info',
                    title: 'Pembayaran Pending',
                    text: 'Silakan selesaikan pembayaran Anda.',
                    confirmButtonText: 'OK'
                });
            },
            onError: function(result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Gagal',
                    text: 'Terjadi kesalahan saat memproses pembayaran.',
                    confirmButtonText: 'Coba Lagi'
                });
            }
        });
    }

    function processPayment() {
        if (isProcessingPayment) return;
        
        // Get amount
        let amount = selectedAmount;
        const customAmount = document.getElementById('customAmount').value;
        
        if (customAmount) {
            amount = parseInt(customAmount);
        }
        
        // Validate amount
        if (!amount || amount < 1000) {
            Swal.fire({
                icon: 'warning',
                title: 'Nominal Tidak Valid',
                text: 'Nominal minimal Rp 1.000',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        const formattedAmount = new Intl.NumberFormat('id-ID').format(amount);
        
        // Show confirmation
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            html: `Anda akan memberikan hadiah sebesar <strong>Rp ${formattedAmount}</strong>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                proceedToMidtrans(amount);
            }
        });
    }

    function proceedToMidtrans(amount) {
        isProcessingPayment = true;
        
        // Show loading
        Swal.fire({
            title: 'Memproses Pembayaran...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch(`/payment/create/{{ $invitation->slug }}/{{ $guest->guest_id_qr_code }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ amount: amount })
        })
        .then(response => response.json())
        .then(data => {
            isProcessingPayment = false;
            Swal.close();
            
            if (data.success) {
                // Close modal before opening Midtrans
                closePaymentModal();
                
                // Open Midtrans Snap
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pembayaran Berhasil!',
                            text: 'Terima kasih atas hadiah yang Anda berikan.',
                            confirmButtonText: 'Tutup'
                        });
                    },
                    onPending: function(result) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Pembayaran Pending',
                            text: 'Silakan selesaikan pembayaran Anda.',
                            confirmButtonText: 'OK'
                        });
                    },
                    onError: function(result) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: 'Terjadi kesalahan saat memproses pembayaran.',
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                });
            } else {
                if (data.already_paid) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sudah Memberikan Hadiah',
                        text: data.message,
                        confirmButtonText: 'Tutup'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memproses',
                        text: data.message || 'Terjadi kesalahan saat memproses pembayaran.',
                        confirmButtonText: 'Coba Lagi'
                    });
                }
            }
        })
        .catch(error => {
            isProcessingPayment = false;
            Swal.close();
            console.error('Payment error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Jaringan',
                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                confirmButtonText: 'OK'
            });
        });
    }

    // Format input amount
    document.addEventListener('DOMContentLoaded', function() {
        const customAmountInput = document.getElementById('customAmount');
        if (customAmountInput) {
            customAmountInput.addEventListener('input', function() {
                // Clear preset selection when typing custom amount
                if (this.value) {
                    clearAmountSelection();
                }
            });
        }

        // Initialize animations
        initializeAnimations();
        
        // Initialize music (try to autoplay after user interaction)
        initializeMusic();
    });

    // ==========================================
    // MUSIC FUNCTIONALITY
    // ==========================================
    
    let musicPlaying = false;
    let musicInitialized = false;

    function initializeMusic() {
        const audio = document.getElementById('background-music');
        const musicControl = document.getElementById('music-control');
        
        // Hide music control initially (will be shown when modal closes)
        musicControl.style.display = 'none';
        
        // Set initial volume
        audio.volume = 0.7;
    }

    function toggleMusic() {
        const audio = document.getElementById('background-music');
        const icon = document.getElementById('music-icon');
        
        if (musicPlaying) {
            audio.pause();
            icon.className = 'fa-solid fa-play fa-lg';
            musicPlaying = false;
        } else {
            audio.play().then(() => {
                icon.className = 'fa-solid fa-pause fa-lg';
                musicPlaying = true;
            }).catch((error) => {
                console.log('Audio play failed:', error);
                // Fallback: still show pause icon even if autoplay fails
                icon.className = 'fa-solid fa-pause fa-lg';
                musicPlaying = true;
            });
        }
    }

    function autoPlayMusic() {
        const audio = document.getElementById('background-music');
        const icon = document.getElementById('music-icon');
        
        // Try to auto-play music
        audio.play().then(() => {
            icon.className = 'fa-solid fa-pause fa-lg';
            musicPlaying = true;
            console.log('Music auto-played successfully');
        }).catch((error) => {
            console.log('Auto-play failed (browser policy):', error);
            // Keep play icon if autoplay fails due to browser policy
            icon.className = 'fa-solid fa-play fa-lg';
            musicPlaying = false;
        });
    }

    // ==========================================
    // SECTION ANIMATIONS
    // ==========================================
    
    function initializeAnimations() {
        // Create intersection observer for animations
        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add animation class with a small delay for better effect
                    setTimeout(() => {
                        entry.target.classList.add('animate-visible');
                    }, 100);
                    
                    // Stop observing this element after animation
                    animationObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe all sections with animation
        const animatedSections = document.querySelectorAll('.animate-section');
        animatedSections.forEach(section => {
            animationObserver.observe(section);
        });
    }

    // Add stagger animation for elements within sections
    function addStaggerAnimation() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const children = entry.target.querySelectorAll('h1, h2, h3, p, .btn, .card, img');
                    children.forEach((child, index) => {
                        setTimeout(() => {
                            child.style.opacity = '1';
                            child.style.transform = 'translateY(0)';
                        }, index * 100);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        // Apply to specific sections
        const staggerSections = document.querySelectorAll('#couple, #wedding-date, #gift');
        staggerSections.forEach(section => {
            const children = section.querySelectorAll('h1, h2, h3, p, .btn, .card, img');
            children.forEach(child => {
                child.style.opacity = '0';
                child.style.transform = 'translateY(20px)';
                child.style.transition = 'all 0.6s ease';
            });
            observer.observe(section);
        });
    }

    // Initialize stagger animations after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(addStaggerAnimation, 1000);
    });

    // Special animation for love elements
    document.addEventListener('DOMContentLoaded', function() {
        const loveElements = document.querySelectorAll('.animate-love');
        loveElements.forEach(element => {
            element.classList.add('animate-love');
        });
    });
</script>

</html>
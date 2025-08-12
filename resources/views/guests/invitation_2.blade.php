<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Undangan Pernikahan - {{ $groom_name }} & {{ $bride_name }}</title>
    <link rel="icon" href="{{ asset('logoQR-transparent.png') }}" type="image/png" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&family=Noto+Naskh+Arabic&display=swap"
        rel="stylesheet" />

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        integrity="sha256-zRgmWB5PK4CvTx4FiXsxbHaYRBBjz/rvu97sOC7kzXI=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css"
        integrity="sha256-dABdfBfUoC8vJUBOwGVdm8L9qlMWaHTIfXt+7GnZCIo=" crossorigin="anonymous">

  <!-- SweetAlert2 + Midtrans -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

  <!-- CSS Mandiri (Luxury) -->
  <style>
  :root{
    --bg:#f7f5f1;            /* ivory */
    --ink:#111317;           /* charcoal */
    --muted:#6f6f6f;
    --gold:#c8a96a;          /* soft gold */
    --purple:#5c4aa0;        /* royal purple */
    --purple-ink:#4b3a86;
    --card:#ffffff;
    --stroke:#efe6d3;
    --glass:rgba(255,255,255,.55);
    --glass-stroke:rgba(255,255,255,.25);
    --shadow:0 14px 40px rgba(17,19,23,.10);
    --r-xl:20px;
  }

  html{scroll-behavior:smooth}
  body{
    background:radial-gradient(120% 90% at 50% 0%,
      #fbfaf7 0%, #f8f6f2 45%, #f6f3ee 100%);
    color:var(--ink);
    font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial;
    overflow-x:hidden
  }

  /* Typography helpers */
  .font-esthetic{font-family:"Playfair Display",serif; letter-spacing:.1px}
  .font-arabic{font-family:"Noto Naskh Arabic",serif}
  .text-gold{color:var(--gold)}
  .text-purple{color:var(--purple)}

  /* Core cards & buttons */
  .lux-card{
    background:linear-gradient(180deg,#ffffff 0%,#fffdfa 100%);
    border:1px solid var(--stroke);
    border-radius:var(--r-xl);
    box-shadow:var(--shadow)
  }
  .lux-btn{border-radius:999px}

  /* Primary actions → Purple with subtle gold */
  .btn-primary{
    background:linear-gradient(180deg, var(--purple) 0%, var(--purple-ink) 100%)!important;
    border:1px solid rgba(200,169,106,.35)!important;
  }
  .btn-primary:hover{filter:brightness(.95)}
  .btn-outline-primary{
    color:var(--purple)!important;
    border-color:var(--purple)!important;
    background:transparent!important;
  }
  .btn-outline-primary:hover{
    color:#fff!important;
    background:var(--purple)!important;
    border-color:var(--purple)!important;
  }

  .btn-outline-danger{border-color:#bb6f6f}
  .btn-success,.btn-danger{box-shadow:0 8px 20px rgba(0,0,0,.06)}

  /* Opening modal (custom, bukan bootstrap) */
  .modal-overlay{position:fixed; inset:0; display:flex; align-items:center; justify-content:center; background:rgba(17,19,23,.45); backdrop-filter:blur(6px); z-index:1080}
  .modal-overlay.hidden{display:none!important}
  body.modal-open{overflow:hidden}

  /* Invitation content show/hide (dipakai script) */
  .invitation-content{opacity:0; transform:translateY(16px); transition:opacity .45s ease, transform .45s ease; display:none}
  .invitation-content.show{display:block; opacity:1; transform:none}

  /* Hero backdrop image */
  .bg-cover-home{width:100%; height:100%; object-fit:cover; opacity:.34; filter:saturate(.95) contrast(1.02)}

  /* Gold ring avatar + hint purple sheen */
  .gold-ring{position:relative; display:inline-block}
  .gold-ring>img{width:200px; height:200px; border-radius:50%; object-fit:cover}
  .gold-ring:before{
    content:""; position:absolute; inset:-6px; border-radius:50%;
    background:conic-gradient(#efe2b8,var(--gold) 20%,#e8d39a 40%, var(--purple) 60%, var(--gold) 80%, #efe2b8 100%);
    -webkit-mask:radial-gradient(circle at center, transparent 63%, #000 64%);
            mask:radial-gradient(circle at center, transparent 63%, #000 64%);
    filter:drop-shadow(0 8px 16px rgba(0,0,0,.12));
  }

  /* Section reveal */
  .animate-section{opacity:0; transform:translateY(22px); transition:opacity .6s ease, transform .6s ease}
  .animate-section.animate-visible{opacity:1; transform:none}

  /* Elegant divider: purple → gold */
  .lux-divider{
    height:1px;
    background:linear-gradient(90deg,transparent, var(--purple), var(--gold), transparent);
    opacity:.9
  }

  /* Music FAB */
  #music-control{position:fixed; right:1.25rem; bottom:5.5rem; z-index:1070; display:none; transition:transform .2s}
  #music-control:hover{transform:translateY(-2px)}
  #music-toggle{
    width:56px; height:56px; display:grid; place-items:center; border-radius:999px;
    border:1px solid var(--gold);
    background:linear-gradient(180deg, rgba(255,255,255,.7), rgba(255,255,255,.45));
    backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
    box-shadow:0 12px 28px rgba(0,0,0,.14)
  }
  #music-toggle i{font-size:1.05rem; color:var(--purple)}

  @media (min-width:992px){ #music-control{bottom:1.25rem} }

  /* Sticky bottom navbar – neutral base, purple active */
  #navbar-menu-wrapper{
    position:fixed; left:0; right:0; bottom:0; z-index:1060; background:#fff;
    border-top:1px solid rgba(0,0,0,.06);
    box-shadow:0 -10px 28px rgba(0,0,0,.06)
  }
  #navbar-menu .nav-link{color:#7a7f88; padding:.6rem .25rem; text-align:center}
  #navbar-menu .nav-link.active{
    color:var(--purple)!important;
    text-shadow:0 0 0 currentColor;
  }
  #navbar-menu .nav-link i{
    font-size:1.2rem; margin-bottom:.2rem;
    transition:transform .15s ease
  }
  #navbar-menu .nav-link.active i{transform:translateY(-2px)}

  /* Utility */
  .img-center-crop{object-fit:cover; object-position:center}
  .lead-muted{color:var(--muted)}
  .btn:focus-visible{outline:3px solid rgba(92,74,160,.25); outline-offset:1px}

  /* Home header soft halo */
  #home .position-relative{
    background:
      radial-gradient(60% 60% at 50% 20%, rgba(255,255,255,.75), rgba(248,246,242,.96) 60%, rgba(248,246,242,1) 100%),
      radial-gradient(30% 30% at 80% 0%, rgba(92,74,160,.08), transparent 70%),
      radial-gradient(30% 30% at 20% 0%, rgba(200,169,106,.10), transparent 70%);
  }

  /* Icon accent in info cards */
  #wedding-date .lux-card i,
  #gift .lux-card i{ color:var(--purple) }

  /* Alerts & badges tweak */
  .alert-info{border:1px solid rgba(92,74,160,.25)}
  .alert-warning{border:1px solid rgba(200,169,106,.35)}

  /* Inputs */
  .form-control{
    border-radius:14px;
    border:1px solid #e9e2d4;
    box-shadow:0 2px 6px rgba(0,0,0,.03) inset;
  }
  .form-control:focus{
    border-color:var(--purple);
    box-shadow:0 0 0 .2rem rgba(92,74,160,.12)
  }

  /* Modals */
  .modal-content{
    border:1px solid #eee3c8;
    box-shadow:0 18px 40px rgba(0,0,0,.18)
  }
  .modal-header{
    background:linear-gradient(180deg, var(--purple) 0%, var(--purple-ink) 100%)!important;
    color:#fff
  }

  /* Small copy */
  hr{opacity:.2}
</style>


  <!-- Bootstrap JS -->
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
          integrity="sha256-NfRUfZNkERrKSFA0c1a8VmCplPDYtpTYj5lQmKe1R/o=" crossorigin="anonymous"></script>
</head>

<body class="modal-open luxury-body">
  <!-- Opening Modal (ID dipakai script) -->
  <div id="invitation-modal" class="modal-overlay">
    <div class="container" style="max-width:640px;">
      <div class="lux-card text-center p-4 p-md-5">
        <div class="mb-3">
          <div class="gold-ring">
            @if (!empty($wedding_image))
              <img src="{{ asset($wedding_image) }}" alt="Wedding" width="220" height="220" class="img-center-crop">
            @else
              <img src="{{ asset('wedding.png') }}" alt="Wedding" width="220" height="220" class="img-center-crop">
            @endif
          </div>
        </div>
        <div class="text-uppercase small lead-muted">The Wedding Of</div>
        <h1 class="font-esthetic mt-1 mb-3" style="font-size:2.1rem">{{ $groom_alias }} <span class="text-gold">&amp;</span> {{ $bride_alias }}</h1>

        <div id="guest-name-modal" class="mb-3">
          <small class="d-block lead-muted">Kepada Yth Bapak/Ibu/Saudara/i</small>
          <div class="fw-semibold" style="font-size:1.05rem">{{ $guest->guest_name ?? 'Nama Tamu' }}</div>
        </div>

        <button id="open-invitation-btn" type="button" class="btn btn-dark lux-btn px-4">
          <i class="fa-solid fa-envelope-open me-2"></i>Buka Undangan
        </button>
      </div>
    </div>
  </div>

  <!-- Music Control -->
  <div id="music-control">
    <button id="music-toggle" class="btn lux-btn" onclick="toggleMusic()" title="Play/Pause Music">
      <i id="music-icon" class="fa-solid fa-play"></i>
    </button>
  </div>

  <!-- ====== KONTEN UTAMA ====== -->
  <div id="invitation-content" class="invitation-content">

    <!-- Audio -->
    <audio id="background-music" loop preload="auto">
      <source src="{{ asset('beautiful-in-white-backsound.webm') }}" type="audio/webm">
      Your browser does not support the audio element.
    </audio>

    <!-- ====== HERO / HOME ====== -->
    <section id="home" class="position-relative overflow-hidden p-0 m-0 animate-section" data-animation="fade-in-up">
      @if (!empty($wedding_image))
        <img src="{{ asset($wedding_image) }}" alt="" class="position-absolute top-0 start-0 bg-cover-home">
      @endif

      <div class="position-relative">
        <div class="container">
          <div class="row align-items-center justify-content-center" style="min-height:calc(100svh - 72px);">
            <div class="col-12 col-lg-10">
              <div class="d-flex flex-column align-items-center text-center">
                <div class="gold-ring mt-5 mt-lg-0">
                  <img src="{{ asset($wedding_image ?: 'wedding.png') }}" alt="Couple" width="240" height="240" class="img-center-crop">
                </div>

                <div class="mt-4">
                  <h1 class="font-esthetic mb-2" style="font-size:2.4rem;">Undangan Pernikahan</h1>
                  <h2 class="font-esthetic my-2" style="font-size:2.2rem;">{{ $groom_alias }} &amp; {{ $bride_alias }}</h2>
                  <p class="my-2 lead-muted" style="font-size:1.05rem;">
                    {{ \Carbon\Carbon::parse($wedding_date)->locale('id')->translatedFormat('l, j F Y') }}
                  </p>
                </div>

                <div class="mt-3 d-flex gap-2 flex-wrap justify-content-center">
                  <button id="save-to-calendar" class="btn btn-outline-dark btn-sm lux-btn px-3">
                    <i class="fa-solid fa-calendar-check me-2"></i>Simpan ke Google Kalender
                  </button>
                  @if (!empty($wedding_maps))
                    <a href="{{ $wedding_maps }}" target="_blank" class="btn btn-outline-dark btn-sm lux-btn px-3">
                      <i class="fa-solid fa-map-location-dot me-2"></i>Lihat Google Maps
                    </a>
                  @endif
                </div>

                <div class="mt-5 mb-2" aria-hidden="true">
                  <i class="fa-solid fa-angle-down fa-2x text-secondary opacity-75"></i>
                </div>
                <p class="pb-4 m-0 text-secondary" style="font-size:.85rem;">Swipe Down</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="lux-divider"></div>

    <!-- ====== COUPLE (3 kolom: groom | & | bride) ====== -->
    <section id="couple" class="animate-section" data-animation="fade-in-up">
      <div class="container py-5">
        <div class="text-center mb-4">
          <h2 class="font-arabic m-0" style="font-size:1.6rem;">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</h2>
          <h2 class="font-esthetic mt-2 mb-2" style="font-size:1.8rem;">Assalamualaikum Warahmatullahi Wabarakatuh</h2>
          <p class="lead-muted m-0" style="font-size:.95rem;">Tanpa mengurangi rasa hormat, kami mengundang Anda untuk menghadiri acara pernikahan kami:</p>
        </div>

        <div class="row g-4 align-items-stretch justify-content-center">
          <!-- Groom -->
          <div class="col-12 col-lg-4">
            <div class="lux-card h-100 p-4 text-center">
              <div class="gold-ring mb-3">
                <img src="{{ $groom_image ? asset($groom_image) : asset('cowo.png') }}" alt="groom" width="180" height="180" class="img-center-crop">
              </div>
              <h3 class="font-esthetic m-0" style="font-size:1.7rem;">{{ $groom_name }}</h3>
              <p class="mt-2 mb-1" style="font-size:1.05rem;">
                @if ($groom_child_number)
                  @if ($groom_child_number == 1) Putra Pertama
                  @elseif($groom_child_number == 2) Putra Kedua
                  @elseif($groom_child_number == 3) Putra Ketiga
                  @else Putra ke-{{ $groom_child_number }} @endif
                @else Putra @endif
              </p>
              <small class="d-block lead-muted">Bapak {{ $groom_father ?? 'lorem ipsum' }}</small>
              <small class="d-block lead-muted">Ibu {{ $groom_mother ?? 'lorem ipsum' }}</small>
            </div>
          </div>

          <!-- Ampersand -->
          <div class="col-12 col-lg-1 d-flex align-items-center justify-content-center">
            <div class="font-esthetic display-5 text-gold">&amp;</div>
          </div>

          <!-- Bride -->
          <div class="col-12 col-lg-4">
            <div class="lux-card h-100 p-4 text-center">
              <div class="gold-ring mb-3">
                <img src="{{ $bride_image ? asset($bride_image) : asset('cewe.png') }}" alt="bride" width="180" height="180" class="img-center-crop">
              </div>
              <h3 class="font-esthetic m-0" style="font-size:1.7rem;">{{ $bride_name }}</h3>
              <p class="mt-2 mb-1" style="font-size:1.05rem;">
                @if ($bride_child_number)
                  @if ($bride_child_number == 1) Putri Pertama
                  @elseif($bride_child_number == 2) Putri Kedua
                  @elseif($bride_child_number == 3) Putri Ketiga
                  @else Putri ke-{{ $bride_child_number }} @endif
                @else Putri @endif
              </p>
              <small class="d-block lead-muted">Bapak {{ $bride_father ?? 'lorem ipsum' }}</small>
              <small class="d-block lead-muted">Ibu {{ $bride_mother ?? 'lorem ipsum' }}</small>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="lux-divider"></div>

    <!-- ====== AYAT (2 kartu rapi) ====== -->
    <section class="animate-section" data-animation="fade-in">
      <div class="container py-4">
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="lux-card p-4 h-100 text-center">
              <p class="mb-2" style="font-size:.98rem;">Dan segala sesuatu Kami ciptakan berpasang-pasangan agar kamu mengingat (kebesaran Allah).</p>
              <small class="lead-muted">QS. Adh-Dhariyat: 49</small>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="lux-card p-4 h-100 text-center">
              <p class="mb-2" style="font-size:.98rem;">Dan sesungguhnya Dialah yang menciptakan pasangan laki-laki dan perempuan</p>
              <small class="lead-muted">QS. An-Najm: 45</small>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="lux-divider"></div>

    <!-- ====== MOMENT BAHAGIA (3 info cards equal-height) ====== -->
    <section id="wedding-date" class="animate-section" data-animation="slide-in-left">
      <div class="container py-5">
        <div class="text-center mb-3">
          <h3 class="font-esthetic mb-2" style="font-size:2rem;">Moment Bahagia</h3>
          <p class="lead-muted mb-0" style="font-size:.95rem;">Dengan memohon rahmat dan ridho Allah Subhanahu Wa Ta'ala, insyaAllah kami akan menyelenggarakan acara resepsi:</p>
        </div>

        <div class="row g-3 justify-content-center">
          <div class="col-12 col-md-4">
            <div class="lux-card p-4 h-100 text-center">
              <i class="fa-solid fa-calendar-days mb-2"></i>
              <div class="small">{{ \Carbon\Carbon::parse($wedding_date)->locale('id')->translatedFormat('j F Y') }}</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="lux-card p-4 h-100 text-center">
              <i class="fa-solid fa-clock mb-2"></i>
              <div class="small">{{ \Carbon\Carbon::parse($wedding_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($wedding_time_end)->format('H:i') }}</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="lux-card p-4 h-100 text-center">
              <i class="fa-solid fa-location-dot mb-2"></i>
              <div class="small">{{ $wedding_venue }}</div>
            </div>
          </div>
        </div>

        <div class="text-center mt-3">
          @if (!empty($wedding_maps))
            <a href="{{ $wedding_maps }}" target="_blank" class="btn btn-outline-dark btn-sm lux-btn px-3">
              <i class="fa-solid fa-map-location-dot me-2"></i>Lihat Google Maps
            </a>
          @endif
          <small class="d-block mt-2 lead-muted">{{ $wedding_location ?? 'Nama jalan lengkap hingga provinsi' }}</small>
        </div>
      </div>
    </section>

    <div class="lux-divider"></div>

    <!-- ====== RSVP (fokus action di tengah, status & edit di bawah) ====== -->
    <section id="rvsp" class="animate-section" data-animation="zoom-in">
      <div class="container py-5" style="max-width:760px;">
        <div class="text-center mb-3">
          <h3 class="font-esthetic mb-2" style="font-size:1.8rem;">Konfirmasi Kehadiran</h3>
          <p class="mb-0 lead-muted" style="font-size:.95rem;">Mohon konfirmasi kehadiran Anda pada acara pernikahan kami:</p>
        </div>

        @php
          $weddingDate = \Carbon\Carbon::parse($wedding_date);
          $today = \Carbon\Carbon::now();
          $daysUntilWedding = $today->diffInDays($weddingDate, false);
          $isDeadlinePassed = $daysUntilWedding < 3;
          $deadlineDate = $weddingDate->copy()->subDays(3);
          $deadlineDateFormatted = $deadlineDate->locale('id')->translatedFormat('l, j F Y \\p\\u\\k\\u\\l H:i');
        @endphp

        @if($isDeadlinePassed)
          <div class="d-flex flex-column align-items-center">
            <div class="alert alert-warning rounded-pill px-4">Konfirmasi RVSP ditutup 3 hari sebelum acara.</div>
            @if(($guest->guest_attendance_status ?? '-') !== '-')
              <div class="mt-2">
                @if (($guest->guest_attendance_status ?? '-') === 'Yes')
                  <button class="btn btn-success btn-sm lux-btn px-3" disabled>Status RVSP: Hadir</button>
                @elseif(($guest->guest_attendance_status ?? '-') === 'No')
                  <button class="btn btn-danger btn-sm lux-btn px-3" disabled>Status RVSP: Tidak Hadir</button>
                @endif
              </div>
            @endif
          </div>
        @else
          <div class="text-center">
            <div id="rvsp-buttons" class="d-inline-flex justify-content-center flex-wrap gap-2 {{ ($guest->guest_attendance_status ?? '-') !== '-' ? 'd-none' : '' }}">
              <button class="btn btn-sm btn-outline-danger lux-btn px-4" type="button" onclick="confirmAttendance('No')">
                <i class="fa-solid fa-xmark me-2"></i>Tidak Hadir
              </button>
              <button class="btn btn-sm btn-outline-primary lux-btn px-4" type="button" onclick="confirmAttendance('Yes')">
                <i class="fa-solid fa-check me-2"></i>Hadir
              </button>
            </div>

            <div id="rvsp-status" class="mt-3 {{ ($guest->guest_attendance_status ?? '-') !== '-' ? '' : 'd-none' }}">
              <div class="my-2">
                <h4 class="mb-2" id="rvsp-status-title">
                  @if (($guest->guest_attendance_status ?? '-') === 'Yes')
                    <button class="btn btn-success btn-sm lux-btn px-3" disabled>Status RVSP: Hadir</button>
                  @elseif(($guest->guest_attendance_status ?? '-') === 'No')
                    <button class="btn btn-danger btn-sm lux-btn px-3" disabled>Status RVSP: Tidak Hadir</button>
                  @endif
                </h4>
                <p class="mb-3" id="rvsp-status-message">
                  @if (($guest->guest_attendance_status ?? '-') === 'Yes')
                    Terima kasih sudah konfirmasi!<br>Kami sangat senang bisa merayakan hari istimewa kami bersama Anda.
                  @elseif(($guest->guest_attendance_status ?? '-') === 'No')
                    Kami akan merindukan Anda!<br>Terima kasih sudah memberitahu kami.
                  @endif
                </p>
              </div>
              <button class="btn btn-outline-warning btn-sm lux-btn px-3" type="button" onclick="editRVSP()">
                <i class="fa-solid fa-pen-to-square me-2"></i>Ubah Konfirmasi
              </button>
            </div>

            <div id="rvsp-edit" class="d-none mt-3">
              <div class="d-flex justify-content-center gap-2 flex-wrap">
                <button class="btn btn-outline-danger btn-sm lux-btn px-3" type="button" onclick="confirmAttendance('No')">
                  <i class="fa-solid fa-xmark me-2"></i>Tidak Hadir
                </button>
                <button class="btn btn-outline-primary btn-sm lux-btn px-3" type="button" onclick="confirmAttendance('Yes')">
                  <i class="fa-solid fa-check me-2"></i>Hadir
                </button>
                <button class="btn btn-outline-secondary btn-sm lux-btn px-3" type="button" onclick="cancelEdit()">
                  <i class="fa-solid fa-times me-2"></i>Batal
                </button>
              </div>
            </div>

            <div class="mt-3">
              <small class="lead-muted">
                <i class="fa-solid fa-info-circle me-1"></i>
                Konfirmasi kehadiran ditutup pada {{ $deadlineDateFormatted }} WIB
              </small>
            </div>
          </div>
        @endif
      </div>
    </section>

    <!-- ====== QR (muncul kalau hadir) ====== -->
    <section id="qr-code" class="animate-section {{ ($guest->guest_attendance_status ?? '-') === 'Yes' ? '' : 'd-none' }}" data-animation="fade-in">
      <div class="container py-5" style="max-width:720px;">
        <div class="text-center mb-3">
          <h3 class="font-esthetic mb-2" style="font-size:1.8rem;">Kode QR Pribadi</h3>
          <p class="lead-muted mb-0" style="font-size:.95rem;">Silakan tunjukkan kode QR ini di pintu masuk.</p>
        </div>

        <div class="d-flex justify-content-center">
          <div class="lux-card p-4">
            @if (!empty($guest) && $guest->guest_id_qr_code)
              <img src="{{ asset($guest->guest_qr_code) }}" alt="QR Code Tamu" class="img-fluid text-center"
                   style="max-width:220px; cursor:pointer"
                   id="qr-code-img" data-bs-toggle="modal" data-bs-target="#qrCodeModal">
            @else
              <div class="d-flex justify-content-center align-items-center bg-light rounded" style="width:220px; height:220px;">
                <i class="fa-solid fa-qrcode fa-3x text-secondary"></i>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <div class="lux-divider"></div>

    <!-- ====== GIFT (singkat & center) ====== -->
    <section id="gift" class="animate-section" data-animation="slide-in-right">
      <div class="container py-5" style="max-width:720px;">
        <div class="text-center">
          <h3 class="font-esthetic mb-2" style="font-size:1.8rem;">Gift</h3>
          <p class="lead-muted mb-2" style="font-size:.95rem;">Kehadiran dan doa restu Anda adalah hadiah terindah.</p>
          <p class="lead-muted">Jika berkenan memberi hadiah digital, klik tombol di bawah.</p>
          <button class="btn btn-outline-primary btn-sm lux-btn px-4" type="button" onclick="openPaymentModal()">
            <i class="fa-solid fa-gift me-2"></i>Beri Hadiah Digital
          </button>
        </div>
      </div>
    </section>

    <div class="lux-divider"></div>

    <!-- ====== COMMENT (layout: form kiri, list kanan di desktop) ====== -->
    <section id="comment" class="animate-section" data-animation="fade-in-up">
      <div class="container py-5">
        <div class="text-center mb-4">
          <h3 class="font-esthetic mb-2" style="font-size:1.9rem;">Ucapan &amp; Doa</h3>
        </div>

        <div class="row g-4">
          <!-- Form / current user wish -->
          <div class="col-12 col-lg-5">
            <div class="lux-card p-3 p-md-4 mb-4" id="wish-form-container">
              <div class="mb-3">
                <label class="form-label mb-2"><i class="fa-solid fa-user me-2"></i>Nama</label>
                <div class="lux-card p-2">
                  <span class="fw-medium">{{ $guest->guest_name ?? 'Nama Tamu Undangan' }}</span>
                </div>
              </div>

              <div class="d-none mb-3" id="user-wish-display">
                <div class="alert alert-info rounded-3">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="pe-2">
                      <h6 class="mb-1">Ucapan Anda:</h6>
                      <p class="mb-1" id="user-wish-text"></p>
                      <small class="text-muted" id="user-wish-date"></small>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" onclick="editWish()">
                      <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                  </div>
                </div>
              </div>

              <div class="mb-3" id="wish-form">
                <label for="wish-message" class="form-label mb-2">
                  <i class="fa-solid fa-comment me-2"></i>Ucapan &amp; Doa
                </label>
                <div class="position-relative">
                  <textarea class="form-control shadow-sm" id="wish-message" rows="5" minlength="1" maxlength="500"
                            placeholder="Tulis ucapan dan doa Anda..." autocomplete="off"></textarea>
                  <div class="text-end mt-1">
                    <small class="text-muted"><span id="char-count">0</span>/500 karakter</small>
                  </div>
                </div>
              </div>

              <div class="d-grid">
                <button class="btn btn-primary py-2 lux-btn" id="submit-wish-btn" onclick="submitWish()">
                  <i class="fa-solid fa-paper-plane me-2"></i><span id="submit-wish-text">Kirim Ucapan</span>
                </button>
              </div>
            </div>
          </div>

          <!-- List wishes -->
          <div class="col-12 col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h5 class="m-0">
                <i class="fa-solid fa-comments me-2"></i>Ucapan dari Tamu (<span id="wishes-count">0</span>)
              </h5>
            </div>

            <div id="wishes-container">
              <div class="text-center py-4" id="wishes-loading">
                <i class="fa-solid fa-spinner fa-spin fa-2x text-muted"></i>
                <p class="mt-2 text-muted">Memuat ucapan...</p>
              </div>
            </div>

            <div class="text-center mt-3 d-none" id="load-more-container">
              <button class="btn btn-outline-primary btn-sm lux-btn px-4" id="load-more-btn" onclick="loadMoreWishes()">
                <i class="fa-solid fa-plus me-2"></i>Muat Lebih Banyak
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="lux-divider"></div>

    <!-- ====== FOOTER ====== -->
    <section class="py-4 animate-section" data-animation="fade-in">
      <div class="container">
        <div class="text-center">
          <p class="mb-3 lead-muted" style="font-size:.95rem;">Terima kasih atas perhatian dan doa restu Anda.</p>
          <h2 class="font-esthetic" style="font-size:1.6rem;">Wassalamualaikum Warahmatullahi Wabarakatuh</h2>
          <h3 class="font-arabic mt-3" style="font-size:1.4rem;">اَلْحَمْدُ لِلّٰهِ رَبِّ الْعٰلَمِيْنَۙ</h3>

          <div class="mt-4">
            <p class="font-esthetic mb-0" style="font-size:1.4rem;">{{ $groom_alias }} &amp; {{ $bride_alias }}</p>
            <small class="lead-muted">{{ $groom_name }} &amp; {{ $bride_name }}</small>
          </div>

          <hr class="my-3">
          <small class="lead-muted">Build with <i class="fa-solid fa-heart mx-1 text-danger"></i> QREW</small>
        </div>
      </div>
    </section>
  </div><!-- /#invitation-content -->

  <!-- ====== Payment Modal (tetap) ====== -->
  <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header bg-dark text-white rounded-top-4">
          <h5 class="modal-title font-esthetic" id="paymentModalLabel"><i class="fa-solid fa-gift me-2"></i>Hadiah Digital</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div id="payment-content">
            <p class="text-muted mb-3">Pilih nominal hadiah untuk {{ $groom_name }} & {{ $bride_name }}</p>
            <div class="mb-3">
              <label for="customAmount" class="form-label">Masukkan nominal</label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control" id="customAmount" placeholder="Masukkan Nominal" min="1000">
              </div>
            </div>
            <button type="button" class="btn btn-primary w-100 lux-btn" onclick="processPayment()">
              <i class="fa-solid fa-credit-card me-2"></i>Lanjutkan Pembayaran
            </button>
          </div>
          <div id="payment-status" class="text-center" style="display:none;">
            <div id="status-message"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ====== Bottom Navbar (ID sama untuk scrollspy script) ====== -->
  <nav class="navbar navbar-expand rounded-top-4 p-0 bg-white" id="navbar-menu-wrapper">
    <div id="navbar-menu-inner" class="w-100">
      <ul class="navbar-nav nav-justified w-100 align-items-center" id="navbar-menu">
        <li class="nav-item">
          <a class="nav-link" href="#home"><i class="fa-solid fa-house"></i><span class="d-block" style="font-size:.72rem;">Home</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#couple"><i class="fa-solid fa-heart"></i><span class="d-block" style="font-size:.72rem;">Mempelai</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#wedding-date"><i class="fa-solid fa-calendar-check"></i><span class="d-block" style="font-size:.72rem;">Tanggal</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#gift"><i class="fa-solid fa-gift"></i><span class="d-block" style="font-size:.72rem;">Gift</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#comment"><i class="fa-solid fa-comments"></i><span class="d-block" style="font-size:.72rem;">Ucapan</span></a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- ====== QR Modal (tetap) ====== -->
  <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header">
          <h5 class="modal-title font-esthetic" id="qrCodeModalLabel"><i class="fa-solid fa-qrcode me-2"></i>Kode QR Tamu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          @if (!empty($guest) && $guest->guest_id_qr_code)
            <img src="{{ asset($guest->guest_qr_code) }}" alt="QR Code Besar" class="img-fluid mb-3" style="max-width:350px;">
            <div><small class="text-secondary">ID: {{ $guest->guest_id_qr_code }}</small></div>
          @else
            <div class="d-flex justify-content-center align-items-center bg-light rounded" style="width:250px; height:250px; margin:0 auto;">
              <i class="fa-solid fa-qrcode fa-4x text-secondary"></i>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</body>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
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
                            modal.classList.add('hidden');
                            modal.style.display = 'none'; // Extra fallback
                            document.body.classList.remove('modal-open');
                            invitationContent.classList.add('show');

                            // Reset scroll to top and initialize navbar
                            window.scrollTo(0, 0);
                            setTimeout(() => {
                                initializeNavbar();
                            }, 100);

                            // Show music control and auto-play music after modal is closed
                            setTimeout(() => {
                                const musicControl = document.getElementById(
                                    'music-control');
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
            const sections = [{
                    id: "home",
                    nav: 0
                },
                {
                    id: "couple",
                    nav: 1
                },
                {
                    id: "wedding-date",
                    nav: 2
                },
                {
                    id: "gift",
                    nav: 3
                },
                {
                    id: "comment",
                    nav: 4
                }
            ];
            const navLinks = document.querySelectorAll("#navbar-menu .nav-link");

            // Initialize navbar with Home as active
            function initializeNavbar() {
                console.log('Initializing navbar - setting Home as active');
                navLinks.forEach((link, idx) => {
                    if (idx === 0) { // Home is index 0
                        link.classList.add("active");
                        console.log('Set active:', link.href);
                    } else {
                        link.classList.remove("active");
                    }
                });
            }

            function onScroll() {
                let scrollPos = window.scrollY || window.pageYOffset;
                let offset = window.innerWidth <= 991.98 ? 120 :
                    80; // Higher offset for mobile due to bottom navbar
                let activeIdx = 0;
                console.log('OnScroll - scrollPos:', scrollPos, 'offset:', offset);

                for (let i = 0; i < sections.length; i++) {
                    const sec = document.getElementById(sections[i].id);
                    if (sec && sec.offsetTop - offset <= scrollPos) {
                        activeIdx = i;
                        console.log('Active section:', sections[i].id, 'offsetTop:', sec.offsetTop);
                    }
                }

                console.log('Setting active index:', activeIdx, 'section:', sections[activeIdx]?.id);

                navLinks.forEach((link, idx) => {
                    if (idx === activeIdx) {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }
                });
            }

            // Initialize navbar first
            initializeNavbar();

            window.addEventListener("scroll", onScroll);

            // Run onScroll after a short delay to ensure content is ready
            setTimeout(() => {
                if (document.body.classList.contains('modal-open')) {
                    // If modal is still open, don't run scrollspy yet
                    return;
                }
                onScroll();
            }, 1000);

            // Smooth scroll for navbar links
            navLinks.forEach(link => {
                link.addEventListener("click", function(e) {
                    const href = this.getAttribute("href");
                    console.log('Navbar clicked:', href); // Debug log
                    if (href && href.startsWith("#")) {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        console.log('Target element:', target); // Debug log
                        if (target) {
                            const offset = window.innerWidth <= 991.98 ? 100 :
                                70; // Higher offset for mobile
                            const y = target.getBoundingClientRect().top + window.pageYOffset -
                                offset;
                            console.log('Scrolling to:', y); // Debug log
                            window.scrollTo({
                                top: y,
                                behavior: "smooth"
                            });
                        }
                    }
                });
            });
        });

        // RVSP Functions
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
                        // Hide all RVSP sections first
                        document.getElementById('rvsp-buttons').classList.add('d-none');
                        document.getElementById('rvsp-edit').classList.add('d-none');

                        // Show status section
                        document.getElementById('rvsp-status').classList.remove('d-none');

                        if (status === 'Yes') {
                            // Attending
                            document.getElementById('rvsp-status-title').innerHTML =
                                '<button class="btn btn-success btn-sm px-3 rounded-pill" disabled>Status RVSP: Hadir</button>';
                            document.getElementById('rvsp-status-message').innerHTML =
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
                            document.getElementById('rvsp-status-title').innerHTML =
                                '<button class="btn btn-danger btn-sm px-3 rounded-pill" disabled>Status RVSP: Tidak Hadir</button>';
                            document.getElementById('rvsp-status-message').innerHTML =
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
                        // Check if it's a deadline error
                        if (data.deadline_reached) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Konfirmasi RVSP Ditutup',
                                text: data.message || 'Konfirmasi RVSP sudah ditutup.',
                                confirmButtonColor: '#ffc107'
                            }).then(() => {
                                // Reload page to show deadline message
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: data.message || 'Gagal menyimpan konfirmasi kehadiran.',
                                confirmButtonColor: '#dc3545'
                            });
                        }
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

        function editRVSP() {
            // Hide status section and show edit options
            document.getElementById('rvsp-status').classList.add('d-none');
            document.getElementById('rvsp-edit').classList.remove('d-none');
        }

        function cancelEdit() {
            // Hide edit options and show status section
            document.getElementById('rvsp-edit').classList.add('d-none');
            document.getElementById('rvsp-status').classList.remove('d-none');
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
                    submitBtn.innerHTML =
                        '<i class="fa-solid fa-paper-plane me-2"></i><span id="submit-wish-text">Perbarui Ucapan</span>';
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
                    body: JSON.stringify({
                        message: message
                    })
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
                            text: userHasWish ? 'Ucapan Anda berhasil diperbarui.' :
                                'Terima kasih atas ucapan dan doa Anda!',
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
                    body: JSON.stringify({
                        amount: amount
                    })
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
            }, {
                threshold: 0.2
            });

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

        // Kalender
        document.addEventListener('DOMContentLoaded', function() {
            const calendarBtn = document.getElementById('save-to-calendar');
            if (calendarBtn) {
                calendarBtn.addEventListener('click', function() {
                    // Ambil data dari blade
                    const date = '{{ $wedding_date }}';
                    const timeStart = '{{ $wedding_time_start }}';
                    const timeEnd = '{{ $wedding_time_end }}';

                    // Validasi data
                    if (!date || !timeStart || !timeEnd) {
                        alert('Tanggal atau waktu acara tidak valid.');
                        return;
                    }

                    // Format: YYYYMMDDTHHmmssZ
                    function formatDate(date, time) {
                        // Pastikan time formatnya HH:mm
                        const [hour, minute] = time.split(':');
                        if (!hour || !minute) return '';
                        // Buat objek Date UTC manual (agar tidak error timezone)
                        const d = new Date(Date.UTC(
                            ...date.split('-').map(Number), // [YYYY, MM, DD]
                            hour, minute, 0
                        ));
                        // Koreksi bulan (karena bulan di JS dimulai dari 0)
                        d.setUTCMonth(d.getUTCMonth() - 1);
                        return d.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
                    }

                    const start = formatDate(date, timeStart);
                    const end = formatDate(date, timeEnd);

                    if (!start || !end) {
                        alert('Format waktu tidak valid.');
                        return;
                    }

                    const title = 'Undangan Pernikahan {{ $groom_name }} & {{ $bride_name }}';
                    const details =
                        `Tanpa mengurangi rasa hormat, kami mengundang Anda untuk berkenan menghadiri acara pernikahan kami.\n\nTerima kasih atas perhatian dan doa restu Anda, yang menjadi kebahagiaan serta kehormatan besar bagi kami.`;
                    const location = '{{ $wedding_venue }}, {{ $wedding_location ?? '' }}';
                    const url = new URL('https://calendar.google.com/calendar/render');
                    url.search = new URLSearchParams({
                        action: 'TEMPLATE',
                        text: title,
                        dates: `${start}/${end}`,
                        details: details,
                        location: location,
                        ctz: 'Asia/Jakarta'
                    }).toString();
                    window.open(url, '_blank');
                });
            }
        });
    </script>

</html>

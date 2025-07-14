@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Dashboard of Quick Response Elegant Wedding (QREW)</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">

                @forelse($invitations as $invitation)
                    <div class="card card-outline card-secondary mb-4">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0 d-inline">
                                    <i class="fas fa-heart text-danger"></i>
                                    <strong>{{ $invitation['name'] }}</strong>
                                </h5>
                            </div>
                            <div class="ms-auto mt-2 mt-md-0">
                                <a href="{{ url('/invitation/' . $invitation['id'] . '/show') }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-external-link-alt"></i> Details
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Informasi Pasangan -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-5 col-md-5 col-12 mb-2 mb-md-0">
                                    <div
                                        class="info-box bg-gradient-primary d-flex align-items-center justify-content-center h-100">
                                        <div class="info-box-content text-center">
                                            <h1 class="info-box-number text text-white fs-4 fw-bold">
                                                {{ $invitation['groom_name'] }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                    <div class="text-center">
                                        <i class="fas fa-heart text-danger fa-5x"></i>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-12">
                                    <div
                                        class="info-box bg-gradient-danger d-flex align-items-center justify-content-center h-100">
                                        <div class="info-box-content text-center">
                                            <h1 class="info-box-number text-white fs-4 fw-bold">
                                                {{ $invitation['bride_name'] }}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Acara -->
                            <div class="row mb-4">
                                <div class="col-lg-6 col-md-6 col-12 mb-2 mb-md-0">
                                    <div class="info-box bg-gradient-info h-100">
                                        <span class="info-box-icon">
                                            <i class="fas fa-calendar-alt fa-lg"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <h5 class="info-box-number text-white">
                                                {{ date('d M Y', strtotime($invitation['wedding_date'])) }}</h5>
                                            <h5 class="progress-description text-white">
                                                {{ \Carbon\Carbon::parse($invitation['wedding_time_start'] ?? '00:00')->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($invitation['wedding_time_end'] ?? '00:00')->format('H:i') }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="info-box bg-gradient-success h-100">
                                        <span class="info-box-icon">
                                            <i class="fas fa-map-marker-alt fa-lg"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <h5 class="info-box-number text-white fs-6">{{ $invitation['wedding_venue'] }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Summaries -->
                            <div class="row mb-4">
                                <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                    <div class="info-box bg-light h-100">
                                        <span class="info-box-icon bg-primary">
                                            <i class="fas fa-users"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Guests</span>
                                            <span class="info-box-number">{{ $invitation['total_guests'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                    <div class="info-box bg-light h-100">
                                        <span class="info-box-icon bg-purple">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Confirmed Attendance</span>
                                            <span
                                                class="info-box-number">{{ $invitation['confirmed_attendance'] }}/{{ $invitation['total_guests'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                    <div class="info-box bg-light h-100">
                                        <span class="info-box-icon bg-info">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Checked In</span>
                                            <span
                                                class="info-box-number">{{ $invitation['checked_in'] }}/{{ $invitation['total_guests'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box bg-light h-100">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-gift"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Gifts</span>
                                            <span class="info-box-number">Rp
                                                {{ number_format($invitation['total_gift_amount'], 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="card card-outline card-warning">
                        <div class="card-body text-center">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5>Belum Ada Undangan</h5>
                            <p class="text-muted">Silakan buat undangan pertama untuk melihat dashboard.</p>
                            <a href="{{ url('/invitation') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Undangan
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <style>
        @media (max-width: 767.98px) {
            .info-box .info-box-icon {
                min-width: 40px !important;
                font-size: 1.5rem !important;
            }
            .info-box-content h1,
            .info-box-content h5 {
                font-size: 1.1rem !important;
            }
            .info-box-content .info-box-number {
                font-size: 1rem !important;
            }
        }
        @media (max-width: 575.98px) {
            .card-header.d-flex {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .ms-auto {
                margin-left: 0 !important;
                margin-top: 10px !important;
            }
        }
    </style>
@endsection

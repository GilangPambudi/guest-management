@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/scanner') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <a href="{{ url('/invitation/' . $invitation->invitation_id . '/guests') }}" class="btn btn-info">
                    <i class="fa fa-users"></i> Manage Guests
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Wedding Info -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row">
                        <!-- Card 1: Nama Pengantin -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm"
                                style="background: linear-gradient(135deg, #f8fafc 60%, #f3e8ff 100%); border: none;">
                                <div
                                    class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <h5 class="mb-1 font-weight-bold text-primary" style="font-size: 1.2rem;">
                                        {{ $invitation->groom_name }}
                                    </h5>
                                    <h5 class="mb-1 font-weight-bold" style="font-size: 1.2rem; color: #e75480;">
                                        <i class="fa fa-heart mx-1"></i>
                                    </h5>
                                    <h5 class="mb-1 font-weight-bold text-pink" style="font-size: 1.2rem; color: #d63384;">
                                        {{ $invitation->bride_name }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2: Tanggal -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm"
                                style="background: linear-gradient(135deg, #f8fafc 60%, #ffe5ec 100%); border: none;">
                                <div
                                    class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa fa-calendar fa-2x mb-2" style="color: #a370f7;"></i>
                                    <div class="font-weight-bold text-secondary">Tanggal</div>
                                    <div class="text-dark">
                                        {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3: Waktu -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm"
                                style="background: linear-gradient(135deg, #f8fafc 60%, #e0f7fa 100%); border: none;">
                                <div
                                    class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa fa-clock fa-2x mb-2" style="color: #00bcd4;"></i>
                                    <div class="font-weight-bold text-secondary">Waktu</div>
                                    <div class="text-dark">
                                        {{ \Carbon\Carbon::parse($invitation->wedding_time_start)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($invitation->wedding_time_end)->format('H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 4: Tempat -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm"
                                style="background: linear-gradient(135deg, #f8fafc 60%, #fff3cd 100%); border: none;">
                                <div
                                    class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa fa-map-marker-alt fa-2x mb-2" style="color: #ffc107;"></i>
                                    <div class="font-weight-bold text-secondary">Tempat</div>
                                    <div class="text-dark">
                                        {{ $invitation->wedding_venue }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Manual Scanner (Left Column) -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title">Guest Scanner</h5>
                        </div>
                        <div class="card-body">
                            <form id="scanForm">
                                <div class="form-group">
                                    <label for="manualScanInput">Guest QR Code ID</label>
                                    <input type="text" id="manualScanInput" class="form-control form-control-lg"
                                        placeholder="Scan or type guest QR code here" autofocus>
                                    <small class="form-text text-muted">
                                        Use your barcode scanner or type the guest ID manually. Press Enter to check in.
                                    </small>
                                </div>
                                <button type="button" class="btn btn-success btn-lg btn-block"
                                    onclick="handleManualScan()">
                                    <i class="fas fa-check-in"></i> Check In Guest
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Info Panel (Right Column) -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title">Instructions</h5>
                        </div>
                        <div class="card-body d-flex">
                            <ul class="mb-0">
                                <li>Scan the guest's QR code using the scanner, or type the guest ID manually.</li>
                                <li>Press <strong>Enter</strong> or click <strong>Check In Guest</strong> to process
                                    check-in.</li>
                                <li>Successful check-ins will appear in the history below.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Check-ins -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title">Recent Check-ins</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <button class="btn btn-outline-primary btn-sm" onclick="$('#recentCheckinsTable').DataTable().ajax.reload(null, false)">
                                    <i class="fa fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm" id="recentCheckinsTable">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Guest Name</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables will populate -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const invitationId = {{ $invitation->invitation_id }};

        // Toastr config (copy dari guests/index)
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Handle manual scan
        function handleManualScan() {
            const input = document.getElementById('manualScanInput').value.trim();
            if (input) {
                processGuestCheckin(input);
                document.getElementById('manualScanInput').value = '';
            } else {
                toastr.warning('Please enter a guest QR code');
            }
            // Always keep focus on input
            setTimeout(() => {
                document.getElementById('manualScanInput').focus();
            }, 100);
        }

        // Process guest check-in - Fast and simple
        function processGuestCheckin(guestIdQrCode) {
            // Make request to welcome gate immediately
            fetch(`/invitation/${invitationId}/welcome-gate/${guestIdQrCode}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show quick success toast
                    if (data.already_checked_in) {
                        toastr.info(`${data.guest_name} - Already checked in`);
                    } else {
                        toastr.success(`${data.guest_name} - Check-in successful!`);
                    }
                    // Refresh recent check-ins
                    $('#recentCheckinsTable').DataTable().ajax.reload(null, false);
                } else {
                    toastr.error('Guest not found');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Check-in failed, please enter valid guest ID');
            })
            .finally(() => {
                // Always keep focus on input
                setTimeout(() => {
                    document.getElementById('manualScanInput').focus();
                }, 100);
            });
        }

        // Load recent check-ins
        $(document).ready(function() {


            // Inisialisasi DataTable
            $('#recentCheckinsTable').DataTable({
                ajax: {
                    url: '/invitation/{{ $invitation->invitation_id }}/recent-checkins',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'guest_arrival_time', defaultContent: '-' },
                    { data: 'guest_name', defaultContent: '-' },
                    { data: 'guest_category', defaultContent: '-' }
                ],
                paging: false,
                searching: false,
                info: false,
                order: [[0, 'desc']],
                language: {
                    emptyTable: "No check-ins today"
                }
            });

            // Optional: auto-refresh setiap 15 detik
            setInterval(function() {
                $('#recentCheckinsTable').DataTable().ajax.reload(null, false);
            }, 120000);

            // Tambah: tombol refresh manual dengan toastr
            $(document).on('click', '.btn-outline-primary.btn-sm', function() {
                $('#recentCheckinsTable').DataTable().ajax.reload(null, false);
                toastr.success('Recent check-ins refreshed!');
            });
        });

        // Function to maintain focus on input
        function maintainFocus() {
            const input = document.getElementById('manualScanInput');
            if (document.activeElement !== input) {
                input.focus();
            }
        }

        // Handle Enter key in manual input
        document.getElementById('manualScanInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleManualScan();
            }
        });

        // Prevent losing focus when clicking outside
        document.addEventListener('click', function(e) {
            const input = document.getElementById('manualScanInput');
            const scanForm = document.getElementById('scanForm');

            // If click is not on the input or scan form, refocus input
            if (!scanForm.contains(e.target)) {
                setTimeout(() => {
                    input.focus();
                }, 10);
            }
        });

        // Prevent losing focus when pressing other keys
        document.addEventListener('keydown', function(e) {
            const input = document.getElementById('manualScanInput');

            // If not focused on input, focus it (except for special keys)
            if (document.activeElement !== input &&
                !['Tab', 'F5', 'F12', 'Alt', 'Control', 'Shift'].includes(e.key) &&
                !e.altKey && !e.ctrlKey) {
                input.focus();
            }
        });

        // Load recent check-ins on page load
        document.addEventListener('DOMContentLoaded', function() {

            // Show welcome toastr
            toastr.success('Scanner Ready!');

            // Ensure input is focused on page load
            setTimeout(() => {
                document.getElementById('manualScanInput').focus();
            }, 100);

            // Maintain focus every 2 seconds (as backup)
            setInterval(maintainFocus, 2000);
        });

        // Handle when page regains focus (user comes back to tab)
        window.addEventListener('focus', function() {
            setTimeout(() => {
                document.getElementById('manualScanInput').focus();
            }, 100);
        });

        // Handle visibility change (when tab becomes visible again)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                setTimeout(() => {
                    document.getElementById('manualScanInput').focus();
                }, 100);
            }
        });
    </script>
@endsection

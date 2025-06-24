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
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Wedding Information</h5>
                        <strong>{{ $invitation->wedding_name }}</strong><br>
                        {{ $invitation->groom_name }} & {{ $invitation->bride_name }}<br>
                        {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d F Y') }} at
                        {{ $invitation->wedding_venue }}
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
                        <div class="card-header">
                            <h5 class="card-title">History</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Guest Name</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentCheckins">
                                        <!-- Will be populated via AJAX -->
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

        // Configure SweetAlert Toast - Simple and stable
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: false,
            showClass: {
            popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
        });

        // Handle manual scan
        function handleManualScan() {
            const input = document.getElementById('manualScanInput').value.trim();
            if (input) {
                processGuestCheckin(input);
                document.getElementById('manualScanInput').value = '';
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'Please enter a guest QR code'
                });
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
                            Toast.fire({
                                icon: 'info',
                                title: `${data.guest_name} - Already checked in`

                            });
                        } else {
                            Toast.fire({
                                icon: 'success',
                                title: `${data.guest_name} - Check-in successful!`
                            });
                        }

                        // Refresh recent check-ins
                        loadRecentCheckins();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Guest not found',
                            timer: 3000
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Check-in failed, please enter valid guest ID',
                        timer: 3000
                    });
                })
                .finally(() => {
                    // Always keep focus on input
                    setTimeout(() => {
                        document.getElementById('manualScanInput').focus();
                    }, 100);
                });
        }

        // Load recent check-ins
        function loadRecentCheckins() {
            fetch(`/invitation/${invitationId}/recent-checkins`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('recentCheckins');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        tbody.innerHTML =
                            '<tr><td colspan="3" class="text-center text-muted">No check-ins today</td></tr>';
                        return;
                    }

                    data.forEach(guest => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${new Date(guest.guest_arrival_time).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</td>
                            <td>${guest.guest_name}</td>
                            <td>${guest.guest_category || '-'}</td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error loading recent check-ins:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to load recent check-ins'
                    });
                });
        }

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
            // Show welcome toast
            Toast.fire({
                icon: 'success',
                title: 'Scanner Ready!'
            });

            // Ensure input is focused on page load
            setTimeout(() => {
                document.getElementById('manualScanInput').focus();
            }, 100);

            loadRecentCheckins();

            // Auto-refresh recent check-ins every 15 seconds
            setInterval(loadRecentCheckins, 15000);

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
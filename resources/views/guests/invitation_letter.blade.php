<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Invitation - {{ $groomName }} & {{ $brideName }}</title>
    {{-- Add SweetAlert2 and jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .invitation-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
        }

        .invitation-header {
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
            padding: 60px 40px;
            text-align: center;
            color: white;
            position: relative;
        }

        .invitation-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="hearts" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><text x="10" y="15" text-anchor="middle" fill="rgba(255,255,255,0.1)" font-size="12">♥</text></pattern></defs><rect width="100" height="100" fill="url(%23hearts)"/></svg>');
            opacity: 0.3;
        }

        .invitation-title {
            font-family: 'Dancing Script', cursive;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .couple-names {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin: 20px 0;
            position: relative;
            z-index: 1;
        }

        .ampersand {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            margin: 0 15px;
        }

        .invitation-body {
            padding: 50px 40px;
        }

        .guest-info {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background: linear-gradient(45deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 15px;
            border-left: 5px solid #f093fb;
        }

        .guest-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .guest-category {
            display: inline-block;
            background: #f093fb;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .wedding-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }

        .detail-card {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            border-top: 4px solid #f093fb;
            transition: transform 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
        }

        .detail-icon {
            font-size: 2rem;
            color: #f093fb;
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #34495e;
            font-weight: 500;
        }

        .wedding-image {
            text-align: center;
            margin: 40px 0;
        }

        .wedding-image img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Attendance Section Styles */
        .attendance-section {
            margin: 40px 0;
            text-align: center;
        }

        .attendance-card {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }

        .attendance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="rsvp-pattern" x="0" y="0" width="25" height="25" patternUnits="userSpaceOnUse"><text x="12.5" y="18" text-anchor="middle" fill="rgba(255,255,255,0.05)" font-size="14">📋</text></pattern></defs><rect width="100" height="100" fill="url(%23rsvp-pattern)"/></svg>');
            opacity: 0.3;
        }

        .attendance-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .attendance-status {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 15px 0;
            position: relative;
            z-index: 1;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            margin: 0 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .status-yes {
            background: #28a745;
            color: white;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
        }

        .status-no {
            background: #dc3545;
            color: white;
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
        }

        .status-pending {
            background: #6c757d;
            color: white;
            box-shadow: 0 2px 10px rgba(108, 117, 125, 0.3);
        }        .attendance-buttons {
            margin: 20px 0;
            position: relative;
            z-index: 1;
        }

        .attendance-confirmed {
            margin: 20px 0;
            position: relative;
            z-index: 1;
        }

        .confirmed-message {
            text-align: center;
            padding: 20px;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .confirmed-message h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .confirmed-message p {
            font-size: 1rem;
            line-height: 1.5;
        }

        .attendance-btn {
            background: white;
            color: #667eea;
            border: 2px solid white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            margin: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .attendance-btn:hover {
            background: rgba(255,255,255,0.9);
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .attendance-btn.active {
            background: #f093fb;
            border-color: #f093fb;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(240, 147, 251, 0.4);
        }

        .attendance-btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }        .arrival-info {
            margin-top: 15px;
            font-size: 0.9rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.1);
            padding: 10px 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            display: none !important;
        }

        .qr-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(45deg, #a8edea 0%, #fed6e3 100%);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }

        .qr-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="qr-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><rect x="8" y="8" width="4" height="4" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23qr-pattern)"/></svg>');
        }

        .qr-section h3 {
            font-family: 'Playfair Display', serif;
            color: #2c3e50;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .qr-code {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .qr-code:hover {
            transform: scale(1.05);
        }

        .qr-code img {
            max-width: 200px;
            height: auto;
            border-radius: 5px;
        }

        .qr-instructions {
            color: #2c3e50;
            font-size: 0.95rem;
            margin-top: 15px;
            position: relative;
            z-index: 1;
        }

        .qr-id {
            background: #2c3e50;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            margin: 10px 0;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .qr-id:hover {
            background: #34495e;
            transform: scale(1.05);
        }

        .location-section {
            margin: 40px 0;
        }

        .map-button {
            display: inline-block;
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 15px;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

        .map-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            text-decoration: none;
            color: white;
        }

        .footer-message {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            background: linear-gradient(45deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 15px;
            font-style: italic;
            color: #2c3e50;
            position: relative;
            overflow: hidden;
        }

        .footer-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="love-pattern" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse"><text x="15" y="20" text-anchor="middle" fill="rgba(44,62,80,0.05)" font-size="16">💕</text></pattern></defs><rect width="100" height="100" fill="url(%23love-pattern)"/></svg>');
        }

        .footer-message p {
            position: relative;
            z-index: 1;
        }

        .print-section {
            text-align: center;
            margin: 30px 0;
        }

        .print-button {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
        }

        .print-button:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Pulse Animation for Active Status */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(240, 147, 251, 0.7);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(240, 147, 251, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(240, 147, 251, 0);
            }
        }

        /* Responsive Design */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .invitation-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .print-section, .attendance-section {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .invitation-header {
                padding: 40px 20px;
            }
            
            .couple-names {
                font-size: 2.2rem;
            }
            
            .invitation-body {
                padding: 30px 20px;
            }
            
            .wedding-details {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .attendance-btn {
                display: block;
                margin: 10px auto;
                width: 200px;
            }
            
            .qr-code img {
                max-width: 150px;
            }
        }

        @media (max-width: 480px) {
            .invitation-header {
                padding: 30px 15px;
            }
            
            .couple-names {
                font-size: 1.8rem;
            }
            
            .invitation-body {
                padding: 20px 15px;
            }
            
            .attendance-card {
                padding: 20px;
            }
            
            .attendance-btn {
                width: 100%;
                margin: 8px 0;
            }
        }
    </style>
</head>
<body>
    <div class="invitation-container">
        <!-- Header -->
        <div class="invitation-header">
            <div class="invitation-title">You Are Cordially Invited</div>
            <div class="couple-names">
                {{ $groomName }}<span class="ampersand">&</span>{{ $brideName }}
            </div>
        </div>

        <!-- Body -->
        <div class="invitation-body">
            <!-- Guest Information -->
            <div class="guest-info">
                <div class="guest-name">Dear {{ $guest->guest_name }}</div>
                <span class="guest-category">{{ $guest->guest_category }} Guest</span>
            </div>

            <!-- Wedding Details -->
            <div class="wedding-details">
                <div class="detail-card">
                    <div class="detail-icon">📅</div>
                    <div class="detail-label">Date</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($weddingDate)->format('l, F j, Y') }}</div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">🕒</div>
                    <div class="detail-label">Time</div>
                    <div class="detail-value">{{ $weddingTimeStart }} - {{ $weddingTimeEnd }}</div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">🏛️</div>
                    <div class="detail-label">Venue</div>
                    <div class="detail-value">{{ $weddingVenue }}</div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">📍</div>
                    <div class="detail-label">Location</div>
                    <div class="detail-value">{{ $weddingLocation }}</div>
                </div>
            </div>

            <!-- Wedding Image -->
            @if($weddingImage)
            <div class="wedding-image">
                <img src="{{ asset($weddingImage) }}" alt="Wedding Image" loading="lazy">
            </div>
            @endif            <!-- Attendance Section -->
            <div class="attendance-section">
                <div class="attendance-card">
                    <h3>📋 RSVP - Please Confirm Your Attendance</h3>
                      <div class="attendance-status">
                        Current Status: 
                        <span id="current-status" class="status-badge status-{{ strtolower($guest->guest_attendance_status == 'Yes' ? 'yes' : ($guest->guest_attendance_status == 'No' ? 'no' : 'pending')) }} {{ $guest->guest_attendance_status == 'Yes' ? 'pulse' : '' }}">
                            {{ $guest->guest_attendance_status == '-' ? 'Not Confirmed' : $guest->guest_attendance_status }}
                        </span>
                    </div>

                    @if($guest->guest_attendance_status == '-')
                    <div class="attendance-buttons" id="attendance-buttons">
                        <button onclick="updateAttendance('Yes')" 
                                class="attendance-btn" 
                                id="btn-yes">
                            ✅ Yes, I'll Attend
                        </button>
                        <button onclick="updateAttendance('No')" 
                                class="attendance-btn" 
                                id="btn-no">
                            ❌ Sorry, Can't Attend
                        </button>
                    </div>

                    <p style="font-size: 0.9rem; opacity: 0.8; margin-top: 15px;">
                        Your response helps us prepare better for the celebration. Thank you!
                    </p>
                    @else
                    <div class="attendance-confirmed" id="attendance-confirmed">
                        @if($guest->guest_attendance_status == 'Yes')
                            <div class="confirmed-message">
                                <div style="font-size: 3rem; margin-bottom: 15px;">🎉</div>
                                <h4 style="color: white; margin-bottom: 10px;">Thank You for Confirming!</h4>
                                <p style="opacity: 0.9; margin-bottom: 0;">We're excited to celebrate with you on our special day!</p>
                            </div>
                        @else
                            <div class="confirmed-message">
                                <div style="font-size: 3rem; margin-bottom: 15px;">😔</div>
                                <h4 style="color: white; margin-bottom: 10px;">We'll Miss You!</h4>
                                <p style="opacity: 0.9; margin-bottom: 0;">Thank you for letting us know. We understand and hope to celebrate with you another time!</p>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <h3>Your Personal QR Code</h3>
                <div class="qr-code">
                    <img src="{{ asset($guest->guest_qr_code) }}" alt="Guest QR Code" loading="lazy">
                </div>
                <div class="qr-instructions">
                    Please present this QR code at the entrance for quick check-in.<br>
                    <div class="qr-id" onclick="copyQRCode('{{ $guest->guest_id_qr_code }}')" title="Click to copy">
                        {{ $guest->guest_id_qr_code }}
                    </div>
                    <small>Click the ID above to copy</small>
                </div>
            </div>

            <!-- Location/Maps -->
            @if($weddingMaps)
            <div class="location-section detail-card">
                <div class="detail-icon">🗺️</div>
                <div class="detail-label">Get Directions</div>
                <div class="detail-value">Click below to open the location in your maps application</div>
                <a href="{{ $weddingMaps }}" target="_blank" class="map-button">
                    📍 View on Maps
                </a>
            </div>
            @endif

            <!-- Footer Message -->
            <div class="footer-message">
                <p>We joyfully request your presence as we celebrate our union in marriage. Your presence will make our special day even more meaningful.</p>
                <p style="margin-top: 15px;"><strong>With love and gratitude,<br>{{ $groomName }} & {{ $brideName }}</strong></p>
            </div>

            <!-- Print Section -->
            <div class="print-section">
                <button onclick="window.print()" class="print-button">🖨️ Print Invitation</button>
            </div>
        </div>
    </div>

    <script>
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function updateAttendance(status) {
            // Add loading state to clicked button
            const clickedBtn = document.getElementById('btn-' + (status === 'Yes' ? 'yes' : (status === 'No' ? 'no' : 'pending')));
            const originalText = clickedBtn.innerHTML;
            clickedBtn.innerHTML = '<span class="loading-spinner"></span>Updating...';
            clickedBtn.classList.add('loading');

            // Disable all buttons during request
            document.querySelectorAll('.attendance-btn').forEach(btn => {
                btn.disabled = true;
            });

            // Show loading toast
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

            Toast.fire({
                icon: 'info',
                title: 'Updating your attendance status...'
            });            $.ajax({
                url: "{{ url('/update-attendance/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}",
                type: 'POST',
                data: {
                    attendance_status: status
                },
                success: function(response) {                    if (response.success) {
                        // Update UI
                        updateStatusDisplay(response.new_status);
                        
                        // Show success message
                        let statusText = response.new_status === 'Yes' ? 'attending' : (response.new_status === 'No' ? 'not attending' : 'pending');
                        let icon = response.new_status === 'Yes' ? 'success' : (response.new_status === 'No' ? 'info' : 'warning');
                        
                        Toast.fire({
                            icon: icon,
                            title: `You're now marked as ${statusText}!`
                        });

                        // Add celebration effect for "Yes" response
                        if (response.new_status === 'Yes') {
                            celebrateAttendance();
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'Failed to update attendance status'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong. Please try again.'
                    });
                },
                complete: function() {
                    // Restore button states
                    clickedBtn.innerHTML = originalText;
                    clickedBtn.classList.remove('loading');
                    document.querySelectorAll('.attendance-btn').forEach(btn => {
                        btn.disabled = false;
                    });
                }
            });
        }        function updateStatusDisplay(status) {
            // Update status badge
            const statusBadge = document.getElementById('current-status');
            const statusText = status === 'Yes' ? 'Yes' : (status === 'No' ? 'No' : 'Not Confirmed');
            const statusClass = status === 'Yes' ? 'status-yes' : (status === 'No' ? 'status-no' : 'status-pending');
            
            statusBadge.textContent = statusText;
            statusBadge.className = `status-badge ${statusClass}`;
            
            // Add pulse effect for "Yes" status
            if (status === 'Yes') {
                statusBadge.classList.add('pulse');
            } else {
                statusBadge.classList.remove('pulse');
            }

            // Hide buttons and show confirmation message if status is not pending
            const buttonsContainer = document.getElementById('attendance-buttons');
            const confirmedContainer = document.getElementById('attendance-confirmed');
            
            if (status !== '-') {
                // Hide buttons
                if (buttonsContainer) {
                    buttonsContainer.style.display = 'none';
                }
                
                // Show or create confirmation message
                if (confirmedContainer) {
                    confirmedContainer.style.display = 'block';
                    
                    // Update confirmation message based on status
                    let confirmationHTML = '';
                    if (status === 'Yes') {
                        confirmationHTML = `
                            <div class="confirmed-message">
                                <div style="font-size: 3rem; margin-bottom: 15px;">🎉</div>
                                <h4 style="color: white; margin-bottom: 10px;">Thank You for Confirming!</h4>
                                <p style="opacity: 0.9; margin-bottom: 0;">We're excited to celebrate with you on our special day!</p>
                            </div>
                        `;
                    } else {
                        confirmationHTML = `
                            <div class="confirmed-message">
                                <div style="font-size: 3rem; margin-bottom: 15px;">😔</div>
                                <h4 style="color: white; margin-bottom: 10px;">We'll Miss You!</h4>
                                <p style="opacity: 0.9; margin-bottom: 0;">Thank you for letting us know. We understand and hope to celebrate with you another time!</p>
                            </div>
                        `;
                    }
                    confirmedContainer.innerHTML = confirmationHTML;
                } else {
                    // Create new confirmation container
                    const newConfirmedContainer = document.createElement('div');
                    newConfirmedContainer.id = 'attendance-confirmed';
                    newConfirmedContainer.className = 'attendance-confirmed';
                    
                    let confirmationHTML = '';
                    if (status === 'Yes') {
                        confirmationHTML = `
                            <div class="confirmed-message">
                                <div style="font-size: 3rem; margin-bottom: 15px;">🎉</div>
                                <h4 style="color: white; margin-bottom: 10px;">Thank You for Confirming!</h4>
                                <p style="opacity: 0.9; margin-bottom: 0;">We're excited to celebrate with you on our special day!</p>
                            </div>
                        `;
                    } else {
                        confirmationHTML = `
                            <div class="confirmed-message">
                                <div style="font-size: 3rem; margin-bottom: 15px;">😔</div>
                                <h4 style="color: white; margin-bottom: 10px;">We'll Miss You!</h4>
                                <p style="opacity: 0.9; margin-bottom: 0;">Thank you for letting us know. We understand and hope to celebrate with you another time!</p>
                            </div>
                        `;
                    }
                    newConfirmedContainer.innerHTML = confirmationHTML;
                    
                    // Insert after status
                    document.querySelector('.attendance-status').parentNode.insertBefore(newConfirmedContainer, document.querySelector('.attendance-status').nextSibling);
                }
            } else {
                // Show buttons for pending status
                if (buttonsContainer) {
                    buttonsContainer.style.display = 'block';
                }
                if (confirmedContainer) {
                    confirmedContainer.style.display = 'none';
                }
            }
        }

        function celebrateAttendance() {
            // Simple celebration effect
            const attendanceCard = document.querySelector('.attendance-card');
            attendanceCard.style.transform = 'scale(1.02)';
            attendanceCard.style.transition = 'transform 0.3s ease';
            
            setTimeout(() => {
                attendanceCard.style.transform = 'scale(1)';
            }, 300);

            // Create falling hearts effect
            createFallingHearts();
        }

        function createFallingHearts() {
            const hearts = ['💖', '💕', '💗', '💓', '💝'];
            
            for (let i = 0; i < 10; i++) {
                setTimeout(() => {
                    const heart = document.createElement('div');
                    heart.innerHTML = hearts[Math.floor(Math.random() * hearts.length)];
                    heart.style.position = 'fixed';
                    heart.style.left = Math.random() * 100 + 'vw';
                    heart.style.top = '-50px';
                    heart.style.fontSize = '24px';
                    heart.style.pointerEvents = 'none';
                    heart.style.zIndex = '9999';
                    heart.style.animation = 'fall 3s linear forwards';
                    
                    document.body.appendChild(heart);
                    
                    setTimeout(() => {
                        heart.remove();
                    }, 3000);
                }, i * 200);
            }
        }

        function copyQRCode(qrCode) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(qrCode).then(function() {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'QR Code ID copied to clipboard!'
                    });
                }).catch(function(err) {
                    fallbackCopyTextToClipboard(qrCode);
                });
            } else {
                fallbackCopyTextToClipboard(qrCode);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            var tempInput = document.createElement("input");
            tempInput.style.position = "absolute";
            tempInput.style.left = "-9999px";
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
            
            Toast.fire({
                icon: 'success',
                title: 'QR Code ID copied to clipboard!'
            });
        }

        // Add CSS for falling hearts animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fall {
                0% {
                    transform: translateY(-50px) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Auto-focus for better mobile experience
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add intersection observer for animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            // Observe elements for animation
            document.querySelectorAll('.detail-card, .attendance-card, .qr-section').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
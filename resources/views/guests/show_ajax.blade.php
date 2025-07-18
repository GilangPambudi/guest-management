@empty($guest)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Error!!!</h5>
                    The data you are looking for was not found
                </div>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guest Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Guest Information -->
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th class="text-right col-4">Guest ID:</th>
                                <td class="col-8">
                                    <code>{{ $guest->guest_id_qr_code }}</code>
                                    <button onclick="copyToClipboard('{{ $guest->guest_id_qr_code }}')"
                                        class="btn btn-sm btn-outline-secondary ml-2">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Guest Name:</th>
                                <td>{{ $guest->guest_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Gender:</th>
                                <td>
                                    {{ $guest->guest_gender }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Category:</th>
                                <td>{{ $guest->guest_category }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Contact:</th>
                                <td>{{ $guest->guest_contact }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Address:</th>
                                <td>{{ $guest->guest_address }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Attendance Status:</th>
                                <td>
                                    <span
                                        class="badge badge-{{ $guest->guest_attendance_status == 'Yes' ? 'success' : ($guest->guest_attendance_status == 'No' ? 'danger' : 'secondary') }}">
                                        {{ $guest->guest_attendance_status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Invitation Status:</th>
                                <td>
                                    <span
                                        class="badge badge-{{ $guest->guest_invitation_status == 'Sent' ? 'success' : ($guest->guest_invitation_status == 'Opened' ? 'info' : ($guest->guest_invitation_status == 'Pending' ? 'warning' : 'secondary')) }}">
                                        {{ $guest->guest_invitation_status }}
                                    </span>
                                </td>
                            </tr>
                            @if($guest->invitation_sent_at)
                            <tr>
                                <th class="text-right">Invitation Sent At:</th>
                                <td>{{ \Carbon\Carbon::parse($guest->invitation_sent_at)->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</td>
                            </tr>
                            @endif
                            @if($guest->invitation_opened_at)
                            <tr>
                                <th class="text-right">Opened At:</th>
                                <td>{{ \Carbon\Carbon::parse($guest->invitation_opened_at)->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</td>
                            </tr>
                            @endif                            @if ($guest->guest_arrival_time && $guest->guest_arrival_time != '-')
                                <tr>
                                    <th class="text-right">Arrival Time:</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($guest->guest_arrival_time)->format('d M Y, H:i:s') }} WIB
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th class="text-right">Created At:</th>
                                <td>{{ \Carbon\Carbon::parse($guest->created_at)->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</td>
                            </tr>
                            @if ($guest->updated_at != $guest->created_at)
                                <tr>
                                    <th class="text-right">Last Updated:</th>
                                    <td>{{ \Carbon\Carbon::parse($guest->updated_at)->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <!-- QR Code -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <strong>QR Code</strong>
                            </div>
                            <div class="card-body text-center">
                                @if ($guest->guest_qr_code && file_exists(public_path($guest->guest_qr_code)))
                                    <img src="{{ asset($guest->guest_qr_code) }}" alt="QR Code" class="img-fluid"
                                        style="max-width: 200px;">
                                    <br><br>
                                    <a href="{{ asset($guest->guest_qr_code) }}"
                                        download="QR_{{ $guest->guest_name }}.png" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Download QR
                                    </a>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i><br>
                                        QR Code not found
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card mt-3">
                            <div class="card-header text-center">
                                <strong>Quick Actions</strong>
                            </div>                            <div class="card-body text-center">
                                <a href="{{ url('/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}" target="_blank"
                                    class="btn btn-info btn-sm btn-block mb-2">
                                    <i class="fas fa-external-link-alt"></i> View
                                </a>

                                <button
                                    onclick="copyInvitationLink('{{ url('/' . $invitation->slug . '/' . $guest->guest_id_qr_code) }}')"
                                    class="btn btn-secondary btn-sm btn-block mb-2">
                                    <i class="fas fa-copy"></i> Copy Link
                                </button>

                                @if ($guest->guest_attendance_status != 'Yes')
                                    <button onclick="markAsAttended('{{ $guest->guest_id_qr_code }}')"
                                        class="btn btn-success btn-sm btn-block mb-2">
                                        <i class="fas fa-check"></i> Mark as Attended
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button
                    onclick="editGuest('{{ url('/invitation/' . $guest->invitation_id . '/guests/' . $guest->guest_id . '/edit_ajax') }}')"
                    class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Guest
                </button>
                <button
                    onclick="deleteGuest('{{ url('/invitation/' . $guest->invitation_id . '/guests/' . $guest->guest_id . '/delete_ajax') }}')"
                    class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Guest
                </button>
            </div>
        </div>
    </div>    <script>
        function editGuest(url) {
            $('#myModal').modal('hide');
            setTimeout(function() {
                modalAction(url);
            }, 500);
        }

        function deleteGuest(url) {
            $('#myModal').modal('hide');
            setTimeout(function() {
                modalAction(url);
            }, 500);
        }        function markAsAttended(guestIdQrCode) {
            Swal.fire({
                title: 'Mark as Attended?',
                text: 'This will update the guest RSVP status to "Yes".',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, mark as attended!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we update the attendance status.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Update attendance status via AJAX
                    $.ajax({
                        url: `{{ url('/update-attendance/' . $invitation->slug) }}/${guestIdQrCode}`,
                        type: 'POST',
                        data: {
                            attendance_status: 'Yes',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Guest marked as attended!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                
                                // Close modal and reload data
                                $('#myModal').modal('hide');                                
                                // Safely reload DataTable
                                safeReloadDataTable('#guest-table');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message || 'Failed to update attendance status'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', xhr.responseText);
                            let errorMessage = 'Something went wrong. Please try again.';
                            
                            try {
                                const errorResponse = JSON.parse(xhr.responseText);
                                errorMessage = errorResponse.message || errorMessage;
                            } catch (e) {
                                // Use default error message
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        }
                    });
                }
            });
        }

        function copyInvitationLink(url) {
            navigator.clipboard.writeText(url).then(function() {
                toastr.success('Invitation link copied to clipboard!');
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                toastr.error('Failed to copy link');
            });
        }
    </script>
@endempty

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
    <form action="{{ url('/invitation/' . $guest->invitation_id . '/guests/' . $guest->guest_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Guest Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Confirmation!!!</h5>
                        Do you want to delete this data?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Guest ID:</th>
                            <td class="col-9">
                               {{ $guest->guest_id_qr_code }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Guest Name:</th>
                            <td class="col-9">{{ $guest->guest_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Guest Gender:</th>
                            <td class="col-9">{{ $guest->guest_gender }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Guest Category:</th>
                            <td class="col-9">{{ $guest->guest_category }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Guest Contact:</th>
                            <td class="col-9">{{ $guest->guest_contact }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Guest Address:</th>
                            <td class="col-9">{{ $guest->guest_address }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Attendance Status:</th>
                            <td class="col-9">
                                <span class="badge badge-{{ $guest->guest_attendance_status == 'Yes' ? 'success' : ($guest->guest_attendance_status == 'No' ? 'danger' : 'secondary') }}">
                                    {{ $guest->guest_attendance_status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Invitation Status:</th>
                            <td class="col-9">
                                <span class="badge badge-{{ $guest->guest_invitation_status == 'Sent' ? 'success' : ($guest->guest_invitation_status == 'Opened' ? 'info' : ($guest->guest_invitation_status == 'Pending' ? 'warning' : 'secondary')) }}">
                                    {{ $guest->guest_invitation_status }}
                                </span>
                            </td>
                        </tr>
                        @if($guest->invitation_sent_at)
                        <tr>
                            <th class="text-right col-3">Invitation Sent At:</th>
                            <td class="col-9">{{ \Carbon\Carbon::parse($guest->invitation_sent_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @endif
                        @if($guest->invitation_opened_at)
                        <tr>
                            <th class="text-right col-3">Invitation Opened At:</th>
                            <td class="col-9">{{ \Carbon\Carbon::parse($guest->invitation_opened_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @endif
                        @if($guest->guest_arrival_time)
                        <tr>
                            <th class="text-right col-3">Arrival Time:</th>
                            <td class="col-9">{{ $guest->guest_arrival_time }}</td>
                        </tr>
                        @endif
                    </table>
                    <div class="alert alert-danger mt-3">
                        <strong>Warning:</strong> This action cannot be undone. The guest's QR code will also be deleted permanently.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="btn-delete">
                        <i class="fas fa-ban"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
                    // Disable delete button
                    $('#btn-delete').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Deleting...');
                    
                    $.ajax({
                        url: form.action,
                        type: 'POST', // Menggunakan POST karena Laravel method spoofing                        data: $(form).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            $('#btn-delete').prop('disabled', false).html('<i class="fas fa-trash"></i> Delete');
                            
                            if (response.success) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });                                
                                // Safely reload DataTable
                                safeReloadDataTable('#guest-table');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error Occurred',
                                    text: response.message || 'Failed to delete guest'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#btn-delete').prop('disabled', false).html('<i class="fas fa-trash"></i> Delete');
                            
                            console.error('Delete error:', xhr.responseText);
                            
                            var errorMessage = 'Failed to delete guest';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Occurred',
                                text: errorMessage
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
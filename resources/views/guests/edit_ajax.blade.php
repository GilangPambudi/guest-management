@empty($guest)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Error!!!</h5>
                    The data you are looking for was not found
                </div>
                <a href="{{ url('/guests') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/guests/' . $guest->guest_id . '/update_ajax') }}" method="POST" id="form-edit-guest">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Guest Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_name }}" type="text" name="guest_name" id="guest_name"
                                class="form-control" required>
                            <small id="error-guest_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <input type="hidden" name="guest_id_qr_code" id="guest_id_qr_code" value="{{ $guest->guest_id_qr_code }}">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Gender</label>
                        <div class="col-sm-9">
                            <select name="guest_gender" id="guest_gender" class="form-control" required>
                                <option value="Male" {{ $guest->guest_gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $guest->guest_gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <small id="error-guest_gender" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Category</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_category }}" type="text" name="guest_category" id="guest_category"
                                class="form-control" required>
                            <small id="error-guest_category" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Contact</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_contact }}" type="text" name="guest_contact" id="guest_contact"
                                class="form-control" required>
                            <small id="error-guest_contact" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Address</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_address }}" type="text" name="guest_address" id="guest_address"
                                class="form-control" required>
                            <small id="error-guest_address" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest QR Code</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_qr_code }}" type="text" name="guest_qr_code" id="guest_qr_code"
                                class="form-control" required>
                            <small id="error-guest_qr_code" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Attendance Status</label>
                        <div class="col-sm-9">
                            <select name="guest_attendance_status" id="guest_attendance_status" class="form-control" required>
                                <option value="Yes" {{ $guest->guest_attendance_status == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $guest->guest_attendance_status == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Pending" {{ $guest->guest_attendance_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="-" {{ $guest->guest_attendance_status == '-' ? 'selected' : '' }}>-</option>
                            </select>
                            <small id="error-guest_attendance_status" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Invitation Status</label>
                        <div class="col-sm-9">
                            <select name="guest_invitation_status" id="guest_invitation_status" class="form-control" required>
                                <option value="Sent" {{ $guest->guest_invitation_status == 'Sent' ? 'selected' : '' }}>Sent</option>
                                <option value="Opened" {{ $guest->guest_invitation_status == 'Opened' ? 'selected' : '' }}>Opened</option>
                                <option value="-" {{ $guest->guest_invitation_status == '-' ? 'selected' : '' }}>-</option>
                            </select>
                            <small id="error-guest_invitation_status" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-edit-guest").validate({
                rules: {
                    guest_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    guest_gender: {
                        required: true,
                    },
                    guest_category: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    guest_contact: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    guest_address: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    guest_qr_code: {
                        required: true,
                    },
                    guest_attendance_status: {
                        required: true
                    },
                    guest_invitation_status: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.success) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                });
                                $('#guest-table').DataTable().ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.errors, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Something Wrong',
                                    text: response.message
                                });
                            }
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
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
    <form action="{{ url('/invitation/' . $guest->invitation_id . '/guests/' . $guest->guest_id . '/update_ajax') }}"
        method="POST" id="form-edit-guest">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Guest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="icon fas fa-info"></i> <strong>Current Guest ID:</strong>
                        <code>{{ $guest->guest_id_qr_code }}</code>
                        <br><small class="text-muted">Note: QR Code will be regenerated if name is changed</small>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_name }}" type="text" name="guest_name" id="guest_name"
                                class="form-control" required>
                            <small id="error-guest_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Gender</label>
                        <div class="col-sm-9">
                            <select name="guest_gender" id="guest_gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ $guest->guest_gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $guest->guest_gender == 'Female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                            <small id="error-guest_gender" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Category</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_category }}" type="text" name="guest_category"
                                id="guest_category" class="form-control" required>
                            <small id="error-guest_category" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Contact</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_contact }}" type="text" name="guest_contact"
                                id="guest_contact" class="form-control" required>
                            <small id="error-guest_contact" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Address</label>
                        <div class="col-sm-9">
                            <textarea name="guest_address" id="guest_address" class="form-control" rows="2" required>{{ $guest->guest_address }}</textarea>
                            <small id="error-guest_address" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Attendance Status</label>
                        <div class="col-sm-9">
                            <select name="guest_attendance_status" id="guest_attendance_status" class="form-control"
                                required>
                                <option value="-" {{ $guest->guest_attendance_status == '-' ? 'selected' : '' }}>Not
                                    Set</option>
                                <option value="Yes" {{ $guest->guest_attendance_status == 'Yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="No" {{ $guest->guest_attendance_status == 'No' ? 'selected' : '' }}>No
                                </option>
                            </select>
                            <small id="error-guest_attendance_status" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Invitation Status</label>
                        <div class="col-sm-9">
                            <select name="guest_invitation_status" id="guest_invitation_status" class="form-control"
                                required>
                                <option value="-" {{ $guest->guest_invitation_status == '-' ? 'selected' : '' }}>Not
                                    Set</option>
                                <option value="Sent" {{ $guest->guest_invitation_status == 'Sent' ? 'selected' : '' }}>
                                    Sent</option>
                                <option value="Opened" {{ $guest->guest_invitation_status == 'Opened' ? 'selected' : '' }}>
                                    Opened</option>
                                <option value="Pending"
                                    {{ $guest->guest_invitation_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            <small id="error-guest_invitation_status" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    @if($guest->invitation_sent_at)
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Sent At</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($guest->invitation_sent_at)->format('d/m/Y H:i:s') }}" readonly>
                            <small class="form-text text-muted">When the invitation was sent via WhatsApp</small>
                        </div>
                    </div>
                    @endif

                    @if($guest->invitation_opened_at)
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Opened At</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($guest->invitation_opened_at)->format('d/m/Y H:i:s') }}" readonly>
                            <small class="form-text text-muted">When the guest opened the invitation letter</small>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <div class="col-12 mb-2">
                        <input type="text" class="form-control"
                            value="You're logged in as: {{ Auth::check() ? Auth::user()->name : 'User is not authenticated.' }}"
                            disabled readonly>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btn-update">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            // Pastikan jQuery validation plugin dimuat
            if (typeof $.fn.validate === 'undefined') {
                console.error('jQuery Validation plugin not loaded');
                return;
            }

            $("#form-edit-guest").validate({
                rules: {
                    guest_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    guest_gender: {
                        required: true
                    },
                    guest_category: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    guest_contact: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        digits: true,
                        remote: {
                            url: "{{ url('/invitation/' . $guest->invitation_id . '/guests/check-contact') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                guest_contact: function() {
                                    return $("#guest_contact").val();
                                },
                                guest_id: {{ $guest->guest_id }} // Exclude current guest from check
                            },
                            dataFilter: function(response) {
                                var json = JSON.parse(response);
                                return json === true ? '"true"' :
                                    '"Contact number is already registered"';
                            }
                        }
                    },
                    guest_address: {
                        required: true,
                        minlength: 5,
                        maxlength: 500
                    },
                    guest_attendance_status: {
                        required: true
                    },
                    guest_invitation_status: {
                        required: true
                    }
                },
                messages: {
                    guest_name: {
                        required: "Guest name is required",
                        minlength: "Guest name must be at least 2 characters",
                        maxlength: "Guest name cannot exceed 255 characters"
                    },
                    guest_gender: {
                        required: "Please select gender"
                    },
                    guest_category: {
                        required: "Guest category is required",
                        minlength: "Category must be at least 2 characters"
                    },
                    guest_contact: {
                        required: "Contact number is required",
                        minlength: "Contact number must be at least 8 digits",
                        maxlength: "Contact number cannot exceed 20 digits",
                        digits: "Please enter valid phone number (digits only)",
                        remote: "This contact number is already registered"
                    },
                    guest_address: {
                        required: "Address is required",
                        minlength: "Address must be at least 5 characters"
                    },
                    guest_attendance_status: {
                        required: "Please select attendance status"
                    },
                    guest_invitation_status: {
                        required: "Please select invitation status"
                    }
                },
                errorElement: 'small',
                errorPlacement: function(error, element) {
                    error.addClass('error-text form-text text-danger');
                    var fieldName = element.attr('name');
                    var errorContainer = $('#error-' + fieldName);
                    if (errorContainer.length) {
                        errorContainer.html(error);
                    } else {
                        element.closest('.form-group').find('.error-text').html(error);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),                        success: function(response) {
                            if (response.status || response.success) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message || 'Guest updated successfully'
                                });                                
                                // Safely reload DataTable
                                safeReloadDataTable('#guest-table');
                            } else {
                                $('.error-text').text('');
                                $.each(response.errors || {}, function(field, messages) {
                                    $('#error-' + field).text(messages[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Something Wrong',
                                    text: response.message || 'Failed to update guest'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something Wrong',
                                text: 'Failed to update guest'
                            });
                        }
                    });

                    return false;
                }
            });
        });
    </script>
@endempty

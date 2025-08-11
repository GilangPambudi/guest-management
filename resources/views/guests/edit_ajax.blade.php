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
                            <select name="guest_category_select" id="guest_category_select" class="form-control mb-2">
                                <option value="">-- Select existing category --</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ $guest->guest_category == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                @endif
                                <option value="custom" {{ !$categories->contains($guest->guest_category) ? 'selected' : '' }}>+ Add new category</option>
                            </select>
                            <input value="{{ $guest->guest_category }}" type="text" name="guest_category" id="guest_category" 
                                   class="form-control {{ $categories->contains($guest->guest_category) ? 'd-none' : '' }}" 
                                   placeholder="Enter new category" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Select from existing categories or choose "Add new category" to create a custom one
                            </small>
                            <small id="error-guest_category" class="error-text form-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Guest Contact</label>
                        <div class="col-sm-9">
                            <input value="{{ $guest->guest_contact }}" type="text" name="guest_contact"
                                id="guest_contact" class="form-control" required placeholder="e.g. +62 812-3456-7890 or 08123456789">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                You can enter: +62 812-3456-7890, 0812-3456-7890, or 6281234567890
                            </small>
                            <small id="phone-preview" class="form-text text-success d-none">
                                <i class="fas fa-check-circle"></i> 
                                Will be saved as: <span id="preview-text"></span>
                            </small>
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

            // Phone number formatting function
            function normalizePhoneNumber(phoneNumber) {
                // Remove all non-numeric characters
                let phone = phoneNumber.replace(/[^0-9]/g, '');
                
                // Handle different formats
                if (phone.startsWith('620')) {
                    // 6208xxx -> 628xxx (remove leading 0 after 62)
                    phone = '62' + phone.substring(3);
                } else if (phone.startsWith('62')) {
                    // Already in 62xxx format, keep as is
                    phone = phone;
                } else if (phone.startsWith('0')) {
                    // 08xxx -> 628xxx
                    phone = '62' + phone.substring(1);
                } else if (phone.startsWith('8')) {
                    // 8xxx -> 628xxx
                    phone = '62' + phone;
                } else if (phone.length > 0) {
                    // Other formats, prepend 62
                    phone = '62' + phone;
                }
                
                // Validate final format (should be 62 followed by 8-13 digits)
                if (phone.match(/^62[0-9]{8,13}$/)) {
                    return phone;
                }
                
                return null; // Invalid format
            }
            
            // Phone number input handler
            $('#guest_contact').on('input', function() {
                const inputValue = $(this).val();
                const normalized = normalizePhoneNumber(inputValue);
                
                if (inputValue.length > 0) {
                    if (normalized) {
                        $('#phone-preview').removeClass('d-none');
                        $('#preview-text').text(normalized);
                        $(this).removeClass('is-invalid');
                    } else {
                        $('#phone-preview').addClass('d-none');
                        if (inputValue.length > 3) { // Only show error after user typed something meaningful
                            $(this).addClass('is-invalid');
                        }
                    }
                } else {
                    $('#phone-preview').addClass('d-none');
                    $(this).removeClass('is-invalid');
                }
            });
            
            // Trigger format check for existing value
            $('#guest_contact').trigger('input');

            // Handle category dropdown
            $('#guest_category_select').on('change', function() {
                var value = $(this).val();
                var customInput = $('#guest_category');
                
                if (value === 'custom') {
                    customInput.show().removeClass('d-none');
                    customInput.prop('required', true);
                } else {
                    customInput.hide().addClass('d-none');
                    customInput.prop('required', false);
                    // Set the selected category value to the hidden input
                    if (value !== '') {
                        customInput.val(value);
                    }
                }
            });
            
            // Trigger change event on page load to set initial state
            $('#guest_category_select').trigger('change');

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
                        remote: {
                            url: "{{ url('/invitation/' . $guest->invitation_id . '/guests/check-contact') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                guest_contact: function() {
                                    // Send normalized phone number for checking
                                    const normalized = normalizePhoneNumber($("#guest_contact").val());
                                    return normalized || $("#guest_contact").val();
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

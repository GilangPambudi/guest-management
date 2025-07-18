<form action="{{ url('/invitation/' . $invitation->invitation_id . '/guests/store_ajax') }}" method="POST" id="form-tambah-guest">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Guest</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="icon fas fa-info"></i> <strong>{{ $invitation->wedding_name }}</strong><br>
                    {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Name</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_name" id="guest_name" class="form-control" required>
                        <small id="error-guest_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Gender</label>
                    <div class="col-sm-9">
                        <select name="guest_gender" id="guest_gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <small id="error-guest_gender" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Category</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_category" id="guest_category" class="form-control" placeholder="e.g. Family, Friend, VIP" required>
                        <small id="error-guest_category" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Contact</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_contact" id="guest_contact" class="form-control" required placeholder="e.g. +62 812-3456-7890 or 08123456789">
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
                        <textarea name="guest_address" id="guest_address" class="form-control" rows="2" required></textarea>
                        <small id="error-guest_address" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <!-- Hidden fields for default values -->
                <input type="hidden" name="guest_attendance_status" value="-">
                <input type="hidden" name="guest_invitation_status" value="-">
            </div>
            <div class="modal-footer">
                <div class="col-12 mb-2">
                    <input type="text" class="form-control" value="You're logged in as: {{ Auth::check() ? Auth::user()->name : 'User is not authenticated.' }}" disabled readonly>
                </div>
                <div class="col-12 mb-2">
                    <button type="button" class="btn btn-warning btn-sm" id="btn-clear-form">
                        <i class="fas fa-eraser"></i> Clear Form
                    </button>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
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

    const formStorageKey = 'guest_form_data_{{ $invitation->invitation_id }}';
    
    // Function to save form data to localStorage
    function saveFormData() {
        const formData = {
            guest_name: $('#guest_name').val(),
            guest_gender: $('#guest_gender').val(),
            guest_category: $('#guest_category').val(),
            guest_contact: $('#guest_contact').val(),
            guest_address: $('#guest_address').val()
        };
        localStorage.setItem(formStorageKey, JSON.stringify(formData));
    }
    
    // Function to restore form data from localStorage
    function restoreFormData() {
        const savedData = localStorage.getItem(formStorageKey);
        if (savedData) {
            try {
                const formData = JSON.parse(savedData);
                $('#guest_name').val(formData.guest_name || '');
                $('#guest_gender').val(formData.guest_gender || '');
                $('#guest_category').val(formData.guest_category || '');
                $('#guest_contact').val(formData.guest_contact || '');
                $('#guest_address').val(formData.guest_address || '');
                
                // Show info if data was restored
                if (formData.guest_name || formData.guest_gender || formData.guest_category || formData.guest_contact || formData.guest_address) {
                    toastr.info('Previous form data has been restored. Click "Clear Form" if you want to start fresh.');
                }
            } catch (e) {
                console.error('Error parsing saved form data:', e);
                localStorage.removeItem(formStorageKey);
            }
        }
    }
    
    // Function to clear form data from localStorage
    function clearFormData() {
        localStorage.removeItem(formStorageKey);
    }
    
    // Restore form data when modal opens
    restoreFormData();
    
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
    
    // Save form data when user types/selects
    $('#form-tambah-guest input, #form-tambah-guest select, #form-tambah-guest textarea').on('input change', function() {
        saveFormData();
    });
    
    // Clear form button
    $('#btn-clear-form').on('click', function() {
        Swal.fire({
            title: 'Clear Form?',
            text: 'Are you sure you want to clear all form data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, clear it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Clear form fields
                $('#form-tambah-guest')[0].reset();
                $('#form-tambah-guest input, #form-tambah-guest select, #form-tambah-guest textarea').removeClass('is-invalid is-valid');
                $('.error-text').text('');
                
                // Clear localStorage
                clearFormData();
                
                toastr.success('Form has been cleared');
            }
        });
    });

    $("#form-tambah-guest").validate({
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
                    url: "{{ url('/invitation/' . $invitation->invitation_id . '/guests/check-contact') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        guest_contact: function() {
                            // Send normalized phone number for checking
                            const normalized = normalizePhoneNumber($("#guest_contact").val());
                            return normalized || $("#guest_contact").val();
                        }
                    },
                    dataFilter: function(response) {
                        var json = JSON.parse(response);
                        return json === true ? '"true"' : '"Contact number is already registered"';
                    }
                }
            },
            guest_address: {
                required: true,
                minlength: 5,
                maxlength: 500
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
        },        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            // Disable submit button
            $('#btn-save').prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: $(form).serialize(),                success: function(response) {
                    $('#btn-save').prop('disabled', false).text('Save');
                    
                    if (response.status || response.success) {
                        // Clear saved form data after successful submission
                        clearFormData();
                        
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Guest Added',
                            text: response.message || 'Guest added successfully'
                        });                        
                        // Safely reload DataTable
                        safeReloadDataTable('#guest-table');
                    } else {
                        $('.error-text').text('');
                        $.each(response.errors || {}, function(field, messages) {
                            $('#error-' + field).text(messages[0]);
                            $('[name="' + field + '"]').addClass('is-invalid');
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Wrong',
                            text: response.message || 'Please check your input and try again.'
                        });
                    }
                },                error: function(xhr, status, error) {
                    $('#btn-save').prop('disabled', false).text('Save');
                    console.error('AJAX Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong',
                        text: 'Failed to add guest. Please try again.'
                    });
                }
            });
            
            return false;
        }
    });
});
</script>
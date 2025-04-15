<form action="{{ url('/guests/store_ajax') }}" method="POST" id="form-tambah-guest">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Guest</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Name</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_name" id="guest_name" class="form-control"
                            required>
                        <small id="error-guest_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <input type="hidden" name="guest_id_qr_code" id="guest_id_qr_code">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Gender</label>
                    <div class="col-sm-9">
                        <select name="guest_gender" id="guest_gender" class="form-control" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <small id="error-guest_gender" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Category</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_category" id="guest_category"
                            class="form-control" required>
                        <small id="error-guest_category" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Contact</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_contact" id="guest_contact"
                            class="form-control" required>
                        <small id="error-guest_contact" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Address</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_address" id="guest_address"
                            class="form-control" required>
                        <small id="error-guest_address" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <input type="hidden" name="guest_qr_code" id="guest_qr_code">
                <input type="hidden" name="guest_attendance_status" id="guest_attendance_status" value="-">
                <input type="hidden" name="guest_invitation_status" id="guest_invitation_status" value="-">
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->user_id }}">
            </div>
            <div class="modal-footer">
                <input type="text" class="form-control" value="You're login as: {{ Auth::check() ? Auth::user()->name : 'User is not authenticated.' }}" disabled>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-tambah-guest").validate({
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
                    maxlength: 255,
                    remote: {
                        url: "{{ url('/guests/check-contact') }}",
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            guest_contact: function() {
                                return $("#guest_contact").val();
                            }
                        }
                    }
                },
                guest_address: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                guest_attendance_status: {
                    required: true
                },
                guest_invitation_status: {
                    required: true
                }
            },
            messages: {
                guest_contact: {
                    remote: "This contact number is already registered."
                }
            },
            submitHandler: function(form) {
                var timestamp = Date.now(); // Ambil timestamp
                var cuidValue = cuid().slice(0, 8); // Ambil 8 karakter pertama dari cuid
                var guestName = $("#guest_name").val().replace(/\s+/g, '-').toLowerCase(); // Format nama
                var guestIdQrCode = `${timestamp}-${cuidValue}-${guestName}`; // Gabungkan format

                $("#guest_id_qr_code").val(guestIdQrCode); // Set nilai ke input hidden
                $("#guest_qr_code").val(guestIdQrCode);

                // Tampilkan SweetAlert loading
                Swal.fire({
                    title: 'Loading...',
                    text: 'Generating QR Code and processing your request. Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Guest Added',
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
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Wrong',
                            text: 'Failed to add guest'
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
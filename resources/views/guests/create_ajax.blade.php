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
                @if (Auth::check())
                    <p>User ID: {{ Auth::user()->user_id }}</p>
                    <p>User Name: {{ Auth::user()->name }}</p>
                @else
                    <p>User is not authenticated.</p>
                @endif
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Name</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_name" id="guest_name" class="form-control"
                            required>
                        <small id="error-guest_name" class="error-text form-text text-danger"></small>
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
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest QR Code</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="guest_qr_code" id="guest_qr_code"
                            class="form-control" required>
                        <small id="error-guest_qr_code" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Attendance Status</label>
                    <div class="col-sm-9">
                        <select name="guest_attendance_status" id="guest_attendance_status" class="form-control"
                            required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Pending">Pending</option>
                            <option value="-">-</option>
                        </select>
                        <small id="error-guest_attendance_status" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest Invitation Status</label>
                    <div class="col-sm-9">
                        <select name="guest_invitation_status" id="guest_invitation_status" class="form-control"
                            required>
                            <option value="Sent">Sent</option>
                            <option value="Opened">Opened</option>
                            <option value="-">-</option>
                        </select>
                        <small id="error-guest_invitation_status" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->user_id }}">
            </div>
            <div class="modal-footer">
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

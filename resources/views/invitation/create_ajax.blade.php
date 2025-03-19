<form action="{{ url('/invitation/store_ajax') }}" method="POST" id="form-tambah-invitation">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Invitation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Guest</label>
                    <div class="col-sm-9">
                        <select name="guest_id" id="guest_id" class="form-control" required>
                            <option value="" disabled selected>Select Guest</option>
                            @foreach($guests as $guest)
                                <option value="{{ $guest->guest_id }}" data-alias="{{ $guest->guest_alias }}">{{ $guest->guest_name }}</option>
                            @endforeach
                        </select>
                        <small id="error-guest_id" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Name</label>
                    <div class="col-sm-9">
                        <input value="Select Groom and Bride" type="text" name="wedding_name" id="wedding_name" class="form-control"
                            required readonly>
                        <small id="error-wedding_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Groom</label>
                    <div class="col-sm-9">
                        <select name="groom_id" id="groom_id" class="form-control" required>
                            <option value="" disabled selected>Select Groom</option>
                            @foreach($grooms as $groom)
                                <option value="{{ $groom->couple_id }}" data-alias="{{ $groom->couple_alias }}">{{ $groom->couple_name }}</option>
                            @endforeach
                        </select>
                        <small id="error-groom_id" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bride</label>
                    <div class="col-sm-9">
                        <select name="bride_id" id="bride_id" class="form-control" required>
                            <option value="" disabled selected>Select Bride</option>
                            @foreach($brides as $bride)
                                <option value="{{ $bride->couple_id }}" data-alias="{{ $bride->couple_alias }}">{{ $bride->couple_name }}</option>
                            @endforeach
                        </select>
                        <small id="error-bride_id" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Date</label>
                    <div class="col-sm-9">
                        <input value="" type="date" name="wedding_date" id="wedding_date" class="form-control"
                            required>
                        <small id="error-wedding_date" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Time Start</label>
                    <div class="col-sm-9">
                        <input value="" type="time" name="wedding_time_start" id="wedding_time_start" class="form-control"
                            required>
                        <small id="error-wedding_time_start" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Time End</label>
                    <div class="col-sm-9">
                        <input value="" type="time" name="wedding_time_end" id="wedding_time_end" class="form-control"
                            required>
                        <small id="error-wedding_time_end" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Location</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="location" id="location" class="form-control"
                            required>
                        <small id="error-location" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select name="status" id="status" class="form-control" required>
                            <option value="" disabled selected>Select Status</option>
                            @foreach(['Sent', 'Opened'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <small id="error-status" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <input type="hidden" name="opened_at" id="opened_at">
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
        function updateWeddingName() {
            var groomAlias = $('#groom_id option:selected').data('alias');
            var brideAlias = $('#bride_id option:selected').data('alias');
            if (groomAlias && brideAlias) {
                $('#wedding_name').val(groomAlias + ' & ' + brideAlias);
            } else {
                $('#wedding_name').val('');
            }
        }

        $('#groom_id, #bride_id').change(function() {
            updateWeddingName();
        });

        $("#form-tambah-invitation").validate({
            rules: {
                wedding_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                groom_id: {
                    required: true,
                },
                bride_id: {
                    required: true,
                },
                wedding_date: {
                    required: true,
                },
                wedding_time_start: {
                    required: true,
                },
                wedding_time_end: {
                    required: true,
                },
                location: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                status: {
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
                                title: 'Invitation Added',
                                text: response.message
                            });
                            $('#invitation-table').DataTable().ajax.reload();
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
                            text: 'Failed to add invitation'
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
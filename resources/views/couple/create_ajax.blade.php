<form action="{{ url('/couple/store_ajax') }}" method="POST" id="form-tambah-couple">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Couple</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Couple Name</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="couple_name" id="couple_name" class="form-control"
                            required>
                        <small id="error-couple_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Couple Alias</label>
                    <div class="col-sm-9">
                        <input value="" type="text" name="couple_alias" id="couple_alias" class="form-control"
                            required>
                        <small id="error-couple_alias" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Couple Gender</label>
                    <div class="col-sm-9">
                        <select name="couple_gender" id="couple_gender" class="form-control" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <small id="error-couple_gender" class="error-text form-text text-danger"></small>
                    </div>
                </div>
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
        $("#form-tambah-couple").validate({
            rules: {
                couple_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                couple_alias: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                couple_gender: {
                    required: true,
                },
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
                                title: 'Name Added',
                                text: response.message
                            });
                            $('#couple-table').DataTable().ajax.reload();
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
                            text: 'Failed to add couple'
                        });
                    }
                });
                return false; // Prevent standard form submission
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
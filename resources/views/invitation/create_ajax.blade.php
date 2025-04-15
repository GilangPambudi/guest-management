<form action="{{ url('/invitation/store_ajax') }}" method="POST" id="form-create-invitation" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Invitation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="wedding_name" id="wedding_name" class="form-control" required
                            readonly>
                        <small id="error-wedding_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Groom Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="groom_name" id="groom_name" class="form-control" required>
                        <small id="error-groom_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bride Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="bride_name" id="bride_name" class="form-control" required>
                        <small id="error-bride_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <input type="hidden" name="groom_alias" id="groom_alias" required>
                <input type="hidden" name="bride_alias" id="bride_alias" required>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Date</label>
                    <div class="col-sm-9">
                        <input type="date" name="wedding_date" id="wedding_date" class="form-control" required>
                        <small id="error-wedding_date" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Time Start</label>
                    <div class="col-sm-9">
                        <input type="time" name="wedding_time_start" id="wedding_time_start" class="form-control"
                            required>
                        <small id="error-wedding_time_start" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Time End</label>
                    <div class="col-sm-9">
                        <input type="time" name="wedding_time_end" id="wedding_time_end" class="form-control"
                            required>
                        <small id="error-wedding_time_end" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Venue</label>
                    <div class="col-sm-9">
                        <input type="text" name="wedding_venue" id="wedding_venue" class="form-control" required>
                        <small id="error-wedding_venue" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Location</label>
                    <div class="col-sm-9">
                        <input type="text" name="wedding_location" id="wedding_location" class="form-control"
                            required>
                        <small id="error-wedding_location" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Maps (URL)</label>
                    <div class="col-sm-9">
                        <input type="url" name="wedding_maps" id="wedding_maps" class="form-control">
                        <small id="error-wedding_maps" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Image</label>
                    <div class="col-sm-9">
                        <input type="file" name="wedding_image" id="wedding_image" class="form-control">
                        <small id="error-wedding_image" class="error-text form-text text-danger"></small>
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
        $("#form-create-invitation").validate({
            rules: {
                wedding_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                groom_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                bride_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                wedding_date: {
                    required: true
                },
                wedding_time_start: {
                    required: true,
                    pattern: /^([01]\d|2[0-3]):([0-5]\d)$/
                },
                wedding_time_end: {
                    required: true,
                    pattern: /^([01]\d|2[0-3]):([0-5]\d)$/
                },
                wedding_venue: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                wedding_location: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                wedding_maps: {
                    url: true
                },
                wedding_image: {
                    extension: "jpg|jpeg|png"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
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
                    error: function() {
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
    $(document).ready(function() {
        $('#groom_name').on('input', function() {
            const groomName = $(this).val().split(' ')[0];
            $('#groom_alias').val(groomName);
        });

        $('#bride_name').on('input', function() {
            const brideName = $(this).val().split(' ')[0];
            $('#bride_alias').val(brideName);
        });
    });
    $(document).ready(function() {
        $('#groom_name, #bride_name').on('input', function() {
            const groomAlias = $('#groom_alias').val();
            const brideAlias = $('#bride_alias').val();
            if (groomAlias && brideAlias) {
                $('#wedding_name').val(`${groomAlias} & ${brideAlias}`);
            }
        });
    });
    $(document).ready(function() {
        const formId = "{{ isset($invitation) ? 'form-edit-invitation' : 'form-create-invitation' }}"; // Tentukan form ID
        const storageKey = formId + "-data"; // Kunci untuk localStorage/sessionStorage

        // Fungsi untuk menyimpan data form ke localStorage
        function saveFormData() {
            const formData = {};
            $(`#${formId} :input`).each(function() {
                const input = $(this);
                if (input.attr('name')) {
                    formData[input.attr('name')] = input.val();
                }
            });
            localStorage.setItem(storageKey, JSON.stringify(formData));
        }

        // Fungsi untuk memuat data form dari localStorage
        function loadFormData() {
            const savedData = localStorage.getItem(storageKey);
            if (savedData) {
                const formData = JSON.parse(savedData);
                for (const name in formData) {
                    $(`#${formId} [name="${name}"]`).val(formData[name]);
                }
            }
        }

        // Muat data form saat halaman dimuat
        loadFormData();

        // Simpan data form setiap kali ada perubahan
        $(`#${formId} :input`).on('input change', function() {
            saveFormData();
        });

        // Hapus data form dari localStorage saat form berhasil disubmit
        $(`#${formId}`).on('submit', function() {
            localStorage.removeItem(storageKey);
        });
    });
</script>

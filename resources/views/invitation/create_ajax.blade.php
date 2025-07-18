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
            <div class="modal-body">                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Wedding Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="wedding_name" id="wedding_name" class="form-control" required
                            readonly>
                        <small id="error-wedding_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Slug <small class="text-muted">(optional)</small></label>
                    <div class="col-sm-9">
                        <input type="text" name="slug" id="slug" class="form-control" 
                            placeholder="Auto-generated from wedding name">
                        <small class="form-text text-muted">Used for invitation URL. Leave empty to auto-generate.</small>
                        <small id="error-slug" class="error-text form-text text-danger"></small>
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
                
                <!-- Groom Details Section -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Groom Alias</label>
                    <div class="col-sm-9">
                        <input type="text" name="groom_alias" id="groom_alias" class="form-control" required>
                        <small id="error-groom_alias" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Groom Image</label>
                    <div class="col-sm-9">
                        <input type="file" name="groom_image" id="groom_image" class="form-control" accept="image/*" required>
                        <small class="form-text text-muted">Upload groom photo (JPEG, PNG, JPG, WEBP, max 2MB)</small>
                        <small id="error-groom_image" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Groom Child Number</label>
                    <div class="col-sm-9">
                        <input type="number" name="groom_child_number" id="groom_child_number" class="form-control" min="1" required>
                        <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                        <small id="error-groom_child_number" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Groom Father</label>
                    <div class="col-sm-9">
                        <input type="text" name="groom_father" id="groom_father" class="form-control" required>
                        <small id="error-groom_father" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Groom Mother</label>
                    <div class="col-sm-9">
                        <input type="text" name="groom_mother" id="groom_mother" class="form-control" required>
                        <small id="error-groom_mother" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                
                <!-- Bride Details Section -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bride Alias</label>
                    <div class="col-sm-9">
                        <input type="text" name="bride_alias" id="bride_alias" class="form-control" required>
                        <small id="error-bride_alias" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bride Image</label>
                    <div class="col-sm-9">
                        <input type="file" name="bride_image" id="bride_image" class="form-control" accept="image/*" required>
                        <small class="form-text text-muted">Upload bride photo (JPEG, PNG, JPG, WEBP, max 2MB)</small>
                        <small id="error-bride_image" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bride Child Number</label>
                    <div class="col-sm-9">
                        <input type="number" name="bride_child_number" id="bride_child_number" class="form-control" min="1" required>
                        <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                        <small id="error-bride_child_number" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bride Father</label>
                    <div class="col-sm-9">
                        <input type="text" name="bride_father" id="bride_father" class="form-control" required>
                        <small id="error-bride_father" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bride Mother</label>
                    <div class="col-sm-9">
                        <input type="text" name="bride_mother" id="bride_mother" class="form-control" required>
                        <small id="error-bride_mother" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Date</label>
                    <div class="col-sm-9">
                        <input type="date" name="wedding_date" id="wedding_date" class="form-control" required>
                        <small id="error-wedding_date" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Time Start</label>
                    <div class="col-sm-9">
                        <input type="time" name="wedding_time_start" id="wedding_time_start" class="form-control"
                            required>
                        <small id="error-wedding_time_start" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Time End</label>
                    <div class="col-sm-9">
                        <input type="time" name="wedding_time_end" id="wedding_time_end" class="form-control"
                            required>
                        <small id="error-wedding_time_end" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Venue</label>
                    <div class="col-sm-9">
                        <input type="text" name="wedding_venue" id="wedding_venue" class="form-control" required>
                        <small id="error-wedding_venue" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Location Address</label>
                    <div class="col-sm-9">
                        <input type="text" name="wedding_location" id="wedding_location" class="form-control"
                            required>
                        <small id="error-wedding_location" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Maps (URL)</label>
                    <div class="col-sm-9">
                        <input type="url" name="wedding_maps" id="wedding_maps" class="form-control">
                        <small id="error-wedding_maps" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Couple Image</label>
                    <div class="col-sm-9">
                        <input type="file" name="wedding_image" id="wedding_image" class="form-control" accept="image/*" required>
                        <small class="form-text text-muted">Upload wedding photo (JPEG, PNG, JPG, WEBP, max 2MB)</small>
                        <small id="error-wedding_image" class="error-text form-text text-danger"></small>
                    </div>
                </div>
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
                groom_alias: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                groom_image: {
                    required: true,
                    extension: "jpg|jpeg|png|webp"
                },
                groom_child_number: {
                    required: true,
                    min: 1
                },
                groom_father: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                groom_mother: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                bride_alias: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                bride_image: {
                    required: true,
                    extension: "jpg|jpeg|png|webp"
                },
                bride_child_number: {
                    required: true,
                    min: 1
                },
                bride_father: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                bride_mother: {
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
                    required: true,
                    extension: "jpg|jpeg|png|webp"
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
    });    $(document).ready(function() {
        // Function to generate slug
        function generateSlug(text) {
            return text
                .toLowerCase()
                .replace(/[^a-z0-9\s&-]/g, '') // Allow & character temporarily
                .replace(/\s*&\s*/g, '-')       // Replace " & " with "-"
                .replace(/\s+/g, '-')           // Replace spaces with hyphens
                .replace(/-+/g, '-')            // Replace multiple hyphens with single
                .replace(/^-+|-+$/g, '')        // Remove leading/trailing hyphens
                .trim();
        }
        
        // Function to update wedding name and slug
        function updateWeddingNameAndSlug() {
            const groomName = $('#groom_name').val();
            const brideName = $('#bride_name').val();
            
            if (groomName && brideName) {
                const groomAlias = groomName.split(' ')[0];
                const brideAlias = brideName.split(' ')[0];
                
                $('#groom_alias').val(groomAlias);
                $('#bride_alias').val(brideAlias);
                
                const weddingName = `${groomAlias} & ${brideAlias}`;
                $('#wedding_name').val(weddingName);
                
                // Auto-generate slug if slug field is empty or if it was auto-generated before
                const currentSlug = $('#slug').val();
                if (!currentSlug || $('#slug').data('auto-generated')) {
                    const slug = generateSlug(weddingName);
                    $('#slug').val(slug).data('auto-generated', true);
                }
            }
        }
        
        // Event listeners for groom and bride name inputs
        $('#groom_name, #bride_name').on('input', function() {
            updateWeddingNameAndSlug();
        });
        
        // Allow manual slug editing
        $('#slug').on('input', function() {
            const value = $(this).val();
            const slug = generateSlug(value);
            if (value !== slug) {
                $(this).val(slug);
            }
            // Mark as manually edited
            $(this).data('auto-generated', false);
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
                $('#form-create-invitation')[0].reset();
                $('#form-create-invitation input, #form-create-invitation select, #form-create-invitation textarea').removeClass('is-invalid is-valid');
                $('.error-text').text('');
                
                // Clear localStorage
                const storageKey = "form-create-invitation-data";
                localStorage.removeItem(storageKey);

                toastr.success('Form has been cleared');
            }
        });
    });
</script>

{{-- filepath: d:\Github\Laravel\SKRIPSI\skripsi-manajemen-tamu\resources\views\invitation\edit_ajax.blade.php --}}
@empty($invitation)
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
                <a href="{{ url('/invitation') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/invitation/' . $invitation->invitation_id . '/update_ajax') }}" method="POST"
        id="form-edit-invitation" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Invitation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Wedding Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_name }}" type="text" name="wedding_name"
                                id="wedding_name" class="form-control" >
                            <small id="error-wedding_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->slug }}" type="text" name="slug" id="slug"
                                class="form-control" placeholder="Auto-generated from wedding name">
                            <small class="form-text text-muted">Used for invitation URL. Must be unique.</small>
                            <small id="error-slug" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Groom Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->groom_name }}" type="text" name="groom_name" id="groom_name"
                                class="form-control" >
                            <small id="error-groom_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bride Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->bride_name }}" type="text" name="bride_name" id="bride_name"
                                class="form-control" >
                            <small id="error-bride_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    
                    <!-- Groom Details Section -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Groom Alias</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->groom_alias }}" type="text" name="groom_alias" id="groom_alias" class="form-control">
                            <small id="error-groom_alias" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Groom Image</label>
                        <div class="col-sm-9">
                            @if($invitation->groom_image)
                                <div class="mb-2">
                                    <img src="{{ asset($invitation->groom_image) }}" alt="Current Groom Image" style="max-width: 100px; max-height: 100px;">
                                    <small class="form-text text-muted d-block">Current image</small>
                                </div>
                            @endif
                            <input type="file" name="groom_image" id="groom_image" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Upload new groom photo (JPEG, PNG, JPG, WEBP, max 2MB) - leave empty to keep current</small>
                            <small id="error-groom_image" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Groom Child Number</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->groom_child_number }}" type="number" name="groom_child_number" id="groom_child_number" class="form-control" min="1">
                            <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                            <small id="error-groom_child_number" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Groom Father</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->groom_father }}" type="text" name="groom_father" id="groom_father" class="form-control">
                            <small id="error-groom_father" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Groom Mother</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->groom_mother }}" type="text" name="groom_mother" id="groom_mother" class="form-control">
                            <small id="error-groom_mother" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    
                    <!-- Bride Details Section -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bride Alias</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->bride_alias }}" type="text" name="bride_alias" id="bride_alias" class="form-control">
                            <small id="error-bride_alias" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bride Image</label>
                        <div class="col-sm-9">
                            @if($invitation->bride_image)
                                <div class="mb-2">
                                    <img src="{{ asset($invitation->bride_image) }}" alt="Current Bride Image" style="max-width: 100px; max-height: 100px;">
                                    <small class="form-text text-muted d-block">Current image</small>
                                </div>
                            @endif
                            <input type="file" name="bride_image" id="bride_image" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Upload new bride photo (JPEG, PNG, JPG, WEBP, max 2MB) - leave empty to keep current</small>
                            <small id="error-bride_image" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bride Child Number</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->bride_child_number }}" type="number" name="bride_child_number" id="bride_child_number" class="form-control" min="1">
                            <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                            <small id="error-bride_child_number" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bride Father</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->bride_father }}" type="text" name="bride_father" id="bride_father" class="form-control">
                            <small id="error-bride_father" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bride Mother</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->bride_mother }}" type="text" name="bride_mother" id="bride_mother" class="form-control">
                            <small id="error-bride_mother" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"> Date</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_date }}" type="date" name="wedding_date"
                                id="wedding_date" class="form-control" >
                            <small id="error-wedding_date" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Time Start</label>
                        <div class="col-sm-9">
                            <input value="{{ substr($invitation->wedding_time_start, 0, 5) }}" type="time"
                                name="wedding_time_start" id="wedding_time_start" class="form-control" >
                            <small id="error-wedding_time_start" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Time End</label>
                        <div class="col-sm-9">
                            <input value="{{ substr($invitation->wedding_time_end, 0, 5) }}" type="time"
                                name="wedding_time_end" id="wedding_time_end" class="form-control" >
                            <small id="error-wedding_time_end" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Venue</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_venue }}" type="text" name="wedding_venue"
                                id="wedding_venue" class="form-control" >
                            <small id="error-wedding_venue" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_location }}" type="text" name="wedding_location"
                                id="wedding_location" class="form-control" >
                            <small id="error-wedding_location" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Maps URL</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_maps }}" type="url" name="wedding_maps"
                                id="wedding_maps" class="form-control">
                            <small id="error-wedding_maps" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Wedding Image</label>
                        <div class="col-sm-9">
                            @if($invitation->wedding_image)
                                <div class="mb-2">
                                    <img src="{{ asset($invitation->wedding_image) }}" alt="Current Wedding Image" style="max-width: 100px; max-height: 100px;">
                                    <small class="form-text text-muted d-block">Current image</small>
                                </div>
                            @endif
                            <input type="file" name="wedding_image" id="wedding_image" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Upload new wedding photo (JPEG, PNG, JPG, WEBP, max 2MB) - leave empty to keep current</small>
                            <small id="error-wedding_image" class="error-text form-text text-danger"></small>
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
            $("#form-edit-invitation").validate({
                rules: {
                    wedding_name: {
                        minlength: 3,
                        maxlength: 255
                    },
                    groom_name: {
                        minlength: 3,
                        maxlength: 255
                    },
                    bride_name: {
                        minlength: 3,
                        maxlength: 255
                    },
                    groom_alias: {
                        minlength: 2,
                        maxlength: 50
                    },
                    groom_image: {
                        extension: "jpg|jpeg|png|webp"
                    },
                    groom_child_number: {
                        min: 1
                    },
                    groom_father: {
                        minlength: 3,
                        maxlength: 255
                    },
                    groom_mother: {
                        minlength: 3,
                        maxlength: 255
                    },
                    bride_alias: {
                        minlength: 2,
                        maxlength: 50
                    },
                    bride_image: {
                        extension: "jpg|jpeg|png|webp"
                    },
                    bride_child_number: {
                        min: 1
                    },
                    bride_father: {
                        minlength: 3,
                        maxlength: 255
                    },
                    bride_mother: {
                        minlength: 3,
                        maxlength: 255
                    },
                    wedding_date: {
                        date: true
                    },
                    wedding_time_start: {
                        pattern: /^([01]\d|2[0-3]):([0-5]\d)$/
                    },
                    wedding_time_end: {
                        pattern: /^([01]\d|2[0-3]):([0-5]\d)$/
                    },
                    wedding_venue: {
                        minlength: 3,
                        maxlength: 255
                    },
                    wedding_location: {
                        minlength: 3,
                        maxlength: 255
                    },
                    wedding_maps: {
                        url: true
                    },
                    wedding_image: {
                        extension: "jpg|jpeg|png|webp"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
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
                                text: 'Failed to update invitation'
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
        
        // Auto-generate slug and alias functionality (same as create form)
        $(document).ready(function() {
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
            }              // Function to update wedding name and slug
            function updateWeddingNameAndSlug() {
                const groomName = $('#groom_name').val();
                const brideName = $('#bride_name').val();
                
                console.log('Groom Name:', groomName);
                console.log('Bride Name:', brideName);
                
                if (groomName && brideName) {
                    const groomAlias = groomName.split(' ')[0];
                    const brideAlias = brideName.split(' ')[0];
                    
                    console.log('Groom Alias:', groomAlias);
                    console.log('Bride Alias:', brideAlias);
                    
                    $('#groom_alias').val(groomAlias);
                    $('#bride_alias').val(brideAlias);
                    
                    const weddingName = `${groomAlias} & ${brideAlias}`;
                    $('#wedding_name').val(weddingName);
                    
                    console.log('Wedding Name:', weddingName);
                    
                    // Auto-generate slug if slug field is empty or if it was auto-generated before
                    const currentSlug = $('#slug').val();
                    const isAutoGenerated = $('#slug').data('auto-generated');
                    
                    console.log('Current Slug:', currentSlug);
                    console.log('Is Auto Generated:', isAutoGenerated);
                    
                    if (!currentSlug || isAutoGenerated !== false) {
                        const slug = generateSlug(weddingName);
                        console.log('Generated Slug:', slug);
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
            });              // Initialize auto-generated flag for existing slug
            const existingSlug = $('#slug').val();
            if (existingSlug) {
                // Allow existing slug to be updated - mark as auto-generated initially
                $('#slug').data('auto-generated', true); 
            }
            
            // Initialize groom_alias and bride_alias from existing data
            const initialGroomName = $('#groom_name').val();
            const initialBrideName = $('#bride_name').val();
            if (initialGroomName) {
                $('#groom_alias').val(initialGroomName.split(' ')[0]);
            }
            if (initialBrideName) {
                $('#bride_alias').val(initialBrideName.split(' ')[0]);
            }
        });
    </script>
@endempty
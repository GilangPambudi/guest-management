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
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Wedding Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_name }}" type="text" name="wedding_name"
                                id="wedding_name" class="form-control" required>
                            <small id="error-wedding_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Groom Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->groom_name }}" type="text" name="groom_name" id="groom_name"
                                class="form-control" required>
                            <small id="error-groom_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bride Name</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->bride_name }}" type="text" name="bride_name" id="bride_name"
                                class="form-control" required>
                            <small id="error-bride_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"> Date</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_date }}" type="date" name="wedding_date"
                                id="wedding_date" class="form-control" required>
                            <small id="error-wedding_date" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Time Start</label>
                        <div class="col-sm-9">
                            <input value="{{ substr($invitation->wedding_time_start, 0, 5) }}" type="time"
                                name="wedding_time_start" id="wedding_time_start" class="form-control" required>
                            <small id="error-wedding_time_start" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Time End</label>
                        <div class="col-sm-9">
                            <input value="{{ substr($invitation->wedding_time_end, 0, 5) }}" type="time"
                                name="wedding_time_end" id="wedding_time_end" class="form-control" required>
                            <small id="error-wedding_time_end" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Venue</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_venue }}" type="text" name="wedding_venue"
                                id="wedding_venue" class="form-control" required>
                            <small id="error-wedding_venue" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Location</label>
                        <div class="col-sm-9">
                            <input value="{{ $invitation->wedding_location }}" type="text" name="wedding_location"
                                id="wedding_location" class="form-control" required>
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
                        <label class="col-sm-3 col-form-label">New Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="wedding_image" id="wedding_image" class="form-control">
                            <small id="error-wedding_image" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wedding_image" class="col-sm-3 col-form-label">Old Image</label>
                        <div class="col-sm-8">
                            @if ($invitation->wedding_image)
                                <div class="spoiler">
                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target="#weddingImageSpoiler" aria-expanded="false" aria-controls="weddingImageSpoiler">
                                        Show Image
                                    </button>
                                    <div class="collapse mt-2" id="weddingImageSpoiler">
                                        <img src="{{ asset($invitation->wedding_image) }}" alt="Wedding Image" class="img-fluid">
                                    </div>
                                </div>
                            @else
                                <p>No image available</p>
                            @endif
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
                        required: true,
                        date: true
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
                        extension: "jpg|jpeg|png|gif"
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
    </script>
@endempty
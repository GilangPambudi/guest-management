<form action="{{ url('/invitation/' . $invitation->invitation_id . '/guests/import_process') }}" method="POST"
    id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Guests - {{ $invitation->wedding_name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="icon fas fa-info"></i> Information</h6>
                    Importing guests for: <strong>{{ $invitation->groom_name }} &
                        {{ $invitation->bride_name }}</strong><br>
                    Wedding Date: {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d F Y') }}<br>
                    Venue: {{ $invitation->wedding_venue }}
                </div>

                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ url('/invitation/' . $invitation->invitation_id . '/guests/template') }}"
                        class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download Template
                    </a>
                    <small class="form-text text-muted">Download the Excel template first before importing. The template includes sample data format.</small>
                </div>

                <div class="form-group">
                    <label>Select File</label>
                    <input type="file" name="file_guests" id="file_guests" class="form-control" required
                        accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    <small id="error-file_guests" class="error-text form-text text-danger"></small>
                    <small class="form-text text-muted">Only Excel files (.xlsx, .xls) are allowed. QR codes will be automatically generated for each guest.</small>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="icon fas fa-exclamation-triangle"></i> Important Notes</h6>
                    <ul class="mb-0">
                        <li>Make sure the Excel file follows the template format</li>
                        <li>Contact numbers must be unique</li>
                        <li>QR codes will be automatically generated for each imported guest</li>
                        <li>Default attendance status will be set to "-" (Not Set)</li>
                        <li>Default invitation status will be set to "-" (Not Set)</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-upload"></i> Upload & Import
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Add custom validation method
        $.validator.addMethod("excelFile", function(value, element) {
            if (this.optional(element)) {
                return true;
            }
            var extension = value.split('.').pop().toLowerCase();
            return extension === 'xlsx' || extension === 'xls';
        }, "Please upload a valid Excel file (.xlsx or .xls)");

        $("#form-import").validate({
            rules: {
                file_guests: {
                    required: true,
                    excelFile: true
                },
            },
            messages: {
                file_guests: {
                    required: "Please select a file to upload"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);

                // Tampilkan SweetAlert loading
                Swal.fire({
                    title: 'Processing Import...',
                    html: 'Please wait while we process your file and generate QR codes.<br><small>This may take a few moments...</small>',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    timeout: 300000, // 5 minutes timeout for large files
                    success: function(response) {
                        // Tutup SweetAlert loading
                        Swal.close();

                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Import Successful',
                                html: response.message + '<br><small>QR codes have been generated for all guests</small>',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (response.refresh) {
                                        dataGuest.ajax.reload();
                                    }
                                    $('#myModal').modal('hide');
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Import Failed',
                                text: response.message
                            });
                            $('.error-text').text('');
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        // Tutup SweetAlert loading jika terjadi error
                        Swal.close();
                        let errorMessage = 'An error occurred during the import process.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 0) {
                            errorMessage = 'Request timeout. Please check your file size and try again.';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Import Error',
                            text: errorMessage
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
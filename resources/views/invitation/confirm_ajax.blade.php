{{-- filepath: d:\Github\Laravel\SKRIPSI\skripsi-manajemen-tamu\resources\views\invitation\confirm_ajax.blade.php --}}
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
    <form action="{{ url('/invitation/' . $invitation->invitation_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Invitation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Confirmation!!!</h5>
                        Do you want to delete this invitation?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Wedding Name:</th>
                            <td class="col-9">{{ $invitation->wedding_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Groom Name:</th>
                            <td class="col-9">{{ $invitation->groom_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Bride Name:</th>
                            <td class="col-9">{{ $invitation->bride_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Wedding Date:</th>
                            <td class="col-9">{{ $invitation->wedding_date }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Wedding Venue:</th>
                            <td class="col-9">{{ $invitation->wedding_venue }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.success) {
                                $('#myModal').modal('hide');
                                toastr.success('Invitation successfully deleted', 'Success', {
                                    positionClass: 'toast-bottom-right'
                                });
                                $('#invitation-table').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message, 'Error', {
                                    positionClass: 'toast-bottom-right'
                                });
                            }
                        },
                        error: function(response) {
                            toastr.error('Failed to delete invitation', 'Error', {
                                positionClass: 'toast-bottom-right'
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
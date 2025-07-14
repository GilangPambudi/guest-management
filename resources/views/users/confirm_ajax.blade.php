<form action="{{ url('/users/' . $user->user_id . '/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-ban"></i> Confirm Delete!</h5>
                    Are you sure you want to delete this user data?
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">User ID :</th>
                        <td class="col-9">{{ $user->user_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Name :</th>
                        <td class="col-9">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Email :</th>
                        <td class="col-9">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Role :</th>
                        <td class="col-9">
                            @if($user->role === 'admin')
                                <span class="badge badge-success">Admin</span>
                            @else
                                <span class="badge badge-secondary">User</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Created At :</th>
                        <td class="col-9">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-delete").validate({
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#users-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong!',
                        });
                    }
                });
                return false;
            }
        });
    });
</script>

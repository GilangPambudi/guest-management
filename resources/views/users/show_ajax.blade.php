<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">User Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
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
                    <th class="text-right col-3">Email Verified :</th>
                    <td class="col-9">
                        @if($user->email_verified_at)
                            <span class="badge badge-success">Verified</span>
                            <br>
                            <small class="text-muted">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                        @else
                            <span class="badge badge-warning">Not Verified</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Created At :</th>
                    <td class="col-9">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Updated At :</th>
                    <td class="col-9">{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
        </div>
    </div>
</div>

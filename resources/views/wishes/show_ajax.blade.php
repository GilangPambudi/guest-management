@empty($wish)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Error!!!</h5>
                    The data you are looking for was not found
                </div>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Wedding Wish Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th class="text-right col-3">Guest Name:</th>
                                <td class="col-9">{{ $wish->guest->guest_name }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Wedding Wish:</th>
                                <td>
                                    <div class="wish-message">
                                        "{{ $wish->message }}"
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="deleteWish('{{ $wish->wish_id }}')" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Wish
                </button>
            </div>
        </div>
    </div>

    <script>
        function deleteWish(wishId) {
            Swal.fire({
                title: 'Delete Wedding Wish?',
                text: 'Are you sure you want to delete this wedding wish? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the wish.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/wishes/${wishId}/delete_ajax`,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                
                                $('#myModal').modal('hide');
                                
                                if (typeof dataWishes !== 'undefined') {
                                    dataWishes.ajax.reload();
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message || 'Failed to delete wish'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'Something went wrong. Please try again.';
                            
                            try {
                                const errorResponse = JSON.parse(xhr.responseText);
                                errorMessage = errorResponse.message || errorMessage;
                            } catch (e) {
                                // Use default error message
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        }
                    });
                }
            });
        }
    </script>

    <style>
        .wish-message {
            font-style: italic;
            font-size: 1.1em;
            line-height: 1.6;
            color: #495057;
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #007bff;
            border-radius: 5px;
        }
    </style>
@endempty
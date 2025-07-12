@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/gifts') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <a href="{{ url('/invitation/' . $invitation->invitation_id . '/guests') }}" class="btn btn-info">
                    <i class="fa fa-users"></i> Manage Guests
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Wedding Info -->
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Wedding Information</h5>
                        <strong>{{ $invitation->wedding_name }}</strong><br>
                        {{ $invitation->groom_name }} & {{ $invitation->bride_name }}<br>
                        {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d F Y') }} at
                        {{ $invitation->wedding_venue }}
                    </div>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="alert alert-success">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5><i class="icon fas fa-gift"></i> Gift Payment Log Information</h5>
                                <p class="mb-0">
                                    <strong>Real-time Dashboard:</strong> This page displays all payment transactions made
                                    by guests for wedding gifts.<br>
                                    <strong>Direct from Midtrans:</strong> All data is synchronized directly from payment
                                    gateway without manual intervention.<br>
                                    <small class="text-warning"><i class="fa fa-exclamation-triangle"></i>
                                        <strong>Important:</strong> If status not synchronized, use "Sync All" button to
                                        update from Midtrans.</small>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-warning btn-sm mr-1" onclick="syncAllStatus()"
                                    title="Sync all payment statuses from Midtrans">
                                    <i class="fa fa-sync-alt"></i> Sync All
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="autoExpirePayments()"
                                    title="Auto-expire payments older than 3 hours">
                                    <i class="fa fa-clock"></i> Auto Expire
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Payments and Amount -->
            <div class="row">
                <div class="col-md-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 id="totalPayments">0</h3>
                            <p>Total Transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="totalAmount">Rp 0</h3>
                            <p>Total Amount</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money-bill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="successfulPayments">0</h3>
                            <p>Successful</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="pendingPayments">0</h3>
                            <p>Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="failedPayments">0</h3>
                            <p>Failed/Cancelled</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2 d-flex justify-content-end">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-toggle="collapse"
                                data-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                <i class="fas fa-filter"></i> Filters
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                        </div>
                        <div class="collapse" id="filterCollapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="statusFilter" class="form-label">Payment Status:</label>
                                        <select id="statusFilter" class="form-control">
                                            <option value="">All Status</option>
                                            @foreach ($paymentStatuses as $status)
                                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="paymentTypeFilter" class="form-label">Payment Method:</label>
                                        <select id="paymentTypeFilter" class="form-control">
                                            <option value="">All Methods</option>
                                            @foreach ($paymentTypes as $type)
                                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button id="apply-filters" class="btn btn-primary btn-sm mr-1">
                                            <i class="fas fa-search"></i> Apply Filters
                                        </button>
                                        <button id="reset-filters" class="btn btn-warning btn-sm mr-1">
                                            <i class="fa fa-sync"></i> Reset Filters
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm" onclick="syncAllStatus()"
                                            title="Sync all payment statuses from Midtrans">
                                            <i class="fa fa-sync-alt"></i> Sync All
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Data Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Payment Transactions</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="paymentsTable" class="table table-bordered table-striped text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Guest Name</th>
                                            <th>Category</th>
                                            <th>Amount</th>
                                            <th>Order ID</th>
                                            <th>Status</th>
                                            <th>Payment Method</th>
                                            <th>Created</th>
                                            <th>Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Will be populated via DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Detail Modal -->
    <div class="modal fade" id="paymentDetailModal" tabindex="-1" role="dialog"
        aria-labelledby="paymentDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentDetailModalLabel">Payment Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="paymentDetailContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const invitationId = {{ $invitation->invitation_id }};
        let paymentsTable;

        $(document).ready(function() {
            // Initialize DataTable
            const paymentsTable = $('#paymentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/gifts/${invitationId}/data`,
                    data: function(d) {
                        d.status = $('#statusFilter').val();
                        d.payment_type = $('#paymentTypeFilter').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'guest_name',
                        name: 'guests.guest_name',
                        className: 'nowrap',
                        searchable: true,
                        render: function(data) {
                            return data || 'Unknown Guest';
                        }
                    },
                    {
                        data: 'guest_category',
                        name: 'guests.guest_category',
                        className: 'nowrap',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'formatted_amount',
                        name: 'payments.gross_amount',
                        className: 'nowrap'
                    },
                    {
                        data: 'order_id',
                        name: 'payments.order_id',
                        className: 'nowrap',
                    },
                    {
                        data: 'status_badge',
                        name: 'payments.transaction_status',
                        className: 'nowrap',
                    },
                    {
                        data: 'payment_method',
                        name: 'payments.payment_type',
                        className: 'nowrap',
                    },
                    {
                        data: 'transaction_time',
                        name: 'payments.created_at'
                    },
                    {
                        data: 'updated_time',
                        name: 'payments.updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [8, 'desc']
                ], // Order by created_at desc
                drawCallback: function() {
                    // Refresh summary when table redraws (optional, might be too frequent)
                    // loadSummary();
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin"></i> Loading payments...'
                }
            });

            // Filter event handlers - Update to use Apply Filters button
            $('#apply-filters').on('click', function() {
                paymentsTable.draw();
                // Reload summary after filter change
                setTimeout(loadSummary, 500); // Small delay to ensure table is updated

                toastr.options = {
                    "positionClass": "toast-bottom-right",
                };
                toastr.info('Filters have been applied');
            });

            // Reset filters
            $('#reset-filters').on('click', function() {
                $('#statusFilter').val('');
                $('#paymentTypeFilter').val('');
                paymentsTable.draw();
                setTimeout(loadSummary, 500);

                toastr.options = {
                    "positionClass": "toast-bottom-right",
                };
                toastr.info('Filters have been reset');
            });

            // Optional: Still allow immediate filtering on change (remove if you only want Apply button)
            $('#statusFilter, #paymentTypeFilter').on('change', function() {
                paymentsTable.draw();
                setTimeout(loadSummary, 500);
            });

            // Load initial summary
            loadSummary();
        });

        function showPaymentDetail(paymentId) {
            $.get(`{{ url('/gifts/payment') }}/${paymentId}/detail`, function(data) {
                let content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Basic Information</strong></h6>
                            <table class="table table-sm">
                                <tr><td><strong>Order ID:</strong></td><td>${data.order_id}</td></tr>
                                <tr><td><strong>Guest:</strong></td><td>${data.guest ? data.guest.guest_name : 'Unknown'}</td></tr>
                                <tr><td><strong>Amount:</strong></td><td>Rp ${data.gross_amount.toLocaleString('id-ID')}</td></tr>
                                <tr><td><strong>Status:</strong></td><td><span class="badge badge-${getStatusBadgeClass(data.transaction_status)}">${data.transaction_status}</span></td></tr>
                                <tr><td><strong>Payment Type:</strong></td><td>${data.payment_type || 'Not Set'}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Timestamps</strong></h6>
                            <table class="table table-sm">
                                <tr><td><strong>Created:</strong></td><td>${new Date(data.created_at).toLocaleString('id-ID')}</td></tr>
                                <tr><td><strong>Updated:</strong></td><td>${new Date(data.updated_at).toLocaleString('id-ID')}</td></tr>
                                <tr><td><strong>Payment Status:</strong></td><td>${data.payment_status || 'Not Set'}</td></tr>
                                <tr><td><strong>Snap Token:</strong></td><td>${data.snap_token ? 'Generated' : 'Not Generated'}</td></tr>
                            </table>
                        </div>
                    </div>
                `;

                if (data.midtrans_response) {
                    content += `
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6><strong>Midtrans Response</strong></h6>
                                <pre class="bg-light p-3" style="max-height: 300px; overflow-y: auto;">${JSON.stringify(data.midtrans_response, null, 2)}</pre>
                            </div>
                        </div>
                    `;
                }

                $('#paymentDetailContent').html(content);
                $('#paymentDetailModal').modal('show');
            }).fail(function() {
                Swal.fire('Error!', 'Failed to load payment details', 'error');
            });
        }

        function getStatusBadgeClass(status) {
            switch (status) {
                case 'settlement':
                    return 'success';
                case 'pending':
                    return 'warning';
                case 'cancel':
                case 'expire':
                    return 'danger';
                case 'deny':
                    return 'secondary';
                default:
                    return 'info';
            }
        }

        // Sync Functions
        function syncAllStatus() {
            Swal.fire({
                title: 'Sync All Payments?',
                text: 'This will check and update status for ALL payments from Midtrans. This may take a while.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, sync now!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performSync();
                }
            });
        }

        function performSync() {
            const url = `{{ url('/gifts/' . $invitation->invitation_id . '/sync-all-status') }}`;

            // Show loading
            Swal.fire({
                title: 'Syncing...',
                text: 'Please wait while we sync all payment statuses from Midtrans',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post(url, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }).done(function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sync Completed!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // Refresh table and summary
                    reloadTable();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            }).fail(function(xhr) {
                const response = xhr.responseJSON;
                Swal.fire('Error!', response?.message || 'Sync failed', 'error');
            });
        }

        function autoExpirePayments() {
            Swal.fire({
                title: 'Auto Expire Payments?',
                text: 'This will expire all pending payments older than 3 hours.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6c757d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, expire old payments!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAutoExpire();
                }
            });
        }

        function performAutoExpire() {
            const url = `{{ url('/gifts/' . $invitation->invitation_id . '/auto-expire') }}`;

            // Show loading
            Swal.fire({
                title: 'Processing...',
                text: 'Checking and expiring old payments',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post(url, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }).done(function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Auto Expire Completed!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // Refresh table and summary
                    reloadTable();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            }).fail(function(xhr) {
                const response = xhr.responseJSON;
                Swal.fire('Error!', response?.message || 'Auto expire failed', 'error');
            });
        }

        function checkSingleStatus(paymentId) {
            // Show loading
            Swal.fire({
                title: 'Checking...',
                text: 'Checking payment status from Midtrans',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post(`{{ url('/gifts/payment') }}/${paymentId}/check-status`, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }).done(function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated!',
                        text: `Status changed from "${response.old_status}" to "${response.new_status}"`,
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // Refresh table and summary
                    reloadTable();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            }).fail(function(xhr) {
                const response = xhr.responseJSON;
                Swal.fire('Error!', response?.message || 'Check failed', 'error');
            });
        }

        function reloadTable() {
            // Reload DataTable
            $('#paymentsTable').DataTable().ajax.reload(function() {
                // Reload summary after table is refreshed
                loadSummary();
            }, false); // false = keep current page
        }

        function loadSummary() {
            $.get(`{{ url('/gifts/' . $invitation->invitation_id . '/summary') }}`, function(data) {
                $('#totalPayments').text(data.total_payments);
                $('#successfulPayments').text(data.successful_payments);
                $('#pendingPayments').text(data.pending_payments);
                $('#failedPayments').text(data.failed_payments);
                $('#totalAmount').text('Rp ' + data.total_amount.toLocaleString('id-ID'));
                $('#averageAmount').text('Rp ' + Math.round(data.average_amount).toLocaleString('id-ID'));
            }).fail(function() {
                console.log('Failed to load summary data');
                toastr.error('Failed to load summary data');
            });
        }

        // Remove duplicate updateSummary function - use loadSummary instead
    </script>
@endsection

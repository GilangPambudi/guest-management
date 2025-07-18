@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-heart mr-1"></i>
                Wedding Wishes Management
                @if(isset($invitation))
                    - {{ $invitation->wedding_name }}
                @endif
            </h3>
            <div class="card-tools">
                @if(isset($invitation))
                    <a href="{{ route('wishes.select') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Select
                    </a>
                    <a href="{{ url('/invitation/' . $invitation->invitation_id . '/show') }}" class="btn btn-info">
                        <i class="fa fa-eye"></i> View Invitation
                    </a>
                @endif
                <button id="refresh-table" class="btn btn-info">
                    <i class="fa fa-sync"></i> Refresh
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Wedding Information Cards -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row">
                        <!-- Card 1: Nama Pengantin -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #f8fafc 60%, #f3e8ff 100%); border: none;">
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <h5 class="mb-1 font-weight-bold text-primary" style="font-size: 1.2rem;">
                                        {{ $invitation->groom_name }}  
                                    </h5>
                                    <h5 class="mb-1 font-weight-bold" style="font-size: 1.2rem; color: #e75480;">
                                        <i class="fa fa-heart mx-1"></i>
                                    </h5>
                                    <h5 class="mb-1 font-weight-bold text-pink" style="font-size: 1.2rem; color: #d63384;">
                                        {{ $invitation->bride_name }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2: Tanggal -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #f8fafc 60%, #ffe5ec 100%); border: none;">
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa fa-calendar fa-2x mb-2" style="color: #a370f7;"></i>
                                    <div class="font-weight-bold text-secondary">Tanggal</div>
                                    <div class="text-dark">
                                        {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3: Waktu -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #f8fafc 60%, #e0f7fa 100%); border: none;">
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa fa-clock fa-2x mb-2" style="color: #00bcd4;"></i>
                                    <div class="font-weight-bold text-secondary">Waktu</div>
                                    <div class="text-dark">
                                        {{ \Carbon\Carbon::parse($invitation->wedding_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($invitation->wedding_time_end)->format('H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card 4: Tempat -->
                        <div class="col-md-3 mb-2">
                            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #f8fafc 60%, #fff3cd 100%); border: none;">
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa fa-map-marker-alt fa-2x mb-2" style="color: #ffc107;"></i>
                                    <div class="font-weight-bold text-secondary">Tempat</div>
                                    <div class="text-dark">
                                        {{ $invitation->wedding_venue }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Row -->
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
                                        <label for="filter-date-range" class="form-label">Date Range:</label>
                                        <input type="text" id="filter-date-range" class="form-control" placeholder="Select date range">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="filter-guest-category" class="form-label">Guest Category:</label>
                                        <select id="filter-guest-category" class="form-control">
                                            <option value="">All Categories</option>
                                            <option value="Family">Family</option>
                                            <option value="Friends">Friends</option>
                                            <option value="Colleagues">Colleagues</option>
                                            <option value="VIP">VIP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button id="apply-filters" class="btn btn-primary btn-sm mr-1">
                                            <i class="fas fa-search"></i> Apply Filters
                                        </button>
                                        <button id="reset-filters" class="btn btn-warning btn-sm">
                                            <i class="fa fa-sync"></i> Reset Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions Row -->
            <div class="row mb-3" id="bulk-actions" style="display: none;">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong id="selected-count">0</strong> wish(es) selected
                            </div>
                            <div>
                                <button id="clear-selection" class="btn btn-primary btn-sm">
                                    <i class="fas fa-times"></i> Cancel Action
                                </button>
                                <button id="bulk-delete" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete Selected
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-sm table-hover table-striped text-nowrap" id="wishes-table">
                <thead>
                    <tr>
                        <th width="30px">
                            <input type="checkbox" id="select-all" title="Select All">
                        </th>
                        <th>No</th>
                        @if(!isset($invitation))
                            <th>Invitation</th>
                        @endif
                        <th>Guest Name</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <!-- Konten modal akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataWishes;
        var selectedWishes = [];

        function updateBulkActions() {
            var selectedCount = selectedWishes.length;
            $('#selected-count').text(selectedCount);

            if (selectedCount > 0) {
                $('#bulk-actions').show();
            } else {
                $('#bulk-actions').hide();
            }
        }

        function handleCheckboxChange() {
            selectedWishes = [];

            $('#wishes-table tbody').find('input[name="wish_ids[]"]:checked').each(function() {
                var wishId = $(this).val();
                if (wishId && selectedWishes.indexOf(wishId) === -1) {
                    selectedWishes.push(wishId);
                }
            });

            updateBulkActions();
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Update AJAX URLs to include invitation_id if present
            @if(isset($invitation))
                const invitationId = {{ $invitation->invitation_id }};
                const listUrl = "{{ url('/wishes/invitation/' . $invitation->invitation_id . '/list') }}";
            @else
                const listUrl = "{{ url('wishes/list') }}";
            @endif

            // Initialize DataTable
            dataWishes = $('#wishes-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: listUrl,
                    type: "POST",
                    data: function(d) {
                        d.date_range = $('#filter-date-range').val();
                        d.guest_category = $('#filter-guest-category').val();
                    },
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', xhr.responseText);
                        toastr.error('Failed to load wishes data. Please refresh the page.');
                    }
                },
                columns: [{
                        data: 'wish_id',
                        name: 'wish_id',
                        orderable: false,
                        searchable: false,
                        width: '30px',
                        render: function(data, type, row) {
                            return '<input type="checkbox" name="wish_ids[]" value="' + data +
                                '" class="wish-checkbox">';
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '50px'
                    },
                    @if(!isset($invitation))
                    {
                        data: 'invitation_info',
                        name: 'invitation_info',
                        className: 'text-nowrap'
                    },
                    @endif
                    {
                        data: 'guest_info',
                        name: 'guest_info',
                        className: 'text-nowrap'
                    },
                    {
                        data: 'message_preview',
                        name: 'message',
                        className: 'text-wrap'
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at',
                        className: 'text-nowrap'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center text-nowrap'
                    },
                ],
                order: [
                    [@if(isset($invitation)) 4 @else 5 @endif, 'desc']
                ], // Order by created_at desc
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                drawCallback: function() {
                    handleCheckboxChange();

                    var visibleCheckboxes = $('#wishes-table tbody').find('.wish-checkbox');
                    var visibleCheckedCheckboxes = $('#wishes-table tbody').find('.wish-checkbox:checked');

                    $('#select-all').prop('checked',
                        visibleCheckboxes.length > 0 && visibleCheckboxes.length === visibleCheckedCheckboxes.length
                    );
                }
            });

            // Select All checkbox
            $(document).on('change', '#select-all', function() {
                var isChecked = $(this).is(':checked');
                var visibleCheckboxes = $('#wishes-table tbody').find('.wish-checkbox');
                visibleCheckboxes.prop('checked', isChecked);
                handleCheckboxChange();
            });

            // Individual checkbox change
            $(document).on('change', '.wish-checkbox', function() {
                handleCheckboxChange();

                var visibleCheckboxes = $('#wishes-table tbody').find('.wish-checkbox');
                var visibleCheckedCheckboxes = $('#wishes-table tbody').find('.wish-checkbox:checked');

                $('#select-all').prop('checked',
                    visibleCheckboxes.length > 0 && visibleCheckboxes.length === visibleCheckedCheckboxes.length
                );
            });

            // Clear selection
            $(document).on('click', '#clear-selection', function() {
                $('#wishes-table tbody').find('.wish-checkbox').prop('checked', false);
                $('#select-all').prop('checked', false);
                selectedWishes = [];
                updateBulkActions();
            });

            // Bulk delete
            $(document).on('click', '#bulk-delete', function() {
                if (selectedWishes.length === 0) {
                    toastr.warning('Please select wishes to delete');
                    return;
                }

                Swal.fire({
                    title: 'Delete Selected Wishes?',
                    text: `Are you sure you want to delete ${selectedWishes.length} selected wish(es)? This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkAction('delete', selectedWishes);
                    }
                });
            });

            // Filter event handlers
            $('#apply-filters').click(function() {
                dataWishes.draw();
                $('#clear-selection').click();
            });

            // Reset filters
            $(document).on('click', '#reset-filters', function() {
                $('#filter-date-range').val('');
                $('#filter-guest-category').val('');
                dataWishes.draw();
                $('#clear-selection').click();

                toastr.info('Filters have been reset');
            });

            // Refresh table
            $('#refresh-table').click(function() {
                dataWishes.ajax.reload();
                toastr.success('Table refreshed');
            });

            // Reload DataTable when modal is closed (after delete)
            $('#myModal').on('hidden.bs.modal', function() {
                dataWishes.ajax.reload();
            });
        });

        function bulkAction(action, wishIds) {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "/wishes/bulk-action",
                type: 'POST',
                data: {
                    action: action,
                    wish_ids: wishIds,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#clear-selection').click();
                        if (response.refresh) {
                            setTimeout(function() {
                                dataWishes.ajax.reload();
                            }, 500);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'An error occurred'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('Bulk action error:', xhr.responseText);

                    var errorMessage = 'Failed to process bulk action';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        }
    </script>
@endsection
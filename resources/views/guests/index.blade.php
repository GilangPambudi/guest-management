@extends('layouts.template')

@section('content')
    <style>
        /* Debug pagination clicks */
        .dataTables_paginate .paginate_button {
            pointer-events: auto !important;
            position: relative !important;
            z-index: 1 !important;
        }
        .dataTables_paginate .paginate_button.disabled {
            pointer-events: none !important;
        }
        /* Ensure table wrapper doesn't interfere */
        .table-responsive {
            overflow-x: visible !important;
        }
        /* Custom table scroll that doesn't break pagination */
        .custom-datatable-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling di mobile */
        }
        .custom-datatable-wrapper table {
            min-width: 1200px; /* Pastikan table punya min-width yang cukup */
            white-space: nowrap; /* Prevent text wrapping */
        }
        /* Ensure table content doesn't wrap */
        #guest-table {
            min-width: 1200px;
            white-space: nowrap;
        }
        #guest-table td, #guest-table th {
            white-space: nowrap;
        }
        /* Hilangkan responsive controls DataTables */
        .dtr-control {
            display: none !important;
        }
        .dtr-details {
            display: none !important;
        }
        /* Pastikan pagination tidak terpotong */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 15px;
            clear: both;
        }
        /* DataTables horizontal scroll styling */
        .dataTables_wrapper .dataTables_scroll {
            clear: both;
        }
        .dataTables_wrapper .dataTables_scrollBody {
            border: 1px solid #dee2e6;
        }
        /* Smooth scrolling */
        .dataTables_scrollBody {
            -webkit-overflow-scrolling: touch;
        }
        /* Prevent badge wrapping */
        .badge {
            white-space: nowrap;
        }
    </style>
    <div class="card card-outline card-primary">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('/invitation/' . $invitation->invitation_id . '/show') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Detail
                </a>
                <button id="scanner" class="btn btn-info"
                    onclick="window.location.href='{{ url('/invitation/' . $invitation->invitation_id . '/scanner') }}'">
                    <i class="fa fa-qrcode"></i> QR Scanner
                </button>
                <button onclick="modalAction('{{ url('/invitation/' . $invitation->invitation_id . '/guests/import') }}')"
                    class="btn btn-success">
                    <i class="fa fa-upload"></i> Import Guests
                </button>
                <button
                    onclick="modalAction('{{ url('/invitation/' . $invitation->invitation_id . '/guests/create_ajax') }}')"
                    class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Add Guest
                </button>
            </div>
        </div>

        <div class="card-body">
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
                                    <div class="col-md-3">
                                        <label for="filter-category" class="form-label">Category Filter:</label>
                                        <select id="filter-category" class="form-control">
                                            <option value="">All Categories</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter-gender" class="form-label">Gender Filter:</label>
                                        <select id="filter-gender" class="form-control">
                                            <option value="">All Genders</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter-attendance-status" class="form-label">Attendance Status:</label>
                                        <select id="filter-attendance-status" class="form-control">
                                            <option value="">All Status</option>
                                            @foreach ($attendanceStatuses as $status)
                                                <option value="{{ $status }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter-invitation-status" class="form-label">Invitation Status:</label>
                                        <select id="filter-invitation-status" class="form-control">
                                            <option value="">All Status</option>
                                            @foreach ($invitationStatuses as $status)
                                                <option value="{{ $status }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3 ">
                                    <div class="col-md-12 d-flex justify-content-end ">
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
                                <strong id="selected-count">0</strong> guest(s) selected
                            </div>
                            <div>
                                <button id="bulk-send-wa" class="btn btn-success btn-sm">
                                    <i class="fab fa-whatsapp"></i> Send Invitation via WA
                                </button>
                                {{-- <button id="bulk-mark-sent" class="btn btn-success btn-sm">
                                    <i class="fas fa-paper-plane"></i> Mark as Sent
                                </button>
                                <button id="bulk-mark-pending" class="btn btn-info btn-sm">
                                    <i class="fas fa-clock"></i> Mark as Pending
                                </button> --}}
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

            <table class="table table-bordered table-sm table-hover table-striped" id="guest-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all" title="Select All">
                        </th>
                        <th>No</th>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Category</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Invitation Status</th>
                        <th>RSVP</th>
                        <th>Arrival Time</th>
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

        function copyToClipboard(text) {
            // Modern approach using Clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    toastr.options = {
                        "positionClass": "toast-top-center",
                    };
                    toastr.success('QR Code ID copied to clipboard!');
                }).catch(function(err) {
                    // Fallback method
                    fallbackCopyTextToClipboard(text);
                });
            } else {
                // Fallback method for older browsers
                fallbackCopyTextToClipboard(text);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            var tempInput = document.createElement("input");
            tempInput.style.position = "absolute";
            tempInput.style.left = "-9999px";
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            toastr.options = {
                "positionClass": "toast-bottom-right",
            };
            toastr.success('QR Code ID copied to clipboard!');
        }

        var dataGuest;
        var selectedGuests = [];

        function updateBulkActions() {
            var selectedCount = selectedGuests.length;
            $('#selected-count').text(selectedCount);

            if (selectedCount > 0) {
                $('#bulk-actions').show();
            } else {
                $('#bulk-actions').hide();
            }
        }

        function handleCheckboxChange() {
            selectedGuests = [];

            // Only count visible and checked checkboxes in current page
            $('#guest-table tbody').find('input[name="guest_ids[]"]:checked').each(function() {
                var guestId = $(this).val();
                if (guestId && selectedGuests.indexOf(guestId) === -1) {
                    selectedGuests.push(guestId);
                }
            });

            updateBulkActions();
        }

        // Removed problematic DOM manipulation that was breaking DataTables pagination
        // DataTables handles responsive behavior internally


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            dataGuest = $('#guest-table').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                responsive: false, // Disable responsive untuk scroll horizontal
                paging: true,
                info: true,
                searching: true,
                ordering: true,
                scrollX: true, // Enable horizontal scrolling
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                ajax: {
                    url: "{{ url('/invitation/' . $invitation->invitation_id . '/guests/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.category = $('#filter-category').val();
                        d.gender = $('#filter-gender').val();
                        d.attendance_status = $('#filter-attendance-status').val();
                        d.invitation_status = $('#filter-invitation-status').val();
                        console.log('DataTables sending data:', d); // Debug log
                    },
                    error: function(xhr, error, code) {
                        console.error('DataTable AJAX Error:', xhr.responseText);
                        console.error('Error Code:', code);
                        toastr.error('Failed to load guests data. Please refresh the page.');
                    },
                    complete: function(xhr, status) {
                        console.log('DataTables AJAX complete:', status); // Debug log
                        console.log('Response:', xhr.responseText.substring(0, 200)); // First 200 chars
                    }
                },
                columns: [{
                        data: 'guest_id',
                        name: 'guest_id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<input type="checkbox" name="guest_ids[]" value="' + data +
                                '" class="guest-checkbox">';
                        }
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'guest_name',
                        name: 'guest_name',
                        orderable: true
                    },
                    {
                        data: 'guest_gender',
                        name: 'guest_gender',
                        orderable: false
                    },
                    {
                        data: 'guest_category',
                        name: 'guest_category',
                        orderable: false
                    },
                    {
                        data: 'guest_contact',
                        name: 'guest_contact',
                        orderable: false
                    },
                    {
                        data: 'guest_address',
                        name: 'guest_address',
                        render: function(data, type, row) {
                            return data && data.length > 30 ?
                                '<span title="' + data + '">' + data.substr(0, 30) + '...</span>' :
                                data;
                        },
                        orderable: false
                    },
                    {
                        data: 'guest_invitation_status',
                        name: 'guest_invitation_status',
                        render: function(data, type, row) {
                            if (data === 'Sent') {
                                return '<span class="badge badge-success" title="Invitation sent via WhatsApp">' +
                                    data + '</span>';
                            } else if (data === 'Opened') {
                                return '<span class="badge badge-info" title="Guest has opened the invitation">' +
                                    data + '</span>';
                            } else if (data === 'Pending') {
                                return '<span class="badge badge-warning" title="Invitation pending">' +
                                    data + '</span>';
                            } else {
                                return '<span class="badge badge-secondary" title="Invitation not sent">' +
                                    data + '</span>';
                            }
                        },
                        orderable: false
                    },
                    {
                        data: 'guest_attendance_status',
                        name: 'guest_attendance_status',
                        render: function(data, type, row) {
                            if (data === 'Yes') {
                                return '<span class="badge badge-success">' + data + '</span>';
                            } else if (data === 'No') {
                                return '<span class="badge badge-danger">' + data + '</span>';
                            } else {
                                return '<span class="badge badge-secondary">' + data + '</span>';
                            }
                        },
                        orderable: false
                    }, {
                        data: 'guest_arrival_time',
                        name: 'guest_arrival_time',
                        render: function(data, type, row) {
                            if (data && data !== '-') {
                                return data;
                            }
                            return '-';
                        },
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
                order: [
                    [2, 'asc']
                ], // Order by guest name
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                drawCallback: function() {
                    // Update bulk actions after redraw
                    handleCheckboxChange();

                    // Reset select-all checkbox state based on current visible selection
                    var visibleCheckboxes = $('#guest-table tbody').find('.guest-checkbox');
                    var visibleCheckedCheckboxes = $('#guest-table tbody').find(
                        '.guest-checkbox:checked');

                    $('#select-all').prop('checked',
                        visibleCheckboxes.length > 0 && visibleCheckboxes.length ===
                        visibleCheckedCheckboxes.length
                    );
                    
                    // Debug pagination clicks
                    $('#guest-table_paginate .paginate_button').off('click.debug').on('click.debug', function(e) {
                        console.log('Pagination button clicked:', this);
                        console.log('Event:', e);
                        console.log('Has class disabled:', $(this).hasClass('disabled'));
                        console.log('Has class current:', $(this).hasClass('current'));
                        
                        // Check if there are any overlaying elements
                        var rect = this.getBoundingClientRect();
                        var elementBelow = document.elementFromPoint(rect.left + rect.width/2, rect.top + rect.height/2);
                        console.log('Element at click point:', elementBelow);
                        
                        if ($(this).hasClass('disabled')) {
                            console.log('Button is disabled - preventing default');
                            e.preventDefault();
                            return false;
                        }
                    });
                }
            }); // Add pagination click debugging
            
            // Debug DataTables initialization
            setTimeout(function() {
                console.log('=== DataTables Debug ===');
                console.log('DataTable instance:', dataGuest);
                console.log('Table ID exists:', $('#guest-table').length > 0);
                console.log('Is DataTable:', $.fn.DataTable.isDataTable('#guest-table'));
                console.log('Pagination controls:', $('#guest-table_paginate').length);
                console.log('Pagination buttons:', $('#guest-table_paginate .paginate_button').length);
                if (dataGuest && dataGuest.page) {
                    console.log('Page info:', dataGuest.page.info());
                }
                
                // Check for event conflicts
                var $paginationButtons = $('#guest-table_paginate .paginate_button');
                $paginationButtons.each(function(index, button) {
                    var events = $._data(button, 'events');
                    console.log('Button', index, 'events:', events);
                });
                
                console.log('========================');
                
                // Test direct click handler
                $('#guest-table_paginate').off('click.test').on('click.test', '.paginate_button:not(.disabled)', function(e) {
                    console.log('Direct pagination click detected!');
                    var $this = $(this);
                    var pageNum = $this.text();
                    console.log('Page number:', pageNum);
                    console.log('Button classes:', $this.attr('class'));
                    
                    // Check if it's a valid page number
                    if (!isNaN(pageNum)) {
                        console.log('Navigating to page:', parseInt(pageNum) - 1);
                        dataGuest.page(parseInt(pageNum) - 1).draw('page');
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    } else if ($this.hasClass('next')) {
                        console.log('Next page clicked');
                        dataGuest.page('next').draw('page');
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    } else if ($this.hasClass('previous')) {
                        console.log('Previous page clicked');
                        dataGuest.page('previous').draw('page');
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    } else if ($this.hasClass('first')) {
                        console.log('First page clicked');
                        dataGuest.page('first').draw('page');
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    } else if ($this.hasClass('last')) {
                        console.log('Last page clicked');
                        dataGuest.page('last').draw('page');
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    }
                });
                
            }, 2000);
            
            $(document).on('change', '#select-all', function() {
                var isChecked = $(this).is(':checked');

                // Only select checkboxes that are currently visible on the page
                var visibleCheckboxes = $('#guest-table tbody').find('.guest-checkbox');
                visibleCheckboxes.prop('checked', isChecked);

                handleCheckboxChange();
            }); // Individual checkbox change
            $(document).on('change', '.guest-checkbox', function() {
                handleCheckboxChange();

                // Update select-all checkbox based on visible checkboxes only
                var visibleCheckboxes = $('#guest-table tbody').find('.guest-checkbox');
                var visibleCheckedCheckboxes = $('#guest-table tbody').find('.guest-checkbox:checked');

                $('#select-all').prop('checked',
                    visibleCheckboxes.length > 0 && visibleCheckboxes.length ===
                    visibleCheckedCheckboxes.length
                );
            }); // Clear selection
            $(document).on('click', '#clear-selection', function() {
                $('#guest-table tbody').find('.guest-checkbox').prop('checked', false);
                $('#select-all').prop('checked', false);
                selectedGuests = [];
                updateBulkActions();
            }); // Bulk delete
            $(document).on('click', '#bulk-delete', function() {
                if (selectedGuests.length === 0) {
                    toastr.warning('Please select guests to delete');
                    return;
                }

                Swal.fire({
                    title: 'Delete Selected Guests?',
                    text: `Are you sure you want to delete ${selectedGuests.length} selected guest(s)? This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkAction('delete', selectedGuests);
                    }
                });
            });

            // Bulk mark as sent
            $('#bulk-mark-sent').on('click', function() {
                if (selectedGuests.length === 0) {
                    toastr.warning('Please select guests to update');
                    return;
                }

                Swal.fire({
                    title: 'Mark as Sent?',
                    text: `Mark ${selectedGuests.length} selected guest(s) invitation status as "Sent"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, mark as sent!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkAction('mark_sent', selectedGuests);
                    }
                });
            });

            // Bulk mark as pending
            $('#bulk-mark-pending').on('click', function() {
                if (selectedGuests.length === 0) {
                    toastr.warning('Please select guests to update');
                    return;
                }

                Swal.fire({
                    title: 'Mark as Pending?',
                    text: `Mark ${selectedGuests.length} selected guest(s) invitation status as "Pending"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, mark as pending!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkAction('mark_pending', selectedGuests);
                    }
                });
            });

            // Filter event handlers
            $('#filter-category, #filter-gender, #filter-attendance-status, #filter-invitation-status').change(
                function() {
                    dataGuest.draw();
                    // Clear selection when filters change
                    $('#clear-selection').click();
                }); // Reset filters
            $(document).on('click', '#reset-filters', function() {
                $('#filter-category').val('');
                $('#filter-gender').val('');
                $('#filter-attendance-status').val('');
                $('#filter-invitation-status').val('');
                dataGuest.draw();
                $('#clear-selection').click();

                toastr.options = {
                    "positionClass": "toast-bottom-right",
                };
                toastr.info('Filters have been reset');
            }); // Reload DataTable when modal is closed (after create/update)
            $('#myModal').on('hidden.bs.modal', function() {
                // Optional: Additional reload for safety, but AJAX success handlers should handle it
                // $('#guest-table').DataTable().ajax.reload();
            });
        });

        function bulkAction(action, guestIds) {
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
                url: "{{ url('/invitation/' . $invitation->invitation_id . '/guests/bulk-action') }}",
                type: 'POST',
                data: {
                    action: action,
                    guest_ids: guestIds,
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
                        }); // Clear selection and reload table if refresh flag is set
                        $('#clear-selection').click();
                        if (response.refresh || response.success) {
                            setTimeout(function() {
                                // Safely reload DataTable
                                safeReloadDataTable('#guest-table');
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

        // WhatsApp Functions - Moved outside bulkAction for proper execution
        $(document).on('click', '.btn-send-wa', function() {
            var guestId = $(this).data('guest-id');
            var invitationId = $(this).data('invitation-id');
            var btn = $(this);

            // Get guest name from the row data for better confirmation message
            var guestName = $(this).closest('tr').find('td').eq(2).text(); // Assuming guest name is in 4th column

            // Show confirmation modal using SweetAlert
            Swal.fire({
            title: 'Confirm Send WhatsApp',
            text: `Send WhatsApp invitation to ${guestName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#25d366',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Send!',
            cancelButtonText: 'Cancel'
            }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                url: `/invitation/${invitationId}/guests/${guestId}/send-wa`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if (res.success) {
                    toastr.success('WhatsApp message sent successfully!');
                    // Refresh DataTable to update status
                    dataGuest.ajax.reload(null, false);
                    } else {
                    toastr.error(res.message || 'Failed to send WhatsApp.');
                    }
                },
                error: function(err) {
                    var errorMessage = 'Failed to send WhatsApp.';
                    if (err.responseJSON && err.responseJSON.message) {
                    errorMessage = err.responseJSON.message;
                    }
                    toastr.error(errorMessage);
                },
                complete: function() {
                    btn.prop('disabled', false).html(
                    '<i class="fab fa-whatsapp"></i> Send WA');
                }
                });
            }
            });
        });

        // Kirim WhatsApp bulk
        $(document).on('click', '#bulk-send-wa', function() {
            if (selectedGuests.length === 0) {
                toastr.warning('Pilih tamu terlebih dahulu!');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Kirim WhatsApp',
                text: `Kirim pesan WhatsApp ke ${selectedGuests.length} tamu terpilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#25d366',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var btn = $(this);
                    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: `/invitation/{{ $invitation->invitation_id }}/guests/send-wa-bulk`,
                        type: 'POST',
                        data: {
                            guest_ids: selectedGuests,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            if (res.success) {
                                toastr.success(
                                    'Pesan WhatsApp berhasil dikirim ke tamu terpilih!');
                                // Refresh DataTable untuk memperbarui status
                                dataGuest.ajax.reload(null, false);
                                // Clear selection after successful bulk send
                                selectedGuests = [];
                                updateBulkActions();
                                $('.guest-checkbox').prop('checked', false);
                            } else {
                                toastr.error(res.message || 'Gagal mengirim WhatsApp bulk.');
                            }
                        },
                        error: function(err) {
                            var errorMessage = 'Gagal mengirim WhatsApp bulk.';
                            if (err.responseJSON && err.responseJSON.message) {
                                errorMessage = err.responseJSON.message;
                            }
                            toastr.error(errorMessage);
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(
                                '<i class="fab fa-whatsapp"></i> Kirim WhatsApp Terpilih');
                        }
                    });
                }
            });
        });
    </script>
@endsection

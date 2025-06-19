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
            <div class="card-tools">
                <a href="{{ url('/invitation') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Invitations
                </a>
                <button id="scanner" class="btn btn-info"
                    onclick="window.location.href='{{ url('/invitation/' . $invitation->invitation_id . '/guests/scanner') }}'">
                    <i class="fa fa-qrcode"></i> QR Scanner
                </button>
                <button id="reset-filters" class="btn btn-warning">
                    <i class="fa fa-sync"></i> Reset Filters
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
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Invitation Details</h5>
                        <strong>{{ $invitation->wedding_name }}</strong> - {{ $invitation->groom_name }} &
                        {{ $invitation->bride_name }}<br>
                        <small>
                            <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') }} 
                            <i class="fa fa-clock ml-2"></i> {{ $invitation->wedding_time_start }} - {{ $invitation->wedding_time_end }}
                            <i class="fa fa-map-marker-alt ml-2"></i> {{ $invitation->wedding_venue }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Filters Row -->
            <div class="row mb-3">
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

            <table class="table table-bordered table-sm table-hover table-striped text-nowrap" id="guest-table">
                <thead>
                    <tr>
                        <th>No</th>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Category</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Attendance Status</th>
                        <th>Arrival Time</th>
                        <th>Invitation Status</th>
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
                        "positionClass": "toast-bottom-right",
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
                scrollX: true,
                // responsive: true,
                ajax: {
                    url: "{{ url('/invitation/' . $invitation->invitation_id . '/guests/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.category = $('#filter-category').val();
                        d.gender = $('#filter-gender').val();
                        d.attendance_status = $('#filter-attendance-status').val();
                        d.invitation_status = $('#filter-invitation-status').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '50px'
                    },
                    // {
                    //     data: 'guest_id_qr_code',
                    //     name: 'guest_id_qr_code',
                    //     className: 'text-nowrap',
                    //     render: function(data, type, row) {
                    //         return '<small><code>' + data.substring(0, 15) + '...</code></small>';
                    //     }
                    // },
                    {
                        data: 'guest_name',
                        name: 'guest_name',
                        className: 'text-nowrap'
                    },
                    {
                        data: 'guest_gender',
                        name: 'guest_gender',
                    },
                    {
                        data: 'guest_category',
                        name: 'guest_category',
                    },
                    {
                        data: 'guest_contact',
                        name: 'guest_contact'
                    },
                    {
                        data: 'guest_address',
                        name: 'guest_address',
                        render: function(data, type, row) {
                            return data && data.length > 30 ? 
                                '<span title="' + data + '">' + data.substr(0, 30) + '...</span>' : 
                                data;
                        },
                        className: 'text-nowrap'
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
                        }
                    },
                    {
                        data: 'guest_arrival_time',
                        name: 'guest_arrival_time',
                        render: function(data, type, row) {
                            if (data && data !== '-' && data !== null) {
                                return '<small>' + moment(data).format('DD/MM/YYYY<br>HH:mm:ss') + '</small>';
                            } else {
                                return '<span class="badge badge-secondary">-</span>';
                            }
                        },
                        className: 'text-nowrap'
                    },
                    {
                        data: 'guest_invitation_status',
                        name: 'guest_invitation_status',
                        render: function(data, type, row) {
                            if (data === 'Sent') {
                                return '<span class="badge badge-success">' + data + '</span>';
                            } else if (data === 'Pending') {
                                return '<span class="badge badge-warning">' + data + '</span>';
                            } else {
                                return '<span class="badge badge-secondary">' + data + '</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center text-nowrap'
                    },
                ],
                order: [[2, 'asc']], // Order by guest name
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            });

            // Filter event handlers
            $('#filter-category, #filter-gender, #filter-attendance-status, #filter-invitation-status').change(
                function() {
                    dataGuest.draw();
                });

            // Reset filters
            $('#reset-filters').click(function() {
                $('#filter-category').val('');
                $('#filter-gender').val('');
                $('#filter-attendance-status').val('');
                $('#filter-invitation-status').val('');
                dataGuest.draw();
                
                toastr.options = {
                    "positionClass": "toast-bottom-right",
                };
                toastr.info('Filters have been reset');
            });
        });
    </script>
@endsection
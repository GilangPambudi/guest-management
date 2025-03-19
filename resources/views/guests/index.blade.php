<!-- filepath: d:\Github\Laravel\SKRIPSI\skripsi-manajemen-tamu\resources\views\guests\index.blade.php -->
@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card-header ">
            <div class="card-tools">
                <button id="scanner" class="btn btn-info" onclick="window.location.href='{{ url('/guests/scanner') }}'"><i
                    class="fa fa-qrcode"></i> Scanner</button>
                <button id="reset-filters" class="btn btn-warning"><i
                    class="fa fa-sync"></i> Reset Filters</button>
                <button onclick="modalAction('{{ url('/guests/import') }}')" class="btn btn-success"><i
                        class="fa fa-download"></i> Import Guests</button>
                <button onclick="modalAction('{{ url('/guests/create_ajax') }}')" class="btn btn-primary"><i
                    class="fa fa-plus-circle"></i> Add
                    Guest</button>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select id="filter-category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-gender" class="form-control">
                        <option value="">All Genders</option>
                        @foreach($genders as $gender)
                            <option value="{{ $gender }}">{{ $gender }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-attendance-status" class="form-control">
                        <option value="">All Attendance Status</option>
                        @foreach($attendanceStatuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-invitation-status" class="form-control">
                        <option value="">All Invitation Status</option>
                        @foreach($invitationStatuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="table table-bordered table-sm table-hover table-striped text-nowrap" id="guest-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Category</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Attendance Status</th>
                        <th>Invitation Status</th>
                        <th>Action</th>
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
            var tempInput = document.createElement("input");
            tempInput.style.position = "absolute";
            tempInput.style.left = "-9999px";
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            toastr.success('Copied to clipboard!');
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#guest-table').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                scrollX: true,
                ajax: {
                    url: "{{ url('guests/list') }}",
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
                        searchable: false
                    },
                    {
                        data: 'guest_id_qr_code',
                        name: 'guest_id_qr_code',
                        className: 'text-nowrap'
                    },
                    {
                        data: 'guest_name',
                        name: 'guest_name',
                        className: 'text-nowrap'
                    },
                    {
                        data: 'guest_gender',
                        name: 'guest_gender'
                    },
                    {
                        data: 'guest_category',
                        name: 'guest_category'
                    },
                    {
                        data: 'guest_contact',
                        name: 'guest_contact'
                    },
                    {
                        data: 'guest_address',
                        name: 'guest_address',
                        render: function(data, type, row) {
                            return data.length > 20 ? data.substr(0, 20) + '...' : data;
                        },
                        className: 'text-nowrap'
                    },
                    {
                        data: 'guest_attendance_status',
                        name: 'guest_attendance_status'
                    },
                    {
                        data: 'guest_invitation_status',
                        name: 'guest_invitation_status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        className: 'text-nowrap'
                    },
                ],
            });

            $('#filter-category, #filter-gender, #filter-attendance-status, #filter-invitation-status').change(function() {
                table.draw();
            });

            $('#reset-filters').click(function() {
                $('#filter-category').val('');
                $('#filter-gender').val('');
                $('#filter-attendance-status').val('');
                $('#filter-invitation-status').val('');
                table.draw();
            });
        });
    </script>
@endsection
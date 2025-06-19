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
                <button onclick="modalAction('{{ url('/invitation/create_ajax') }}')" class="btn btn-primary"><i
                    class="fa fa-plus-circle"></i> Add
                    Invitation</button>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm table-hover table-striped" id="invitation-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Wedding Name</th>
                        <th>Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Venue</th>
                        <th>Location</th>
                        <th>Maps URL</th>
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

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#invitation-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ url('invitation/list') }}",
                    type: "POST",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'wedding_name',
                        name: 'wedding_name'
                    },
                    {
                        data: 'wedding_date',
                        name: 'wedding_date',
                        render: function(data, type, row) {
                            const date = new Date(data);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        }
                    },
                    {
                        data: 'wedding_time_start',
                        name: 'wedding_time_start',
                        render: function(data, type, row) {
                            const date = new Date(`1970-01-01T${data}Z`);
                            const hours = String(date.getUTCHours()).padStart(2, '0');
                            const minutes = String(date.getUTCMinutes()).padStart(2, '0');
                            return `${hours}:${minutes}`;
                        }
                    },
                    {
                        data: 'wedding_time_end',
                        name: 'wedding_time_end',
                        render: function(data, type, row) {
                            const date = new Date(`1970-01-01T${data}Z`);
                            const hours = String(date.getUTCHours()).padStart(2, '0');
                            const minutes = String(date.getUTCMinutes()).padStart(2, '0');
                            return `${hours}:${minutes}`;
                        }
                    },
                    {
                        data: 'wedding_venue',
                        name: 'wedding_venue'
                    },
                    {
                        data: 'wedding_location',
                        name: 'wedding_location',
                        render: function(data, type, row) {
                            return data.length > 20 ? data.substr(0, 20) + '...' : data;
                        }
                    },
                    {
                        data: 'wedding_maps',
                        name: 'wedding_maps',
                        render: function(data, type, row) {
                            return `<a href="${data}" target="_blank">View Map</a>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
        });
    </script>
@endsection

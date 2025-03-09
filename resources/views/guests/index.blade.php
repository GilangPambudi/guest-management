@extends('layouts.template')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card-header ">
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/guests/import') }}')" class="btn btn-success"><i
                class="fa fa-download"></i> Import Guests</button>
            <button onclick="modalAction('{{ url('/guests/create_ajax') }}')" class="btn btn-primary">Add
                Guest</button>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-sm table-hover table-striped" id="guest-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>QR Code</th>
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

            $('#guest-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('guests/list') }}",
                    type: "POST",
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'guest_name',
                        name: 'guest_name'
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
                        }
                    },
                    {
                        data: 'guest_qr_code',
                        name: 'guest_qr_code'
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
                        className: 'text-center'
                    }
                ]
            });
        });
    </script>
@endsection
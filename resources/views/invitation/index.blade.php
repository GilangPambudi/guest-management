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
                <button onclick="modalAction('{{ url('/invitation/import') }}')" class="btn btn-success"><i
                        class="fa fa-download"></i> Import Invitations</button>
                <button onclick="modalAction('{{ url('/invitation/create_ajax') }}')" class="btn btn-primary">Add
                    Invitation</button>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm table-hover table-striped" id="invitation-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Wedding Name</th>
                        <th>Groom</th>
                        <th>Bride</th>
                        <th>Wedding Date</th>
                        <th>Wedding Time Start</th>
                        <th>Wedding Time End</th>
                        <th>Location</th>
                        <th>Status</th>
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
                columns: [
                    {
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
                        data: 'groom_id',
                        name: 'groom_id'
                    },
                    {
                        data: 'bride_id',
                        name: 'bride_id'
                    },
                    {
                        data: 'wedding_date',
                        name: 'wedding_date'
                    },
                    {
                        data: 'wedding_time_start',
                        name: 'wedding_time_start'
                    },
                    {
                        data: 'wedding_time_end',
                        name: 'wedding_time_end'
                    },
                    {
                        data: 'location',
                        name: 'location',
                        render: function(data, type, row) {
                            return data.length > 20 ? data.substr(0, 20) + '...' : data;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
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
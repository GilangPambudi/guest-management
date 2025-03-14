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
                <button onclick="modalAction('{{ url('/invitation/create_ajax') }}')" class="btn btn-primary">Create Invitation</button>
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
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <!-- Content will appear here -->
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
                    ]
                });
            });
        </script>
    @endsection

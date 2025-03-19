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
                <button onclick="modalAction('{{ url('couple/create_ajax') }}')" class="btn btn-primary"> Add
                    Name</button>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm table-hover table-striped" id="couple-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Alias</th>
                        <th>Gender</th>
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

            $('#couple-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('couple/list') }}",
                    type: "POST",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'couple_name',
                        name: 'couple_name'
                    },
                    {
                        data: 'couple_alias',
                        name: 'couple_alias'
                    },
                    {
                        data: 'couple_gender',
                        name: 'couple_gender'
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

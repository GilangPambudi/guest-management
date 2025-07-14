@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-primary card-outline h-100">
                <div class="card-body box-profile d-flex flex-column" style="height:100%;">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">
                        @if($user->role === 'admin')
                            <span class="badge badge-success">Administrator</span>
                        @else
                            <span class="badge badge-secondary">User</span>
                        @endif
                    </p>

                    {{-- Statistics Row (moved here) --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="info-box mb-2">
                                <span class="info-box-icon bg-info"><i class="fas fa-envelope"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Invitations</span>
                                    <span class="info-box-number">{{ $stats['total_invitations'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Guests</span>
                                    <span class="info-box-number">{{ $stats['total_guests'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Statistics Row --}}

                    <a href="#" onclick="modalAction('{{ url('/profile/edit_ajax') }}')" class="btn btn-primary btn-block mt-auto">
                        <b><i class="fas fa-edit"></i> Edit Profile</b>
                    </a>
                    <a href="#" onclick="modalAction('{{ url('/profile/password_ajax') }}')" class="btn btn-warning btn-block">
                        <b><i class="fas fa-lock"></i> Change Password</b>
                    </a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header p-2">
                    <h3 class="card-title"><i class="fas fa-user"></i> Profile Information</h3>
                </div><!-- /.card-header -->
                <div class="card-body ">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">User ID:</th>
                            <td class="col-9">{{ $user->user_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Name:</th>
                            <td class="col-9">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Email:</th>
                            <td class="col-9">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Role:</th>
                            <td class="col-9">
                                @if($user->role === 'admin')
                                    <span class="badge badge-success">Administrator</span>
                                @else
                                    <span class="badge badge-secondary">User</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Email Verified:</th>
                            <td class="col-9">
                                @if($user->email_verified_at)
                                    <span class="badge badge-success">Verified</span>
                                    <br>
                                    <small class="text-muted">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                                @else
                                    <span class="badge badge-warning">Not Verified</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Member Since:</th>
                            <td class="col-9">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Last Updated:</th>
                            <td class="col-9">{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    </table>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

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
        });
    </script>
@endsection

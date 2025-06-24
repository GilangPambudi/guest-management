{{-- filepath: d:\Github\Laravel\SKRIPSI\skripsi-manajemen-tamu\resources\views\invitation\show.blade.php --}}
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
                <button onclick="modalAction('{{ url('/invitation/' . $invitation->invitation_id . '/edit_ajax') }}')"
                    class="btn btn-warning">
                    <i class="fa fa-edit"></i> Edit Invitation
                </button>
                <a href="{{ url('/invitation/' . $invitation->invitation_id . '/guests') }}" class="btn btn-success">
                    <i class="fa fa-users"></i> Manage Guests
                </a>

                <!-- Conditional Delete Button -->
                @if ($totalGuests > 0)
                    <button class="btn btn-danger" disabled
                        title="Cannot delete invitation with {{ $totalGuests }} guest(s), please delete all guests first">
                        <i class="fa fa-ban"></i> Delete ({{ $totalGuests }} guests)
                    </button>
                @else
                    <button
                        onclick="modalAction('{{ url('/invitation/' . $invitation->invitation_id . '/delete_ajax') }}')"
                        class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete Invitation
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body">
            <!-- Invitation Details Header -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-heart"></i> Wedding Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="text-primary mb-3">{{ $invitation->wedding_name }}</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td width="120"><strong>Groom:</strong></td>
                                                    <td>{{ $invitation->groom_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Bride:</strong></td>
                                                    <td>{{ $invitation->bride_name }}</td>
                                                </tr>
                                                @if ($invitation->groom_alias)
                                                    <tr>
                                                        <td><strong>Groom Alias:</strong></td>
                                                        <td>{{ $invitation->groom_alias }}</td>
                                                    </tr>
                                                @endif
                                                @if ($invitation->bride_alias)
                                                    <tr>
                                                        <td><strong>Bride Alias:</strong></td>
                                                        <td>{{ $invitation->bride_alias }}</td>
                                                    </tr>
                                                @endif
                                                @if ($invitation->slug)
                                                    <tr>
                                                        <td><strong>Slug:</strong></td>
                                                        <td><code>{{ $invitation->slug }}</code></td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td width="120"><strong>Date:</strong></td>
                                                    <td>
                                                        <i class="fa fa-calendar text-primary"></i>
                                                        {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('l, d F Y') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Time:</strong></td>
                                                    <td>
                                                        <i class="fa fa-clock text-primary"></i>
                                                        {{ $invitation->wedding_time_start }} -
                                                        {{ $invitation->wedding_time_end }} WIB
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Venue:</strong></td>
                                                    <td>
                                                        <i class="fa fa-building text-primary"></i>
                                                        {{ $invitation->wedding_venue }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Location:</strong></td>
                                                    <td>
                                                        <i class="fa fa-map-marker-alt text-primary"></i>
                                                        {{ $invitation->wedding_location }}
                                                    </td>
                                                </tr>
                                                @if ($invitation->wedding_maps)
                                                    <tr>
                                                        <td><strong>Maps:</strong></td>
                                                        <td>
                                                            <a href="{{ $invitation->wedding_maps }}" target="_blank"
                                                                class="btn btn-primary btn-sm">
                                                                <i class="fa fa-external-link-alt"></i> View Map
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if ($invitation->wedding_image)
                                        <div class="text-center">
                                            <img src="{{ asset($invitation->wedding_image) }}" alt="Wedding Image"
                                                class="img-fluid rounded shadow">
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="bg-light rounded p-4">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                                <p class="text-muted mt-2">No image available</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalGuests }}</h3>
                            <p>Total Guests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $attendedGuests }}</h3>
                            <p>Attended</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendingGuests }}</h3>
                            <p>Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $notAttendedGuests }}</h3>
                            <p>Not Attended</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guest Categories -->
            @if ($guestCategories->count() > 0)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie"></i> Guests by Category
                                </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th class="text-right">Count</th>
                                            <th class="text-right">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($guestCategories as $category => $count)
                                            <tr>
                                                <td>{{ $category }}</td>
                                                <td class="text-right">{{ $count }}</td>
                                                <td class="text-right">
                                                    {{ $totalGuests > 0 ? number_format(($count / $totalGuests) * 100, 1) : 0 }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle"></i> Quick Info
                                </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Attendance Rate:</strong></td>
                                        <td class="text-right">
                                            <span class="badge badge-success">
                                                {{ $totalGuests > 0 ? number_format(($attendedGuests / $totalGuests) * 100, 1) : 0 }}%
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Created:</strong></td>
                                        <td class="text-right">{{ $invitation->created_at->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Updated:</strong></td>
                                        <td class="text-right">{{ $invitation->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Guests -->
            @if ($invitation->guests->count() > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-users"></i> Recent Guests
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ url('/invitation/' . $invitation->invitation_id . '/guests') }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> View All Guests
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Gender</th>
                                            <th>Contact</th>
                                            <th>Attendance</th>
                                            <th>Invitation Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invitation->guests->take(10) as $guest)
                                            <tr>
                                                <td>{{ $guest->guest_name }}</td>
                                                <td>{{ $guest->guest_category }}</td>
                                                <td>{{ $guest->guest_gender }}</td>
                                                <td>{{ $guest->guest_contact ?: '-' }}</td>
                                                <td>
                                                    @if ($guest->guest_attendance_status === 'Yes')
                                                        <span
                                                            class="badge badge-success">{{ $guest->guest_attendance_status }}</span>
                                                    @elseif($guest->guest_attendance_status === 'No')
                                                        <span
                                                            class="badge badge-danger">{{ $guest->guest_attendance_status }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-secondary">{{ $guest->guest_attendance_status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($guest->guest_invitation_status === 'Sent')
                                                        <span
                                                            class="badge badge-success">{{ $guest->guest_invitation_status }}</span>
                                                    @elseif($guest->guest_invitation_status === 'Pending')
                                                        <span
                                                            class="badge badge-warning">{{ $guest->guest_invitation_status }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-secondary">{{ $guest->guest_invitation_status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($invitation->guests->count() > 10)
                                    <div class="text-center mt-3">
                                        <small class="text-muted">Showing 10 of {{ $invitation->guests->count() }}
                                            guests</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Modal for Edit/Delete actions -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <!-- Modal content will be loaded here -->
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

            // Handle modal form submissions
            $('#myModal').on('submit', 'form', function(e) {
                e.preventDefault();
                
                let form = $(this);
                let formData = new FormData(this);
                let url = form.attr('action');
                let method = form.attr('method') || 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.success,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Auto refresh page after edit success
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            let errors = xhr.responseJSON.errors;
                            
                            // Clear previous errors
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();
                            
                            // Show validation errors
                            $.each(errors, function(key, value) {
                                let input = $('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                            });
                        } else {
                            // Other errors
                            let message = xhr.responseJSON?.message || 'An error occurred';
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: message
                            });
                        }
                    }
                });
            });

            // Handle delete confirmation specifically
            $('#myModal').on('click', '.btn-danger[onclick*="delete"]', function(e) {
                e.preventDefault();
                
                let deleteUrl = $(this).data('url') || $(this).closest('form').attr('action');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            success: function(response) {
                                $('#myModal').modal('hide');
                                
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        // Redirect to invitation index after successful delete
                                        window.location.href = '{{ url("/invitation") }}';
                                    });
                                }
                            },
                            error: function(xhr) {
                                let message = xhr.responseJSON?.message || 'Delete failed';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: message
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

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
                    <button onclick="modalAction('{{ url('/invitation/' . $invitation->invitation_id . '/delete_ajax') }}')"
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-primary h-100">
                                                <div class="card-header bg-primary text-white">
                                                    <strong>Groom</strong>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Name</div>
                                                        <div class="col-6">{{ $invitation->groom_name }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Alias</div>
                                                        <div class="col-6">{{ $invitation->groom_alias }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Child Number</div>
                                                        <div class="col-6">{{ $invitation->groom_child_number }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Father</div>
                                                        <div class="col-6">{{ $invitation->groom_father }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6 font-weight-bold">Mother</div>
                                                        <div class="col-6">{{ $invitation->groom_mother }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-danger h-100">
                                                <div class="card-header bg-danger text-white">
                                                    <strong>Bride</strong>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Name</div>
                                                        <div class="col-6">{{ $invitation->bride_name }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Alias</div>
                                                        <div class="col-6">{{ $invitation->bride_alias }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Child Number</div>
                                                        <div class="col-6">{{ $invitation->bride_child_number }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 font-weight-bold">Father</div>
                                                        <div class="col-6">{{ $invitation->bride_father }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6 font-weight-bold">Mother</div>
                                                        <div class="col-6">{{ $invitation->bride_mother }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <strong>Invitation Info</strong>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row m-0 border-bottom py-2">
                                                <div class="col-sm-4 font-weight-bold">Slug</div>
                                                <div class="col-sm-8">
                                                    @if ($invitation->slug)
                                                        <code>{{ $invitation->slug }}</code>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row m-0 border-bottom py-2">
                                                <div class="col-sm-4 font-weight-bold">Date</div>
                                                <div class="col-sm-8">
                                                    {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('l, d F Y') }}
                                                </div>
                                            </div>
                                            <div class="row m-0 border-bottom py-2">
                                                <div class="col-sm-4 font-weight-bold">Time</div>
                                                <div class="col-sm-8">{{ $invitation->wedding_time_start }} -
                                                    {{ $invitation->wedding_time_end }} WIB</div>
                                            </div>
                                            <div class="row m-0 border-bottom py-2">
                                                <div class="col-sm-4 font-weight-bold">Venue</div>
                                                <div class="col-sm-8">{{ $invitation->wedding_venue }}</div>
                                            </div>
                                            <div class="row m-0 border-bottom py-2">
                                                <div class="col-sm-4 font-weight-bold">Location</div>
                                                <div class="col-sm-8">{{ $invitation->wedding_location }}</div>
                                            </div>
                                            <div class="row m-0 border-bottom py-2">
                                                <div class="col-sm-4 font-weight-bold">Maps</div>
                                                <div class="col-sm-8">
                                                    @if ($invitation->wedding_maps)
                                                        <a href="{{ $invitation->wedding_maps }}" target="_blank"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa fa-external-link-alt"></i> View Map
                                                        </a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row m-0 border-bottom py-2">
                                                <div class="col-sm-4 font-weight-bold">Created</div>
                                                <div class="col-sm-8">{{ $invitation->created_at->format('d M Y') }}
                                                </div>
                                            </div>
                                            <div class="row m-0 py-2">
                                                <div class="col-sm-4 font-weight-bold">Last Updated</div>
                                                <div class="col-sm-8">
                                                    {{ $invitation->updated_at->format('d M Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Spoiler/collapse for photo -->
                                    <div class="mb-3">
                                        <button class="btn btn-outline-secondary btn-block" type="button"
                                            data-toggle="collapse" data-target="#collapsePhoto" aria-expanded="false"
                                            aria-controls="collapsePhoto">
                                            <i class="fas fa-image"></i> Show/Hide Wedding Photo
                                        </button>
                                        <div class="collapse mt-3" id="collapsePhoto">
                                            <div class="card card-body text-center">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4 mb-3 mb-md-0">
                                                        <div>
                                                            <strong>Groom Image</strong>
                                                        </div>
                                                        @if ($invitation->groom_image)
                                                            <img src="{{ asset($invitation->groom_image) }}"
                                                                alt="Groom Image" class="img-fluid rounded shadow"
                                                                style="max-width: 150px;">
                                                        @else
                                                            <div class="bg-light rounded p-3">
                                                                <i class="fas fa-user fa-2x text-muted"></i>
                                                                <div class="text-muted mt-2">No image</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4 mb-3 mb-md-0">
                                                        <div>
                                                            <strong>Wedding Image</strong>
                                                        </div>
                                                        @if ($invitation->wedding_image)
                                                            <img src="{{ asset($invitation->wedding_image) }}"
                                                                alt="Wedding Image" class="img-fluid rounded shadow"
                                                                style="max-width: 150px;">
                                                        @else
                                                            <div class="bg-light rounded p-3">
                                                                <i class="fas fa-image fa-2x text-muted"></i>
                                                                <div class="text-muted mt-2">No image</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4 mb-3 mb-md-0">
                                                        <div>
                                                            <strong>Bride Image</strong>
                                                        </div>
                                                        @if ($invitation->bride_image)
                                                            <img src="{{ asset($invitation->bride_image) }}"
                                                                alt="Bride Image" class="img-fluid rounded shadow"
                                                                style="max-width: 150px;">
                                                        @else
                                                            <div class="bg-light rounded p-3">
                                                                <i class="fas fa-user fa-2x text-muted"></i>
                                                                <div class="text-muted mt-2">No image</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                input.after('<div class="invalid-feedback">' + value[
                                    0] + '</div>');
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
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
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
                                        window.location.href =
                                            '{{ url('/invitation') }}';
                                    });
                                }
                            },
                            error: function(xhr) {
                                let message = xhr.responseJSON?.message ||
                                    'Delete failed';
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
@endsection

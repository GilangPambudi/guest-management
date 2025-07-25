@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($invitations as $invitation)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header text-center">
                                <h3>{{ $invitation->wedding_name }}</h3>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong>{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</strong><br>
                                    <i class="fa fa-calendar text-muted"></i>
                                    {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') }}<br>
                                    <i class="fa fa-map-marker-alt text-muted"></i>
                                    {{ $invitation->wedding_venue }}<br>
                                    <i class="fa fa-users text-muted"></i>
                                    {{ $invitation->guests_count }} guest(s)
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ url('/invitation/' . $invitation->invitation_id . '/guests') }}"
                                    class="btn btn-primary btn-block rounded-lg">
                                    <i class="fa fa-users"></i> Manage Guests
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h4><i class="icon fas fa-info"></i> No Invitations Found</h4>
                            <p>Please create an invitation first before managing guests.</p>
                            <a href="{{ url('/invitation') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Create Invitation
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

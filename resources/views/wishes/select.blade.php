@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-heart mr-1"></i>
                {{ $page->title }}
            </h3>
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
                                    <i class="fa fa-heart text-muted"></i> 
                                    {{ $invitation->wishes_count ?? 0 }} wish(es)
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ url('/wishes/invitation/' . $invitation->invitation_id) }}" 
                                   class="btn btn-primary btn-block">
                                    <i class="fa fa-heart"></i> Manage Wishes
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h4><i class="icon fas fa-info"></i> No Invitations Found</h4>
                            <p>Please create an invitation first before managing wishes.</p>
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
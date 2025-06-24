@extends('layouts.template')

@section('content')
    <div class="card card-outline card-success">
        <div class="card-header text-center">
            <h3 class="card-title">Welcome to {{ $invitation->wedding_name }}</h3>
        </div>
        <div class="card-body text-center">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-success">
                        <h2><i class="fas fa-check-circle"></i> Check-in Successful!</h2>
                    </div>
                    
                    <div class="card">
                        <div class="card-body" data-guest-name="{{ $guest->guest_name }}">
                            <h3>Welcome, {{ $guest->guest_name }}!</h3>
                            <p class="lead">{{ $guest->guest_category }} Guest</p>
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <strong>Wedding:</strong><br>
                                    {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
                                </div>                                <div class="col-md-6">
                                    <strong>Arrival Time:</strong><br>
                                    {{ \Carbon\Carbon::parse($guest->guest_arrival_time)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Venue:</strong><br>
                                    {{ $invitation->wedding_venue }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Date:</strong><br>
                                    {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ url('/invitation/' . $invitation->invitation_id . '/scanner') }}" class="btn btn-primary">
                            <i class="fas fa-qrcode"></i> Back to Scanner
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
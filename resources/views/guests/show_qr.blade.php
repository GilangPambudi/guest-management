<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $guest->guest_name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <h1>QR Code for {{ $guest->guest_name }}</h1>
        <p><strong>Guest ID:</strong> {{ $guest->guest_id_qr_code }}</p>
        <div class="mt-4">
            <img src="{{ asset($guest->guest_qr_code) }}" alt="QR Code for {{ $guest->guest_name }}" class="img-fluid">
        </div>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>
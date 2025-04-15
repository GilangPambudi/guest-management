<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Wedding Invitation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .invitation-card {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 800px;
            width: 100%;
        }
        .invitation-card h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
        }
        .invitation-card h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            margin-top: 20px;
        }
        .invitation-card p {
            font-size: 1.2rem;
            color: #fff;
            margin-top: 20px;
        }
        .btn-primary {
            margin-top: 30px;
            font-size: 1rem;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="invitation-card">
        <h1>Welcome to <strong>{{ $groom }}</strong> and <strong>{{ $bride }}</strong>'s wedding.</h1>
        <h2><strong>{{ $guest->guest_name }}</strong></h2>
        <p>We are delighted to invite you to our wedding celebration.</p>
        {{-- <p><strong>Date:</strong> {{ $wedding_date }}</p>
        <p><strong>Time:</strong> {{ $wedding_time }}</p>
        <p><strong>Venue:</strong> {{ $wedding_venue }}</p> --}}
        {{-- <a href="{{ url('/rsvp') }}" class="btn btn-primary">RSVP Now</a> --}}
    </div>
</body>
</html>
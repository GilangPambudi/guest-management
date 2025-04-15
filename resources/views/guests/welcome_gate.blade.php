<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Welcome Gate</title>
    <link rel="icon" href="{{ asset('logoQR-transparent.png') }}" type="image/png">
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
        .welcome-gate {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 800px;
            width: 100%;
        }
        .welcome-gate h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
        }
        .welcome-gate h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            margin-top: 20px;
        }
        .welcome-gate p {
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
    <div class="welcome-gate">
        <h1>Welcome to Our Wedding</h1>
        <h2><strong>{{ $guest->guest_name }}</strong></h2>
        <p>We are so glad to have you here to celebrate this special day with us.</p>
        {{-- <a href="{{ url('/guests') }}" class="btn btn-primary">Back to Guest List</a> --}}
    </div>
</body>
</html>
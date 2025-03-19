<!DOCTYPE html>
<html>
<head>
    <title>Generate QR Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Generate QR Code</h2>
        <form action="{{ url('qr/submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="link">Enter URL:</label>
                <input type="url" class="form-control" id="link" name="link" required>
            </div>
            <button type="submit" class="btn btn-primary">Generate</button>
        </form>
    </div>
</body>
</html>
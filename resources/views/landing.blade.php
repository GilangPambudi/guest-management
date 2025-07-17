<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-users me-2"></i>
                Sistem Manajemen Tamu
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/login">Login</a>
                <a class="nav-link" href="/register">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container-fluid bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Kelola Tamu dengan Mudah & Efisien</h1>
                    <p class="lead mb-4">Sistem manajemen tamu digital yang membantu Anda mencatat, memantau, dan mengelola kunjungan tamu secara real-time dengan keamanan terjamin.</p>
                    <div class="d-flex gap-3">
                        <a href="/register" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i>Mulai Sekarang
                        </a>
                        <a href="/login" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-clipboard-list display-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold text-primary mb-3">Fitur Unggulan</h2>
                <p class="text-muted">Solusi lengkap untuk manajemen tamu modern</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-check text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title text-primary">Registrasi Digital</h5>
                        <p class="card-text text-muted">Pencatatan tamu secara digital dengan data lengkap dan foto</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-eye text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title text-primary">Monitoring Real-time</h5>
                        <p class="card-text text-muted">Pantau status kunjungan tamu secara real-time</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-shield-alt text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title text-primary">Keamanan Terjamin</h5>
                        <p class="card-text text-muted">Sistem keamanan berlapis untuk melindungi data tamu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-chart-bar text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title text-primary">Laporan Lengkap</h5>
                        <p class="card-text text-muted">Generate laporan kunjungan dengan berbagai filter</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Sistem Manajemen Tamu</h6>
                    <p class="mb-0 text-muted">Solusi digital untuk manajemen tamu modern</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">&copy; 2025 All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
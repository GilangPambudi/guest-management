@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">QR Code Scanner</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom untuk scanner QR Code dengan kamera -->
                <div class="col-md-6 text-center">
                    <div class="mb-4">
                        <button id="cameraModeBtn" class="btn btn-primary" onclick="switchToCameraMode()">Use Camera</button>
                        <button id="manualModeBtn" class="btn btn-secondary d-none" onclick="switchToManualMode()">Use Manual Scanner</button>
                    </div>
                    <div id="cameraScanner" style="display: none;">
                        <div id="reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                    </div>
                </div>

                <!-- Kolom untuk alat scanner manual -->
                <div class="col-md-6 text-center">
                    <div id="manualScanner">
                        <form id="scanForm">
                            <input type="text" id="manualScanInput" class="form-control mb-3" placeholder="Scan QR Code here" autofocus>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success mr-2" onclick="handleManualScan()">Submit</button>
                                <a href="{{ url('/home') }}" class="btn btn-primary">Back to Home</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <p id="result" class="text-success font-weight-bold"></p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Sesuaikan dengan lokasi file js HTML5-QRCode -->
    <script src="{{ asset('assets/html5-qrcode/html5-qrcode.min.js') }}"></script>
    <script>
        let html5QRCodeScanner;

        // Fungsi untuk beralih ke mode kamera
        function switchToCameraMode() {
            document.getElementById('manualScanner').style.display = 'none';
            document.getElementById('cameraScanner').style.display = 'block';
            document.getElementById('cameraModeBtn').classList.add('d-none');
            document.getElementById('manualModeBtn').classList.remove('d-none');

            // Inisialisasi html5QRCodeScanner jika belum diinisialisasi
            if (!html5QRCodeScanner) {
                html5QRCodeScanner = new Html5QrcodeScanner(
                    "reader", {
                        fps: 10,
                        qrbox: {
                            width: 200,
                            height: 200,
                        },
                    }
                );

                // Render QR Code Scanner
                html5QRCodeScanner.render(onScanSuccess);
            }
        }

        // Fungsi untuk beralih ke mode manual
        function switchToManualMode() {
            document.getElementById('cameraScanner').style.display = 'none';
            document.getElementById('manualScanner').style.display = 'block';
            document.getElementById('manualModeBtn').classList.add('d-none');
            document.getElementById('cameraModeBtn').classList.remove('d-none');

            // Hentikan scanner kamera jika sedang aktif
            if (html5QRCodeScanner) {
                html5QRCodeScanner.clear();
                html5QRCodeScanner = null;
            }
        }

        // Fungsi yang dieksekusi ketika QR Code berhasil dipindai
        function onScanSuccess(decodedText, decodedResult) {
            // Redirect ke link hasil scan
            window.location.href = decodedText;

            // Membersihkan area scan setelah action di atas
            if (html5QRCodeScanner) {
                html5QRCodeScanner.clear();
            }
        }

        // Fungsi untuk menangani input manual dari alat scan
        function handleManualScan() {
            const input = document.getElementById('manualScanInput').value;
            if (input) {
                // Redirect ke link hasil scan dengan prefix /invitation/
                window.location.href = `/invitation/${input}`;
            }
        }

        // Default ke mode manual saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            switchToManualMode();
        });
    </script>
@endsection
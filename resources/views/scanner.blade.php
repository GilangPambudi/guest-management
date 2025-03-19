// container HTML untuk scanner QR Code
<div id="reader"></div>
.
.
.
//sesuaikan dengan di folder mana teman-teman menaruh file js HTML5-QRCode
<script src="{{ asset('assets/html5-qrcode/html5-qrcode.min.js') }}"></script>
<script>
    // inisiasi html5QRCodeScanner
    let html5QRCodeScanner = new Html5QrcodeScanner(
        // target id dengan nama reader, lalu sertakan juga 
        // pengaturan untuk qrbox (tinggi, lebar, dll)
        "reader", {
            fps: 10,
            qrbox: {
                width: 200,
                height: 200,
            },
        }
    );

    // function yang dieksekusi ketika scanner berhasil
    // membaca suatu QR Code
    function onScanSuccess(decodedText, decodedResult) {
        // redirect ke link hasil scan
        window.location.href = decodedResult.decodedText;

        // membersihkan scan area ketika sudah menjalankan 
        // action diatas
        html5QRCodeScanner.clear();
    }

    // render qr code scannernya
    html5QRCodeScanner.render(onScanSuccess);
</script>
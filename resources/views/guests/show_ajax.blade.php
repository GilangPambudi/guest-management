<!-- filepath: d:\Github\Laravel\SKRIPSI\skripsi-manajemen-tamu\resources\views\guests\show_ajax.blade.php -->
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Guest</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">Guest ID:</th>
                    <td class="col-9">{{ $guest->guest_id_qr_code }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Guest Name:</th>
                    <td class="col-9">{{ $guest->guest_name }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Guest Category:</th>
                    <td class="col-9">{{ $guest->guest_category }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Guest Contact:</th>
                    <td class="col-9">{{ $guest->guest_contact }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Guest Address:</th>
                    <td class="col-9">{{ $guest->guest_address }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Guest QR Code:</th>
                    <td class="col-9">
                        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#qrCodeCollapse"
                            aria-expanded="false" aria-controls="qrCodeCollapse">
                            Show QR Code
                        </button>
                        <div class="collapse mt-2" id="qrCodeCollapse">
                            <img src="{{ asset($guest->guest_qr_code) }}" alt="Guest QR Code" class="img-fluid">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Guest Attendance Status:</th>
                    <td class="col-9">{{ $guest->guest_attendance_status }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Guest Invitation Status:</th>
                    <td class="col-9">{{ $guest->guest_invitation_status }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
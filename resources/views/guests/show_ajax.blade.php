<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Guest</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="guest_id_qr_code" class="col-sm-4 col-form-label">ID</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="guest_id_qr_code" value="{{ $guest->guest_id_qr_code }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="guest_name" class="col-sm-4 col-form-label">Guest Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="guest_name" value="{{ $guest->guest_name }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="guest_category" class="col-sm-4 col-form-label">Guest Category</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="guest_category" value="{{ $guest->guest_category }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="guest_contact" class="col-sm-4 col-form-label">Guest Contact</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="guest_contact" value="{{ $guest->guest_contact }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="guest_address" class="col-sm-4 col-form-label">Guest Address</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="guest_address" value="{{ $guest->guest_address }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="guest_qr_code" class="col-sm-4 col-form-label">Guest QR Code</label>
                <div class="col-sm-8">
                    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#qrCodeCollapse"
                        aria-expanded="false" aria-controls="qrCodeCollapse">
                        Show QR Code
                    </button>
                    <div class="collapse mt-2" id="qrCodeCollapse">
                        <img src="{{ asset($guest->guest_qr_code) }}" alt="Guest QR Code" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="guest_attendance_status" class="col-sm-4 col-form-label">Guest Attendance Status</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="guest_attendance_status"
                        value="{{ $guest->guest_attendance_status }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="guest_invitation_status" class="col-sm-4 col-form-label">Guest Invitation Status</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="guest_invitation_status"
                        value="{{ $guest->guest_invitation_status }}" readonly>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

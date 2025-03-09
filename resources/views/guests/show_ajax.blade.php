<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Guest</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="guest_name">Guest Name</label>
                <input type="text" class="form-control" id="guest_name" value="{{ $guest->guest_name }}" readonly>
            </div>
            <div class="form-group">
                <label for="guest_category">Guest Category</label>
                <input type="text" class="form-control" id="guest_category" value="{{ $guest->guest_category }}" readonly>
            </div>
            <div class="form-group">
                <label for="guest_contact">Guest Contact</label>
                <input type="text" class="form-control" id="guest_contact" value="{{ $guest->guest_contact }}" readonly>
            </div>
            <div class="form-group">
                <label for="guest_address">Guest Address</label>
                <input type="text" class="form-control" id="guest_address" value="{{ $guest->guest_address }}" readonly>
            </div>
            <div class="form-group">
                <label for="guest_qr_code">Guest QR Code</label>
                <input type="text" class="form-control" id="guest_qr_code" value="{{ $guest->guest_qr_code }}" readonly>
            </div>
            <div class="form-group">
                <label for="guest_attendance_status">Guest Attendance Status</label>
                <input type="text" class="form-control" id="guest_attendance_status" value="{{ $guest->guest_attendance_status }}" readonly>
            </div>
            <div class="form-group">
                <label for="guest_invitation_status">Guest Invitation Status</label>
                <input type="text" class="form-control" id="guest_invitation_status" value="{{ $guest->guest_invitation_status }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
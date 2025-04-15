<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Invitation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="wedding_name" class="col-sm-4 col-form-label">Wedding Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="wedding_name" value="{{ $invitation->wedding_name }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="groom_name" class="col-sm-4 col-form-label">Groom Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="groom_name" value="{{ $invitation->groom_name }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="bride_name" class="col-sm-4 col-form-label">Bride Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="bride_name" value="{{ $invitation->bride_name }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="wedding_date" class="col-sm-4 col-form-label">Date</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="wedding_date" value="{{ $invitation->wedding_date }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="wedding_time_start" class="col-sm-4 col-form-label">Time Start</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="wedding_time_start"
                        value="{{ $invitation->wedding_time_start }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="wedding_time_end" class="col-sm-4 col-form-label">Time End</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="wedding_time_end"
                        value="{{ $invitation->wedding_time_end }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="wedding_venue" class="col-sm-4 col-form-label">Venue</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="wedding_venue" value="{{ $invitation->wedding_venue }}"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="wedding_location" class="col-sm-4 col-form-label">Location</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="wedding_location"
                        value="{{ $invitation->wedding_location }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="wedding_maps" class="col-sm-4 col-form-label">Maps</label>
                <div class="col-sm-8">
                    <a href="{{ $invitation->wedding_maps }}" target="_blank" class="btn btn-primary btn-sm">View Map</a>
                </div>
            </div>
            <div class="form-group row">
                <label for="wedding_image" class="col-sm-4 col-form-label">Image</label>
                <div class="col-sm-8">
                    @if ($invitation->wedding_image)
                        <div class="spoiler">
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target="#weddingImageSpoiler" aria-expanded="false" aria-controls="weddingImageSpoiler">
                                Show Image
                            </button>
                            <div class="collapse mt-2" id="weddingImageSpoiler">
                                <img src="{{ asset($invitation->wedding_image) }}" alt="Wedding Image" class="img-fluid">
                            </div>
                        </div>
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
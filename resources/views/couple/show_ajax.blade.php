<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Couple</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="couple_name">Couple Name</label>
                <input type="text" class="form-control" id="couple_name" value="{{ $couple->couple_name }}" readonly>
            </div>
            <div class="form-group">
                <label for="couple_alias">Couple Alias</label>
                <input type="text" class="form-control" id="couple_alias" value="{{ $couple->couple_alias }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
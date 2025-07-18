{{-- filepath: d:\Github\Laravel\SKRIPSI\skripsi-manajemen-tamu\resources\views\invitation\show_ajax.blade.php --}}
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Invitation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h3 class="text-center mb-4">Wedding of {{ $invitation->wedding_name }}</h3>
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">Slug:</th>
                    <td class="col-9">{{ $invitation->slug }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Groom:</th>
                    <td class="col-9">{{ $invitation->groom_name }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bride:</th>
                    <td class="col-9">{{ $invitation->bride_name }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Groom Alias:</th>
                    <td class="col-9">{{ $invitation->groom_alias ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Groom Photo:</th>
                    <td class="col-9">
                        @if($invitation->groom_image)
                            <img src="{{ asset($invitation->groom_image) }}" alt="Groom Photo" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                        @else
                            <span class="text-muted">No photo uploaded</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Groom Child Number:</th>
                    <td class="col-9">{{ $invitation->groom_child_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Groom's Father:</th>
                    <td class="col-9">{{ $invitation->groom_father ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Groom's Mother:</th>
                    <td class="col-9">{{ $invitation->groom_mother ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bride Alias:</th>
                    <td class="col-9">{{ $invitation->bride_alias ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bride Photo:</th>
                    <td class="col-9">
                        @if($invitation->bride_image)
                            <img src="{{ asset($invitation->bride_image) }}" alt="Bride Photo" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">
                        @else
                            <span class="text-muted">No photo uploaded</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bride Child Number:</th>
                    <td class="col-9">{{ $invitation->bride_child_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bride's Father:</th>
                    <td class="col-9">{{ $invitation->bride_father ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bride's Mother:</th>
                    <td class="col-9">{{ $invitation->bride_mother ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Date:</th>
                    <td class="col-9">{{ $invitation->wedding_date }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Time Start:</th>
                    <td class="col-9">{{ $invitation->wedding_time_start }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Time End:</th>
                    <td class="col-9">{{ $invitation->wedding_time_end }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Venue:</th>
                    <td class="col-9">{{ $invitation->wedding_venue }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Location:</th>
                    <td class="col-9">{{ $invitation->wedding_location }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Maps:</th>
                    <td class="col-9">
                        <a href="{{ $invitation->wedding_maps }}" target="_blank" class="btn btn-primary btn-sm">View Map</a>
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Wedding Image:</th>
                    <td class="col-9">
                        @if($invitation->wedding_image)
                            <img src="{{ asset($invitation->wedding_image) }}" alt="Wedding Photo" style="max-width: 150px; max-height: 150px;" class="img-thumbnail">
                        @else
                            <span class="text-muted">No photo uploaded</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

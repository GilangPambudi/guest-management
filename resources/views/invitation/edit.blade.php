@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ route('invitation.index') }}">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('invitation.update', $invitation->invitation_id) }}" class="form-horizontal" enctype="multipart/form-data" id="invitation-form">
            @csrf
            @method('PUT')
            
            <!-- Basic Information Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Name</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="wedding_name" name="wedding_name" value="{{ old('wedding_name', $invitation->wedding_name) }}" required placeholder="Auto-generated from groom & bride alias">
                            @error('wedding_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Slug</label>
                        <div class="col-9">
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $invitation->slug) }}" 
                                placeholder="Auto-generated from wedding name">
                            <small class="form-text text-muted">Used for invitation URL. Must be unique.</small>
                            @error('slug')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Groom Name</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="groom_name" name="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" required>
                            @error('groom_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Bride Name</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="bride_name" name="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" required>
                            @error('bride_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Groom Information Section -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Groom Details</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Groom Alias</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="groom_alias" name="groom_alias" value="{{ old('groom_alias', $invitation->groom_alias) }}" required>
                            @error('groom_alias')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Groom Image</label>
                        <div class="col-9">
                            @if($invitation->groom_image)
                                <div class="mb-2">
                                    <img src="{{ asset($invitation->groom_image) }}" alt="Groom Image" class="img-thumbnail" style="max-width: 200px;">
                                    <p class="small text-muted mt-1">Current photo</p>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="groom_image" name="groom_image" accept="image/*">
                            <small class="form-text text-muted">Upload groom photo (JPEG, PNG, JPG, WEBP, max 2MB). Leave empty if you don't want to change.</small>
                            @error('groom_image')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Groom Child Number</label>
                        <div class="col-9">
                            <input type="number" class="form-control" id="groom_child_number" name="groom_child_number" value="{{ old('groom_child_number', $invitation->groom_child_number) }}" min="1" required>
                            <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                            @error('groom_child_number')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Groom Father</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="groom_father" name="groom_father" value="{{ old('groom_father', $invitation->groom_father) }}" required>
                            @error('groom_father')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Groom Mother</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="groom_mother" name="groom_mother" value="{{ old('groom_mother', $invitation->groom_mother) }}" required>
                            @error('groom_mother')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bride Information Section -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bride Details</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Bride Alias</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="bride_alias" name="bride_alias" value="{{ old('bride_alias', $invitation->bride_alias) }}" required>
                            @error('bride_alias')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Bride Image</label>
                        <div class="col-9">
                            @if($invitation->bride_image)
                                <div class="mb-2">
                                    <img src="{{ asset($invitation->bride_image) }}" alt="Bride Image" class="img-thumbnail" style="max-width: 200px;">
                                    <p class="small text-muted mt-1">Current photo</p>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="bride_image" name="bride_image" accept="image/*">
                            <small class="form-text text-muted">Upload bride photo (JPEG, PNG, JPG, WEBP, max 2MB). Leave empty if you don't want to change.</small>
                            @error('bride_image')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Bride Child Number</label>
                        <div class="col-9">
                            <input type="number" class="form-control" id="bride_child_number" name="bride_child_number" value="{{ old('bride_child_number', $invitation->bride_child_number) }}" min="1" required>
                            <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                            @error('bride_child_number')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Bride Father</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="bride_father" name="bride_father" value="{{ old('bride_father', $invitation->bride_father) }}" required>
                            @error('bride_father')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Bride Mother</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="bride_mother" name="bride_mother" value="{{ old('bride_mother', $invitation->bride_mother) }}" required>
                            @error('bride_mother')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wedding Details Section -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Wedding Details</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Date</label>
                        <div class="col-9">
                            <input type="date" class="form-control" id="wedding_date" name="wedding_date" value="{{ old('wedding_date', $invitation->wedding_date) }}" required>
                            @error('wedding_date')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Time Start</label>
                        <div class="col-9">
                            <input type="time" class="form-control" id="wedding_time_start" name="wedding_time_start" value="{{ old('wedding_time_start', $invitation->wedding_time_start) }}" required>
                            @error('wedding_time_start')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Time End</label>
                        <div class="col-9">
                            <input type="time" class="form-control" id="wedding_time_end" name="wedding_time_end" value="{{ old('wedding_time_end', $invitation->wedding_time_end) }}" required>
                            @error('wedding_time_end')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Venue</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="wedding_venue" name="wedding_venue" value="{{ old('wedding_venue', $invitation->wedding_venue) }}" required>
                            @error('wedding_venue')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Location</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="wedding_location" name="wedding_location" value="{{ old('wedding_location', $invitation->wedding_location) }}" required>
                            @error('wedding_location')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Maps (URL)</label>
                        <div class="col-9">
                            <input type="url" class="form-control" id="wedding_maps" name="wedding_maps" value="{{ old('wedding_maps', $invitation->wedding_maps) }}">
                            @error('wedding_maps')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 control-label col-form-label">Wedding Image</label>
                        <div class="col-9">
                            @if($invitation->wedding_image)
                                <div class="mb-2">
                                    <img src="{{ asset($invitation->wedding_image) }}" alt="Wedding Image" class="img-thumbnail" style="max-width: 200px;">
                                    <p class="small text-muted mt-1">Current photo</p>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="wedding_image" name="wedding_image" accept="image/*">
                            <small class="form-text text-muted">Upload wedding photo (JPEG, PNG, JPG, WEBP, max 2MB). Leave empty if you don't want to change.</small>
                            @error('wedding_image')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-3">
                <label class="col-3 control-label col-form-label"></label>
                <div class="col-9">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    <a class="btn btn-sm btn-secondary ml-1" href="{{ route('invitation.index') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('css')
@endpush

@push('js')
<script>
$(document).ready(function() {
    // Function to generate slug
    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9\s&-]/g, '') // Allow & character temporarily
            .replace(/\s*&\s*/g, '-')       // Replace " & " with "-"
            .replace(/\s+/g, '-')           // Replace spaces with hyphens
            .replace(/-+/g, '-')            // Replace multiple hyphens with single
            .replace(/^-+|-+$/g, '')        // Remove leading/trailing hyphens
            .trim();
    }
    
    // Function to update wedding name and slug
    function updateWeddingNameAndSlug() {
        const groomName = $('#groom_name').val();
        const brideName = $('#bride_name').val();
        
        if (groomName && brideName) {
            const groomAlias = groomName.split(' ')[0];
            const brideAlias = brideName.split(' ')[0];
            
            $('#groom_alias').val(groomAlias);
            $('#bride_alias').val(brideAlias);
            
            const weddingName = `${groomAlias} & ${brideAlias}`;
            $('#wedding_name').val(weddingName);
            
            // Auto-generate slug if slug field is empty or if it was auto-generated before
            const currentSlug = $('#slug').val();
            const isAutoGenerated = $('#slug').data('auto-generated');
            
            if (!currentSlug || isAutoGenerated !== false) {
                const slug = generateSlug(weddingName);
                $('#slug').val(slug).data('auto-generated', true);
            }
        }
    }
    
    // Event listeners for groom and bride name inputs
    $('#groom_name, #bride_name').on('input', function() {
        updateWeddingNameAndSlug();
    });
    
    // Allow manual slug editing
    $('#slug').on('input', function() {
        const value = $(this).val();
        const slug = generateSlug(value);
        if (value !== slug) {
            $(this).val(slug);
        }
        // Mark as manually edited
        $(this).data('auto-generated', false);
    });

    // Initialize auto-generated flag for existing slug
    const existingSlug = $('#slug').val();
    if (existingSlug) {
        // Allow existing slug to be updated - mark as auto-generated initially
        $('#slug').data('auto-generated', true); 
    }
    
    // Initialize groom_alias and bride_alias from existing data
    const initialGroomName = $('#groom_name').val();
    const initialBrideName = $('#bride_name').val();
    if (initialGroomName) {
        $('#groom_alias').val(initialGroomName.split(' ')[0]);
    }
    if (initialBrideName) {
        $('#bride_alias').val(initialBrideName.split(' ')[0]);
    }

    // Form validation
    $('#invitation-form').validate({
        rules: {
            wedding_name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            groom_name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            bride_name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            groom_alias: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            groom_image: {
                extension: "jpg|jpeg|png|webp"
            },
            groom_child_number: {
                required: true,
                min: 1
            },
            groom_father: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            groom_mother: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            bride_alias: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            bride_image: {
                extension: "jpg|jpeg|png|webp"
            },
            bride_child_number: {
                required: true,
                min: 1
            },
            bride_father: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            bride_mother: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            wedding_date: {
                required: true
            },
            wedding_time_start: {
                required: true
            },
            wedding_time_end: {
                required: true
            },
            wedding_venue: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            wedding_location: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            wedding_maps: {
                url: true
            },
            wedding_image: {
                extension: "jpg|jpeg|png|webp"
            }
        },
        messages: {
            wedding_name: {
                required: "Wedding name is required",
                minlength: "Wedding name must be at least 3 characters",
                maxlength: "Wedding name cannot exceed 255 characters"
            },
            groom_name: {
                required: "Groom name is required",
                minlength: "Groom name must be at least 3 characters",
                maxlength: "Groom name cannot exceed 255 characters"
            },
            bride_name: {
                required: "Bride name is required",
                minlength: "Bride name must be at least 3 characters",
                maxlength: "Bride name cannot exceed 255 characters"
            },
            groom_alias: {
                required: "Groom alias is required",
                minlength: "Groom alias must be at least 2 characters",
                maxlength: "Groom alias cannot exceed 50 characters"
            },
            groom_image: {
                extension: "File must be in JPG, JPEG, PNG, or WEBP format"
            },
            groom_child_number: {
                required: "Groom child number is required",
                min: "Child number must be at least 1"
            },
            groom_father: {
                required: "Groom father name is required",
                minlength: "Father name must be at least 3 characters",
                maxlength: "Father name cannot exceed 255 characters"
            },
            groom_mother: {
                required: "Groom mother name is required",
                minlength: "Mother name must be at least 3 characters",
                maxlength: "Mother name cannot exceed 255 characters"
            },
            bride_alias: {
                required: "Bride alias is required",
                minlength: "Bride alias must be at least 2 characters",
                maxlength: "Bride alias cannot exceed 50 characters"
            },
            bride_image: {
                extension: "File must be in JPG, JPEG, PNG, or WEBP format"
            },
            bride_child_number: {
                required: "Bride child number is required",
                min: "Child number must be at least 1"
            },
            bride_father: {
                required: "Bride father name is required",
                minlength: "Father name must be at least 3 characters",
                maxlength: "Father name cannot exceed 255 characters"
            },
            bride_mother: {
                required: "Bride mother name is required",
                minlength: "Mother name must be at least 3 characters",
                maxlength: "Mother name cannot exceed 255 characters"
            },
            wedding_date: {
                required: "Wedding date is required"
            },
            wedding_time_start: {
                required: "Wedding start time is required"
            },
            wedding_time_end: {
                required: "Wedding end time is required"
            },
            wedding_venue: {
                required: "Wedding venue is required",
                minlength: "Venue must be at least 3 characters",
                maxlength: "Venue cannot exceed 255 characters"
            },
            wedding_location: {
                required: "Wedding location is required",
                minlength: "Location must be at least 3 characters",
                maxlength: "Location cannot exceed 255 characters"
            },
            wedding_maps: {
                url: "Please enter a valid URL"
            },
            wedding_image: {
                extension: "File must be in JPG, JPEG, PNG, or WEBP format"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    // Form data persistence with localStorage
    const formId = "invitation-form";
    const storageKey = formId + "-edit-data";

    // Function to save form data to localStorage
    function saveFormData() {
        const formData = {};
        $(`#${formId} :input`).each(function() {
            const input = $(this);
            if (input.attr('name')) {
                formData[input.attr('name')] = input.val();
            }
        });
        localStorage.setItem(storageKey, JSON.stringify(formData));
    }

    // Function to load form data from localStorage
    function loadFormData() {
        const savedData = localStorage.getItem(storageKey);
        if (savedData) {
            const formData = JSON.parse(savedData);
            for (const name in formData) {
                $(`#${formId} [name="${name}"]`).val(formData[name]);
            }
            // Trigger update after loading data
            updateWeddingNameAndSlug();
        }
    }

    // Save form data whenever there's a change
    $(`#${formId} :input`).on('input change', function() {
        saveFormData();
    });

    // Remove form data from localStorage when form is successfully submitted
    $(`#${formId}`).on('submit', function() {
        localStorage.removeItem(storageKey);
    });
});
</script>
@endpush

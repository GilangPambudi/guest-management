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
            <form method="POST" action="{{ route('invitation.store') }}" class="form-horizontal"
                enctype="multipart/form-data" id="invitation-form">
                @csrf

                <!-- Basic Information Section -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Wedding Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="wedding_name" name="wedding_name"
                                    value="{{ old('wedding_name') }}" required
                                    placeholder="Auto-generated from groom & bride alias" readonly>
                                @error('wedding_name')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Slug <small
                                    class="text-muted">(optional)</small></label>
                            <div class="col-9">
                                <input type="text" name="slug" id="slug" class="form-control"
                                    value="{{ old('slug') }}" placeholder="Auto-generated from wedding name">
                                <small class="form-text text-muted">Used for invitation URL. Leave empty to
                                    auto-generate.</small>
                                @error('slug')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Groom Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="groom_name" name="groom_name"
                                    value="{{ old('groom_name') }}" required>
                                @error('groom_name')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Bride Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="bride_name" name="bride_name"
                                    value="{{ old('bride_name') }}" required>
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
                                <input type="text" class="form-control" id="groom_alias" name="groom_alias"
                                    value="{{ old('groom_alias') }}" required>
                                @error('groom_alias')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Groom Image</label>
                            <div class="col-9">
                                <input type="file" class="form-control" id="groom_image" name="groom_image"
                                    accept="image/*" required>
                                <small class="form-text text-muted">Upload groom photo (JPEG, PNG, JPG, WEBP, max
                                    2MB)</small>
                                @error('groom_image')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Groom Child Number</label>
                            <div class="col-9">
                                <input type="number" class="form-control" id="groom_child_number" name="groom_child_number"
                                    value="{{ old('groom_child_number') }}" min="1" required>
                                <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                                @error('groom_child_number')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Groom Father</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="groom_father" name="groom_father"
                                    value="{{ old('groom_father') }}" required>
                                @error('groom_father')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Groom Mother</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="groom_mother" name="groom_mother"
                                    value="{{ old('groom_mother') }}" required>
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
                                <input type="text" class="form-control" id="bride_alias" name="bride_alias"
                                    value="{{ old('bride_alias') }}" required>
                                @error('bride_alias')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Bride Image</label>
                            <div class="col-9">
                                <input type="file" class="form-control" id="bride_image" name="bride_image"
                                    accept="image/*" required>
                                <small class="form-text text-muted">Upload bride photo (JPEG, PNG, JPG, WEBP, max
                                    2MB)</small>
                                @error('bride_image')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Bride Child Number</label>
                            <div class="col-9">
                                <input type="number" class="form-control" id="bride_child_number"
                                    name="bride_child_number" value="{{ old('bride_child_number') }}" min="1"
                                    required>
                                <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                                @error('bride_child_number')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Bride Father</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="bride_father" name="bride_father"
                                    value="{{ old('bride_father') }}" required>
                                @error('bride_father')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Bride Mother</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="bride_mother" name="bride_mother"
                                    value="{{ old('bride_mother') }}" required>
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
                                <input type="date" class="form-control" id="wedding_date" name="wedding_date"
                                    value="{{ old('wedding_date') }}" required>
                                @error('wedding_date')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Wedding Time Start</label>
                            <div class="col-9">
                                <input type="time" class="form-control" id="wedding_time_start"
                                    name="wedding_time_start" value="{{ old('wedding_time_start') }}" required>
                                @error('wedding_time_start')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Wedding Time End</label>
                            <div class="col-9">
                                <input type="time" class="form-control" id="wedding_time_end" name="wedding_time_end"
                                    value="{{ old('wedding_time_end') }}" required>
                                @error('wedding_time_end')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Wedding Venue</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="wedding_venue" name="wedding_venue"
                                    value="{{ old('wedding_venue') }}" required>
                                @error('wedding_venue')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Wedding Location</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="wedding_location" name="wedding_location"
                                    value="{{ old('wedding_location') }}" required>
                                @error('wedding_location')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Wedding Maps (URL)</label>
                            <div class="col-9">
                                <input type="url" class="form-control" id="wedding_maps" name="wedding_maps"
                                    value="{{ old('wedding_maps') }}">
                                @error('wedding_maps')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 control-label col-form-label">Wedding Image</label>
                            <div class="col-9">
                                <input type="file" class="form-control" id="wedding_image" name="wedding_image"
                                    accept="image/*" required>
                                <small class="form-text text-muted">Upload wedding photo (JPEG, PNG, JPG, WEBP, max
                                    2MB)</small>
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
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-secondary ml-1" href="{{ route('invitation.index') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - vanilla JS working');
        
        // Get all form elements
        const groomNameInput = document.getElementById('groom_name');
        const brideNameInput = document.getElementById('bride_name');
        const weddingNameInput = document.getElementById('wedding_name');
        const slugInput = document.getElementById('slug');
        const groomAliasInput = document.getElementById('groom_alias');
        const brideAliasInput = document.getElementById('bride_alias');
        
        console.log('Elements found:', {
            groomName: !!groomNameInput,
            brideName: !!brideNameInput,
            weddingName: !!weddingNameInput,
            slug: !!slugInput,
            groomAlias: !!groomAliasInput,
            brideAlias: !!brideAliasInput
        });
        
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
            const groomName = groomNameInput.value.trim();
            const brideName = brideNameInput.value.trim();
            
            console.log('Update triggered - Groom:', groomName, 'Bride:', brideName);
            
            if (groomName && brideName) {
                const groomAlias = groomName.split(' ')[0];
                const brideAlias = brideName.split(' ')[0];
                
                console.log('Generated aliases - Groom:', groomAlias, 'Bride:', brideAlias);
                
                // Update alias fields
                if (groomAliasInput) groomAliasInput.value = groomAlias;
                if (brideAliasInput) brideAliasInput.value = brideAlias;
                
                // Generate wedding name
                const weddingName = `${groomAlias} & ${brideAlias}`;
                console.log('Generated wedding name:', weddingName);
                
                if (weddingNameInput) {
                    weddingNameInput.value = weddingName;
                }
                
                // Auto-generate slug if slug field is empty or if it was auto-generated before
                if (slugInput) {
                    const currentSlug = slugInput.value.trim();
                    const isAutoGenerated = slugInput.dataset.autoGenerated === 'true';
                    
                    if (!currentSlug || isAutoGenerated) {
                        const slug = generateSlug(weddingName);
                        slugInput.value = slug;
                        slugInput.dataset.autoGenerated = 'true';
                        console.log('Generated slug:', slug);
                    }
                }
            }
        }
        
        // Add event listeners
        if (groomNameInput) {
            groomNameInput.addEventListener('input', function() {
                console.log('Groom name input event triggered:', this.value);
                updateWeddingNameAndSlug();
            });
        }
        
        if (brideNameInput) {
            brideNameInput.addEventListener('input', function() {
                console.log('Bride name input event triggered:', this.value);
                updateWeddingNameAndSlug();
            });
        }
        
        // Manual slug editing
        if (slugInput) {
            slugInput.addEventListener('input', function() {
                const value = this.value;
                const cleanSlug = generateSlug(value);
                if (value !== cleanSlug) {
                    this.value = cleanSlug;
                }
                // Mark as manually edited
                this.dataset.autoGenerated = 'false';
                console.log('Slug manually edited:', cleanSlug);
            });
        }
        
        // Form data persistence with localStorage
        const formId = "invitation-form";
        const storageKey = formId + "-data";
        const form = document.getElementById(formId);
        
        // Function to save form data to localStorage
        function saveFormData() {
            if (!form) return;
            
            const formData = {};
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(function(input) {
                if (input.name && input.type !== 'file') { // Exclude file inputs
                    formData[input.name] = input.value;
                }
            });
            
            localStorage.setItem(storageKey, JSON.stringify(formData));
        }
        
        // Function to load form data from localStorage
        function loadFormData() {
            const savedData = localStorage.getItem(storageKey);
            if (savedData && form) {
                try {
                    const formData = JSON.parse(savedData);
                    for (const name in formData) {
                        const input = form.querySelector(`[name="${name}"]`);
                        if (input && input.type !== 'file') { // Don't load file inputs
                            input.value = formData[name];
                        }
                    }
                    // Trigger update after loading data
                    setTimeout(updateWeddingNameAndSlug, 100);
                } catch (e) {
                    console.log('Error loading saved data:', e);
                    localStorage.removeItem(storageKey);
                }
            }
        }
        
        // Load form data when page loads
        loadFormData();
        
        // Save form data whenever there's a change (exclude file inputs)
        if (form) {
            form.addEventListener('input', function(e) {
                if (e.target.type !== 'file') {
                    saveFormData();
                }
            });
            
            form.addEventListener('change', function(e) {
                if (e.target.type !== 'file') {
                    saveFormData();
                }
            });
            
            // Remove form data from localStorage when form is successfully submitted
            form.addEventListener('submit', function() {
                localStorage.removeItem(storageKey);
            });
        }
        
        console.log('All event listeners attached successfully!');
    });
</script>
@endpush

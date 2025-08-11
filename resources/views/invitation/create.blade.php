@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                @if(Auth::user()->role === 'admin')
                    <a class="btn btn-sm btn-primary mt-1" href="{{ route('invitation.index') }}">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                @else
                    <a class="btn btn-sm btn-secondary mt-1" href="{{ url('/dashboard') }}">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                @endif
            </div>
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('invitation.store') }}" class="form-horizontal"
                enctype="multipart/form-data" id="invitation-form">
                @csrf

                <!-- Groom & Bride Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-heart mr-2"></i>Groom & Bride Information
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <!-- Groom Column -->
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h6 class="card-title mb-0 text-primary">
                                    <i class="fas fa-male mr-2"></i>Groom Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="groom_name">Full Name  </label>
                                    <input type="text" class="form-control" id="groom_name" name="groom_name"
                                        value="{{ old('groom_name') }}" required>
                                    @error('groom_name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="groom_alias">Alias/Nickname *</label>
                                    <input type="text" class="form-control" id="groom_alias" name="groom_alias"
                                        value="{{ old('groom_alias') }}" required>
                                    @error('groom_alias')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="groom_child_number">Child Number  </label>
                                    <input type="number" class="form-control" id="groom_child_number" 
                                        name="groom_child_number" value="{{ old('groom_child_number') }}" 
                                        min="1" required>
                                    <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                                    @error('groom_child_number')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="groom_father">Father's Name  </label>
                                    <input type="text" class="form-control" id="groom_father" name="groom_father"
                                        value="{{ old('groom_father') }}" required>
                                    @error('groom_father')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="groom_mother">Mother's Name  </label>
                                    <input type="text" class="form-control" id="groom_mother" name="groom_mother"
                                        value="{{ old('groom_mother') }}" required>
                                    @error('groom_mother')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="groom_image">Photo  </label>
                                    <input type="file" class="form-control" id="groom_image" name="groom_image"
                                        accept="image/*" required>
                                    <small class="form-text text-muted">JPEG, PNG, JPG, WEBP (max 2MB)</small>
                                    @error('groom_image')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bride Column -->
                    <div class="col-md-6">
                        <div class="card card-danger card-outline">
                            <div class="card-header">
                                <h6 class="card-title mb-0 text-danger">
                                    <i class="fas fa-female mr-2"></i>Bride Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="bride_name">Full Name  </label>
                                    <input type="text" class="form-control" id="bride_name" name="bride_name"
                                        value="{{ old('bride_name') }}" required>
                                    @error('bride_name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bride_alias">Alias/Nickname *</label>
                                    <input type="text" class="form-control" id="bride_alias" name="bride_alias"
                                        value="{{ old('bride_alias') }}" required>
                                    @error('bride_alias')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bride_child_number">Child Number  </label>
                                    <input type="number" class="form-control" id="bride_child_number" 
                                        name="bride_child_number" value="{{ old('bride_child_number') }}" 
                                        min="1" required>
                                    <small class="form-text text-muted">Birth order (1st child, 2nd child, etc.)</small>
                                    @error('bride_child_number')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bride_father">Father's Name  </label>
                                    <input type="text" class="form-control" id="bride_father" name="bride_father"
                                        value="{{ old('bride_father') }}" required>
                                    @error('bride_father')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bride_mother">Mother's Name  </label>
                                    <input type="text" class="form-control" id="bride_mother" name="bride_mother"
                                        value="{{ old('bride_mother') }}" required>
                                    @error('bride_mother')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bride_image">Photo  </label>
                                    <input type="file" class="form-control" id="bride_image" name="bride_image"
                                        accept="image/*" required>
                                    <small class="form-text text-muted">JPEG, PNG, JPG, WEBP (max 2MB)</small>
                                    @error('bride_image')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wedding Details -->
                <div class="card card-success card-outline mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 text-success">
                            <i class="fas fa-calendar-alt mr-2"></i>Wedding Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wedding_date">Wedding Date *</label>
                                    <input type="date" class="form-control" id="wedding_date" name="wedding_date"
                                        value="{{ old('wedding_date') }}" required>
                                    @error('wedding_date')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="wedding_time_start">Start Time *</label>
                                    <input type="time" class="form-control" id="wedding_time_start"
                                        name="wedding_time_start" value="{{ old('wedding_time_start') }}" required>
                                    @error('wedding_time_start')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="wedding_time_end">End Time *</label>
                                    <input type="time" class="form-control" id="wedding_time_end" 
                                        name="wedding_time_end" value="{{ old('wedding_time_end') }}" required>
                                    @error('wedding_time_end')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="wedding_venue">Wedding Venue *</label>
                                    <input type="text" class="form-control" id="wedding_venue" name="wedding_venue"
                                        value="{{ old('wedding_venue') }}" required>
                                    @error('wedding_venue')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wedding_location">Wedding Location *</label>
                                    <input type="text" class="form-control" id="wedding_location" 
                                        name="wedding_location" value="{{ old('wedding_location') }}" required>
                                    @error('wedding_location')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="wedding_maps">Google Maps URL</label>
                                    <input type="url" class="form-control" id="wedding_maps" name="wedding_maps"
                                        value="{{ old('wedding_maps') }}" 
                                        placeholder="https://maps.google.com/...">
                                    @error('wedding_maps')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="wedding_image">Wedding Photo *</label>
                                    <input type="file" class="form-control" id="wedding_image" name="wedding_image"
                                        accept="image/*" required>
                                    <small class="form-text text-muted">JPEG, PNG, JPG, WEBP (max 2MB)</small>
                                    @error('wedding_image')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wedding Name & URL -->
                <div class="card card-info card-outline mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 text-info">
                            <i class="fas fa-link mr-2"></i>Wedding Name & URL
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="wedding_name">Wedding Name *</label>
                                    <input type="text" class="form-control" id="wedding_name" name="wedding_name"
                                        value="{{ old('wedding_name') }}" required>
                                    <small class="form-text text-muted">This will be displayed as your wedding title</small>
                                    @error('wedding_name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="slug">Invitation URL Slug *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ url('/') }}/</span>
                                        </div>
                                        <input type="text" name="slug" id="slug" class="form-control"
                                            value="{{ old('slug') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="slug-status">
                                                <i class="fas fa-spinner fa-spin" style="display: none;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        This will be your invitation URL: <strong>{{ url('/') }}/<span id="slug-preview">your-slug</span></strong>
                                    </small>
                                    <div id="slug-feedback"></div>
                                    @error('slug')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Live Preview</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2"><strong>Couple:</strong> 
                                            <span id="preview-couple">-</span>
                                        </p>
                                        <p class="mb-2"><strong>Date:</strong> 
                                            <span id="preview-date">-</span>
                                        </p>
                                        <p class="mb-2"><strong>Venue:</strong> 
                                            <span id="preview-venue">-</span>
                                        </p>
                                        <p class="mb-0"><strong>URL:</strong> 
                                            <span id="preview-url">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg" id="submit-btn">
                                <i class="fas fa-save mr-2"></i>Create Invitation
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
<style>
    .form-section {
        margin-bottom: 2rem;
    }
    
    .section-title {
        border-bottom: 2px solid #f8f9fa;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    #slug-feedback .alert {
        margin-top: 10px;
        margin-bottom: 0;
    }
    
    .suggestion-item {
        cursor: pointer;
        padding: 2px 8px;
        margin: 2px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        display: inline-block;
        font-size: 0.875rem;
    }
    
    .suggestion-item:hover {
        background: #e9ecef;
    }
    
    .preview-card {
        position: sticky;
        top: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Manual invitation form initialized');
    
    // Form elements
    const form = document.getElementById('invitation-form');
    const slugInput = document.getElementById('slug');
    const submitBtn = document.getElementById('submit-btn');
    
    // Variables
    const storageKey = 'invitation-form-data';
    let slugTimeout;
    let isSlugValid = false;
    
    // Slug validation
    if (slugInput) {
        slugInput.addEventListener('input', function() {
            const value = this.value;
            const cleanSlug = generateSlug(value);
            
            if (value !== cleanSlug) {
                this.value = cleanSlug;
            }
            
            clearTimeout(slugTimeout);
            slugTimeout = setTimeout(() => {
                validateSlug(cleanSlug);
            }, 500);
            
            updatePreview();
            saveFormData();
        });
    }
    
    // Preview update for all form inputs
    const formInputs = form.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
        if (input.type !== 'file') {
            input.addEventListener('input', function() {
                updatePreview();
                saveFormData();
            });
            
            input.addEventListener('change', function() {
                updatePreview();
                saveFormData();
            });
        }
    });
    
    // Functions
    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9\s&-]/g, '')
            .replace(/\s*&\s*/g, '-')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '')
            .trim();
    }
    
    async function validateSlug(slug) {
        if (!slug) {
            showSlugFeedback(false, 'Slug cannot be empty');
            return;
        }
        
        showSlugLoading(true);
        
        try {
            const response = await fetch('{{ route("invitation.check-slug") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ slug: slug })
            });
            
            const data = await response.json();
            showSlugLoading(false);
            
            isSlugValid = data.available;
            showSlugFeedback(data.available, data.message, data.suggestions || []);
            updateSubmitButtonState();
            
        } catch (error) {
            console.error('Slug validation error:', error);
            showSlugLoading(false);
            showSlugFeedback(false, 'Error validating slug. Please try again.');
        }
    }
    
    function showSlugLoading(show) {
        const spinner = document.querySelector('#slug-status .fa-spinner');
        const checkIcon = document.querySelector('#slug-status .fa-check');
        const timesIcon = document.querySelector('#slug-status .fa-times');
        
        if (show) {
            if (spinner) spinner.style.display = 'inline-block';
            if (checkIcon) checkIcon.style.display = 'none';
            if (timesIcon) timesIcon.style.display = 'none';
        } else {
            if (spinner) spinner.style.display = 'none';
        }
    }
    
    function showSlugFeedback(isAvailable, message, suggestions = []) {
        const feedback = document.getElementById('slug-feedback');
        const statusIcon = document.getElementById('slug-status');
        
        if (!feedback || !statusIcon) return;
        
        statusIcon.innerHTML = isAvailable 
            ? '<i class="fas fa-check text-success"></i>' 
            : '<i class="fas fa-times text-danger"></i>';
        
        let feedbackHtml = '';
        
        if (isAvailable) {
            feedbackHtml = `<div class="alert alert-success alert-sm">
                <i class="fas fa-check mr-1"></i>${message}
            </div>`;
        } else {
            feedbackHtml = `<div class="alert alert-danger alert-sm">
                <i class="fas fa-exclamation-triangle mr-1"></i>${message}`;
            
            if (suggestions.length > 0) {
                feedbackHtml += `<br><small class="text-muted">Suggestions:</small><br>`;
                suggestions.forEach(suggestion => {
                    feedbackHtml += `<span class="suggestion-item" onclick="useSuggestion('${suggestion}')">${suggestion}</span>`;
                });
            }
            feedbackHtml += '</div>';
        }
        
        feedback.innerHTML = feedbackHtml;
        
        const slugPreview = document.getElementById('slug-preview');
        if (slugPreview) {
            slugPreview.textContent = slugInput.value || 'your-slug';
        }
    }
    
    function updateSubmitButtonState() {
        if (submitBtn) {
            submitBtn.disabled = !isSlugValid;
        }
    }
    
    function updatePreview() {
        const groomAliasInput = document.getElementById('groom_alias');
        const brideAliasInput = document.getElementById('bride_alias');
        const weddingDateInput = document.getElementById('wedding_date');
        const weddingVenueInput = document.getElementById('wedding_venue');
        
        const previewCouple = document.getElementById('preview-couple');
        const previewDate = document.getElementById('preview-date');
        const previewVenue = document.getElementById('preview-venue');
        const previewUrl = document.getElementById('preview-url');
        
        if (groomAliasInput && brideAliasInput && previewCouple) {
            const groomAlias = groomAliasInput.value.trim();
            const brideAlias = brideAliasInput.value.trim();
            previewCouple.textContent = (groomAlias && brideAlias) ? `${groomAlias} & ${brideAlias}` : '-';
        }
        
        if (weddingDateInput && previewDate) {
            previewDate.textContent = weddingDateInput.value ? new Date(weddingDateInput.value).toLocaleDateString() : '-';
        }
        
        if (weddingVenueInput && previewVenue) {
            previewVenue.textContent = weddingVenueInput.value || '-';
        }
        
        if (slugInput && previewUrl) {
            const slug = slugInput.value.trim();
            previewUrl.textContent = slug ? `{{ url('/') }}/${slug}` : '-';
        }
    }
    
    function saveFormData() {
        if (!form) return;
        
        const formData = {};
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            if (input.name && input.type !== 'file') {
                formData[input.name] = input.value;
            }
        });
        
        localStorage.setItem(storageKey, JSON.stringify(formData));
    }
    
    function loadFormData() {
        const savedData = localStorage.getItem(storageKey);
        if (savedData) {
            try {
                const formData = JSON.parse(savedData);
                for (const name in formData) {
                    const input = form.querySelector(`[name="${name}"]`);
                    if (input && input.type !== 'file') {
                        input.value = formData[name];
                    }
                }
                
                setTimeout(() => {
                    updatePreview();
                }, 100);
                
            } catch (e) {
                console.log('Error loading saved data:', e);
                localStorage.removeItem(storageKey);
            }
        }
    }
    
    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            // Only check slug validation, no other auto-validation
            if (slugInput.value && !isSlugValid) {
                e.preventDefault();
                alert('Please fix the slug validation error before submitting.');
                return;
            }
            localStorage.removeItem(storageKey);
        });
    }
    
    // Initialize
    loadFormData();
    
    console.log('Manual invitation form ready!');
});

// Global function for suggestion clicks
function useSuggestion(suggestion) {
    const slugInput = document.getElementById('slug');
    if (slugInput) {
        slugInput.value = suggestion;
        slugInput.dispatchEvent(new Event('input'));
    }
}
</script>
@endpush

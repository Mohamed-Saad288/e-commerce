<!-- resources/views/dashboard/partials/image-favicon-upload.blade.php -->
<h2 class="section-header">{{ __("keys.image_and_favicon") }}</h2>
<div class="row">
    {{-- Logo Image Preview & Upload --}}
    <div class="col-md-6">
        <div class="form-group">
            @if(isset($setting) && url($setting->getFirstMediaUrl('logo')))
                <div class="mb-2">
                    <img src="{{ url($setting->getFirstMediaUrl('logo')) }}" alt="Current Image" class="img-thumbnail"
                         width="100">
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="logo" class="custom-file-input @error('logo') is-invalid @enderror"
                       id="images" {{ !isset($setting) ? 'required' : '' }}>
                <label class="custom-file-label" for="validatedCustomFile">{{ __("keys.choose_logo") }}</label>
                @error('logo')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Favicon Preview & Upload --}}
    <div class="col-md-6">
        <div class="form-group">
            @if(isset($setting) && url($setting->getFirstMediaUrl('favicon')))
                <div class="mb-2">
                    <img src="{{ url($setting->getFirstMediaUrl('favicon')) }}" alt="Current Favicon"
                         class="img-thumbnail" width="100">
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="favicon" class="custom-file-input @error('favicon') is-invalid @enderror"
                       id="faviconFile">
                <label class="custom-file-label" for="faviconFile">{{ __("keys.choose_favicon") }}</label>
                @error('favicon')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    {{-- Additional Image Uploads --}}
    <div class="col-md-6">
        <div class="form-group">
            @if(isset($setting) && url($setting->getFirstMediaUrl('logo2')))
                <div class="mb-2">
                    <img src="{{ url($setting->getFirstMediaUrl('logo2')) }}" alt="Another Logo" class="img-thumbnail"
                         width="100">
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="logo2" class="custom-file-input @error('logo2') is-invalid @enderror"
                       id="anotherLogoFile">
                <label class="custom-file-label" for="anotherLogoFile">{{ __("keys.choose_logo2") }}</label>
                @error('logo2')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            @if(isset($setting) && url($setting->getFirstMediaUrl('footer_image')))
                <div class="mb-2">
                    <img src="{{ url($setting->getFirstMediaUrl('footer_image')) }}" alt="Another Image"
                         class="img-thumbnail" width="100">
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="footer_image"
                       class="custom-file-input @error('footer_image') is-invalid @enderror"
                       id="footer_image">
                <label class="custom-file-label" for="footer_image">{{ __("keys.choose_footer_background") }}</label>
                @error('footer_image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
</div>


<div class="image-preview" id="image-preview"></div>

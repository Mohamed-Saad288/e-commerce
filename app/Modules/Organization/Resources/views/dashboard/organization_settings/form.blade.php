@csrf

{{-- بيانات أساسية --}}
<div class="row">
    {{-- Phone --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">{{ __('messages.phone') }}</label>
            <input type="text" name="phone" id="phone"
                   class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $organization_setting->phone ?? '') }}">
            @error('phone')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Email --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">{{ __('messages.email') }}</label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $organization_setting->email ?? '') }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    {{-- Address --}}
    <div class="col-md-12">
        <div class="form-group">
            <label for="address">{{ __('messages.address') }}</label>
            <input type="text" name="address" id="address"
                   class="form-control @error('address') is-invalid @enderror"
                   value="{{ old('address', $organization_setting->address ?? '') }}">
            @error('address')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- الألوان --}}
<div class="row">
    {{-- Primary Color --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="primary_color">{{ __('messages.primary_color') }}</label>
            <input type="color" name="primary_color" id="primary_color"
                   class="form-control @error('primary_color') is-invalid @enderror"
                   value="{{ old('primary_color', $organization_setting->primary_color ?? '#000000') }}">
            @error('primary_color')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Secondary Color --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="secondary_color">{{ __('messages.secondary_color') }}</label>
            <input type="color" name="secondary_color" id="secondary_color"
                   class="form-control @error('secondary_color') is-invalid @enderror"
                   value="{{ old('secondary_color', $organization_setting->secondary_color ?? '#ffffff') }}">
            @error('secondary_color')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- لينكات السوشيال --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="facebook_link">{{ __('messages.facebook') }}</label>
            <input type="text" name="facebook_link" id="facebook_link"
                   class="form-control @error('facebook_link') is-invalid @enderror"
                   value="{{ old('facebook_link', $organization_setting->facebook_link ?? '') }}">
            @error('facebook_link')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="instagram_link">{{ __('messages.instagram') }}</label>
            <input type="text" name="instagram_link" id="instagram_link"
                   class="form-control @error('instagram_link') is-invalid @enderror"
                   value="{{ old('instagram_link', $organization_setting->instagram_link ?? '') }}">
            @error('instagram_link')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="x_link">{{ __('messages.x_link') }}</label>
            <input type="text" name="x_link" id="x_link"
                   class="form-control @error('x_link') is-invalid @enderror"
                   value="{{ old('x_link', $organization_setting->x_link ?? '') }}">
            @error('x_link')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="tiktok_link">{{ __('messages.tiktok') }}</label>
            <input type="text" name="tiktok_link" id="tiktok_link"
                   class="form-control @error('tiktok_link') is-invalid @enderror"
                   value="{{ old('tiktok_link', $organization_setting->tiktok_link ?? '') }}">
            @error('tiktok_link')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- Lat / Lng --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="lat">{{ __('messages.latitude') }}</label>
            <input type="text" name="lat" id="lat"
                   class="form-control @error('lat') is-invalid @enderror"
                   value="{{ old('lat', $organization_setting->lat ?? '') }}">
            @error('lat')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="lng">{{ __('messages.longitude') }}</label>
            <input type="text" name="lng" id="lng"
                   class="form-control @error('lng') is-invalid @enderror"
                   value="{{ old('lng', $organization_setting->lng ?? '') }}">
            @error('lng')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- Logo في الآخر --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="custom-file">
                <input type="file"
                       name="logo"
                       class="custom-file-input @error('logo') is-invalid @enderror"
                       id="logo"
                       accept="image/*">
                <label class="custom-file-label" for="logo">{{ __('messages.upload_logo') }}</label>
                @error('logo')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            @if(isset($organization_setting) && $organization_setting->logo)
                <div class="mb-3">
                    <img src="{{ asset("storage/$organization_setting->logo") }}"
                         alt="Organization Logo" class="img-thumbnail" width="150">
                </div>
            @endif

            <div id="logo-preview" class="mt-2"></div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>

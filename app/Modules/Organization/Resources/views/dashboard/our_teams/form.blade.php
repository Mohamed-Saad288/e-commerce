@csrf
{{-- Name Fields --}}
<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">{{ __("messages.name") }}</label>
                <input type="text" name="name" id="name"
                       class="form-control @error("name") is-invalid @enderror"
                       value="{{ old("name", isset($our_team) ? $our_team->name : '') }}" required>
                @error("name")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="facebook_link">{{ __("messages.facebook_link") }}</label>
            <input type="text" name="facebook_link" id="facebook_link"
                   class="form-control @error("facebook_link") is-invalid @enderror"
                   value="{{ old("facebook_link", isset($our_team) ? $our_team->facebook_link : '') }}" required>
            @error("facebook_link")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="instagram_link">{{ __("messages.instagram_link") }}</label>
            <input type="text" name="instagram_link" id="instagram_link"
                   class="form-control @error("name") is-invalid @enderror"
                   value="{{ old("instagram_link", isset($our_team) ? $our_team->instagram_link : '') }}" required>
            @error("instagram_link")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="x_link">{{ __("messages.x_link") }}</label>
            <input type="text" name="x_link" id="x_link"
                   class="form-control @error("x_link") is-invalid @enderror"
                   value="{{ old("x_link", isset($our_team) ? $our_team->x_link : '') }}" required>
            @error("x_link")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="tiktok_link">{{ __("messages.tiktok_link") }}</label>
            <input type="text" name="tiktok_link" id="tiktok_link"
                   class="form-control @error("name") is-invalid @enderror"
                   value="{{ old("tiktok_link", isset($our_team) ? $our_team->instagram_link : '') }}" required>
            @error("tiktok_link")
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

<div class="row">
    {{-- Image Upload Section --}}
    <div class="col-md-6">
        <div class="form-group">
            {{-- Show old image if editing --}}


            {{-- Upload new image --}}
            <div class="custom-file">
                <input type="file"
                       name="image"
                       class="custom-file-input @error('image') is-invalid @enderror"
                       id="image"
                       accept="image/*">
                <label class="custom-file-label" for="image">{{ __('messages.upload_image') }}</label>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @if(isset($our_team) &&  $our_team->image )
                <div class="mb-3">
                    <img src="{{ asset("storage/$our_team->image") }}"
                         alt="Header Image" class="img-thumbnail" width="150">
                </div>
            @endif
            {{-- Preview for new selected image --}}
            <div id="image-preview" class="mt-2"></div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>

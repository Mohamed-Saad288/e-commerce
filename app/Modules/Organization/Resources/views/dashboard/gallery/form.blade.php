<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)

    {{-- Gallery Images Preview (Edit Mode) --}}
    @if(isset($gallery) && $gallery->getMedia('images')->count() > 0)
        <div class="mb-3 d-flex flex-wrap">
            @foreach($gallery->getMedia('images') as $image)
                <div class="position-relative mx-2">
                    <img src="{{ $image->getUrl() }}" alt="Gallery Image" class="img-thumbnail" width="100">
                    {{--                    <a href="#" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;">--}}
                    {{--                        ✖--}}
                    {{--                    </a>--}}
                </div>
            @endforeach
        </div>
    @endif

    {{-- Image Upload --}}
    <div class="form-group">
        <label for="images" class="font-weight-bold">{{ __('keys.upload_images') }}</label>
        <input type="file" name="images[]" class="form-control-file @error('images') is-invalid @enderror"
               id="images" multiple accept="image/*">
        @error('images')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Image Preview Container --}}
    <div class="image-preview" id="image-preview"></div>

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>

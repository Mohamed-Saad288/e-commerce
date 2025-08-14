<!-- resources/views/dashboard/partials/contact-social-fields.blade.php -->
<h2 class="section-header">{{ __("keys.contact_social_data") }}</h2>
<div class="row">
    @foreach ($fields as $name => $type)
        <div class="col-md-6">
            <div class="form-group">
                <label for="{{ $name }}" class="font-weight-bold">{{ __("keys.$name") }}</label>
                <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
                       class="form-control @error($name) is-invalid @enderror"
                       value="{{ old($name, $setting->$name ?? '') }}">
                @error($name)
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>

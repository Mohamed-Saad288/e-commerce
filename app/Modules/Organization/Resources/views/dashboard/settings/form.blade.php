<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
    @csrf
    @method($method)


    @include('dashboard.settings.title-fields')
    @include('dashboard.settings.footer-descriptions')
    @include('dashboard.settings.contact-social-fields')
    @include('dashboard.settings.image-favicon-upload')

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('keys.submit') }}</button>
    </div>
</form>



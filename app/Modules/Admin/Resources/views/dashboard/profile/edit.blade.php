@extends('dashboard.master')
@section('title', __('keys.profile'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <h2 class="h3 mb-4 page-title">{{ __('setting.settings') }}</h2>
                <div class="my-4">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#" role="tab"
                                aria-controls="home" aria-selected="true">{{ __('keys.profile') }}</a>
                        </li>
                    </ul>

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-5 align-items-center">
                            <div class="col-md-3 text-center mb-5">
                                <div class="avatar avatar-xl">
                                    <img src="{{ auth()->user()->getProfileImageUrl() }}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="form-row">
                            <!-- NAME -->
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('keys.name') }}</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ old('name', auth()->user()->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- PHONE -->
                            <div class="form-group col-md-6">
                                <label for="phone">{{ __('keys.phone') }}</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ old('phone', auth()->user()->phone) }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- EMAIL -->
                            <div class="form-group col-md-12">
                                <label for="email">{{ __('keys.email') }}</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- PASSWORD -->
                            <div class="form-group col-md-6">
                                <label for="password">{{ __('keys.password') }}</label>
                                <input type="password" id="password" name="password" class="form-control">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <div class="form-group col-md-6">
                                <label for="password_confirmation">{{ __('keys.confirm_password') }}</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- PROFILE IMAGE -->
                            <div class="col-md-6">
                                <div class="custom-file mb-3">
                                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                                           id="validatedCustomFile" accept="image/*" onchange="previewImage(event)">
                                    <label class="custom-file-label" for="validatedCustomFile">{{ __('keys.profile_image') }}</label>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-primary">{{ __('keys.save_changes') }}</button>
                    </form>
                </div> <!-- /.card-body -->
            </div> <!-- /.col-12 -->
        </div>
    </div>
@endSection

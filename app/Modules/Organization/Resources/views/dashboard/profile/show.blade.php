@extends('dashboard.master')
@section('title', __('keys.profile'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <h2 class="h3 mb-4 page-title">{{ __('keys.profile') }}</h2>
                <div class="my-4">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#" role="tab"
                               aria-controls="home" aria-selected="true">{{ __('keys.profile') }}</a>
                        </li>
                    </ul>


                    <div class="row mt-5 align-items-center">
                        <div class="col-md-3 text-center mb-5">
                            <div class="avatar avatar-xl">
                                <img src="{{$user->getProfileImageUrl() }}" alt="..."
                                     class="avatar-img rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <h4 class="mb-1">{{$user->name}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="form-row">
                        <!-- NAME -->
                        <div class="form-group col-md-4">
                            <label for="name">{{ __('keys.name') }}</label>
                            <input  id="name" name="name" class="form-control"
                                   value="{{$user->name}}" readonly>
                        </div>

                        <!-- PHONE -->
                        <div class="form-group col-md-4">
                            <label for="phone">{{ __('keys.phone') }}</label>
                            <input  id="phone" name="phone" class="form-control"
                                   value="{{ $user->phone }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="role">{{ __('keys.role') }}</label>
                            <input  id="role" name="role" class="form-control"
                                    value="{{ implode(", ", $user->roles->pluck('name')->toArray() ?? "") }}" readonly>
                        </div>

                    </div>




                    <div class="form-row">
                        <!-- EMAIL -->
                        <div class="form-group col-md-12">
                            <label for="email">{{ __('keys.email') }}</label>
                            <input  id="email" name="email" class="form-control"
                                   value="{{ $user->email }}" readonly>
                        </div>
                    </div>


                    <hr class="my-4">


                </div> <!-- /.card-body -->
            </div> <!-- /.col-12 -->
        </div>
    </div>
@endSection

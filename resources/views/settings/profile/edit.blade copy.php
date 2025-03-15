@extends('layout.main')

@section('container')
<div class="container-fluid">
    @include('settings.profile.partials.background-profile')

    <div class="row px-3">
        @include('settings.profile.partials.left-profile')

        <div class="col-lg-8 card-profile">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <!-- begin: Navbar Profile -->
                    @include('settings.profile.partials.navbar-profile')
                    <!-- end: Navbar Profile -->

                    <!-- begin: Edit Profile -->
                    @include('settings.profile.partials.edit-profile-form')
                    <!-- end: Edit Profile -->
                </div>
            </div>
        </div>
    </div>
</div>


@include('components.preview-img-form')
@endsection

@extends('layout.main')

@section('container')
<div class="container-fluid">
    @include('settings.profile.partials.navbar-profile')

    @include('settings.profile.edit.show-profile')
</div>
@include('components.preview-img-form')
@endsection

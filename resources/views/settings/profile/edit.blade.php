@extends('layout.main')

@section('container')
<div class="container-fluid">
    @include('settings.profile.partials.navbar-profile')

    @include('settings.profile.partials.edit-profile-form')
</div>
@include('components.preview-img-form')
@endsection

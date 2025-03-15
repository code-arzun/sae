@extends('layout.main')

@section('container')
<div class="container-fluid">
    @include('settings.profile.partials.navbar-profile')

    @include('settings.profile.partials.show-profile')
</div>
@endsection

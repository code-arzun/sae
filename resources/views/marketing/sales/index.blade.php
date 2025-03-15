@extends('layout.main')

@section('container')

<h2>Data Sales</h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-default-icon">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home-2"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('sales') }}">Data Sales</a></li>
    </ol>
</nav>

<!-- Data -->
<div class="col-lg-12">
    <ul class="nav nav-tabs mb-1" id="sales" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h6><i class="ti ti-table me-2"></i>Semua</h6></a>
        </li>
        @foreach ($sales as $salerep)
            <li class="nav-item">
                <a class="nav-link" id="detail-tab-{{ $salerep->id }}" data-bs-toggle="tab" href="#detail-{{ $salerep->id }}" role="tab">
                    <h6><i class="ti ti-table me-2"></i>{{ $salerep->name }}</h6>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="salesContent">
        <!-- All -->
        @include('marketing.sales.partials.all')
        <!-- Sales -->
        @include('marketing.sales.partials.detail')
    </div>
</div>

@endsection
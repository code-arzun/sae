@extends('layout.main')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('sales') }}">Data Sales</a></li>
@endsection

@section('container')

<!-- Data -->
<div class="col-lg-12">
    <ul class="nav nav-tabs mb-3" id="sales" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"><h6><i class="ti ti-table me-2"></i>Semua</h6></a>
        </li>
        @foreach ($sales as $salesrep)
            <li class="nav-item">
                <a class="nav-link" id="detail-tab-{{ $salesrep->id }}" data-bs-toggle="tab" href="#detail-{{ $salesrep->id }}" role="tab">
                    <h6><i class="ti ti-table me-2"></i>{{ $salesrep->name }}</h6>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="salesContent">
        <!-- All -->
        @include('marketing.sales.partials.all')
        <!-- Sales -->
        {{-- @include('marketing.sales.partials.detail') --}}
        @include('marketing.sales.partials.detail', ['salesrep' => $salesrep])
    </div>
</div>

@endsection